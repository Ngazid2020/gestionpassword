<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrganisationResource\Pages;
use App\Models\Organisation;
use App\Services\AccountExportService;
use App\Services\AccountImportService;
use Filament\Forms;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrganisationResource extends Resource
{
    protected static ?string $model = Organisation::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static bool $isScopedToTenant = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Toggle::make('active'),

                Forms\Components\Section::make('Abonnement')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('plan')
                            ->label('Plan')
                            ->options([
                                'starter'    => 'Starter',
                                'pro'        => 'Pro',
                                'enterprise' => 'Enterprise',
                            ])
                            ->default('starter')
                            ->required(),

                        Forms\Components\Select::make('subscription_status')
                            ->label('Statut')
                            ->options([
                                'trial'     => '⏳ Essai gratuit',
                                'active'    => '✅ Actif',
                                'expired'   => '❌ Expiré',
                                'cancelled' => '🚫 Annulé',
                            ])
                            ->required(),

                        Forms\Components\DateTimePicker::make('trial_ends_at')
                            ->label('Fin de la période d\'essai')
                            ->nullable(),

                        Forms\Components\DateTimePicker::make('subscription_ends_at')
                            ->label('Fin d\'abonnement')
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Organisation')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\BadgeColumn::make('plan')
                    ->label('Plan')
                    ->colors([
                        'gray'    => 'starter',
                        'primary' => 'pro',
                        'warning' => 'enterprise',
                    ])
                    ->formatStateUsing(fn($state) => ucfirst($state)),

                Tables\Columns\BadgeColumn::make('subscription_status')
                    ->label('Statut')
                    ->colors([
                        'info'    => 'trial',
                        'success' => 'active',
                        'danger'  => 'expired',
                        'gray'    => 'cancelled',
                    ])
                    ->formatStateUsing(fn(Organisation $record) => $record->subscriptionStatusLabel()),

                Tables\Columns\TextColumn::make('subscription_ends_at')
                    ->label('Expire le')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('payments_count')
                    ->label('Paiements')
                    ->counts('payments')
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('active')
                    ->label('Active')
                    ->boolean()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créée le')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('subscription_status')
                    ->label('Statut')
                    ->options([
                        'trial'     => 'Essai gratuit',
                        'active'    => 'Actif',
                        'expired'   => 'Expiré',
                        'cancelled' => 'Annulé',
                    ]),

                Tables\Filters\SelectFilter::make('plan')
                    ->options([
                        'starter'    => 'Starter',
                        'pro'        => 'Pro',
                        'enterprise' => 'Enterprise',
                    ]),
            ])

            // ═══════════════════════════════════════════════════════════════
            // ACTIONS GLOBALES (header) — export/import avec choix d'organisation
            // ═══════════════════════════════════════════════════════════════
            ->headerActions([
                Action::make('export')
                    ->label('Exporter les comptes')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->requiresConfirmation()
                    ->modalDescription('Exporter tous les comptes et catégories d\'une organisation.')
                    ->form([
                        Forms\Components\Select::make('organisation_id')
                            ->label('Organisation')
                            ->options(Organisation::pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\Toggle::make('with_password')
                            ->label('Protéger par un mot de passe')
                            ->default(false)
                            ->live(),
                        Forms\Components\TextInput::make('password')
                            ->label('Mot de passe de protection')
                            ->password()
                            ->required(fn($get) => $get('with_password'))
                            ->visible(fn($get) => $get('with_password')),
                    ])
                    ->action(function (array $data) {
                        $organisation = Organisation::findOrFail($data['organisation_id']);

                        $service = app(AccountExportService::class);
                        $path = $service->export(
                            $organisation,
                            $data['with_password'] ?? false,
                            $data['password'] ?? null
                        );

                        return response()->download($path)->deleteFileAfterSend();
                    }),

                Action::make('import')
                    ->label('Importer des comptes')
                    ->icon('heroicon-m-arrow-up-tray')
                    ->color('gray')
                    ->modalSubmitActionLabel('Importer maintenant')
                    ->form([
                        Forms\Components\Select::make('organisation_id')
                            ->label('Organisation')
                            ->options(Organisation::pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\FileUpload::make('file')
                            ->label('Fichier JSON')
                            ->acceptedFileTypes(['application/json'])
                            ->required()
                            ->disk('local')
                            ->directory('imports'),
                        Forms\Components\TextInput::make('password')
                            ->label('Mot de passe (si chiffré)')
                            ->password(),
                    ])
                    ->action(function (array $data) {
                        try {
                            $organisation = Organisation::findOrFail($data['organisation_id']);
                            $filePath = $data['file'];
                            $fullPath = Storage::disk('local')->path($filePath);

                            \Log::info('Import header debug', [
                                'filePath' => $filePath,
                                'fullPath' => $fullPath,
                                'exists'   => file_exists($fullPath),
                            ]);

                            if (!file_exists($fullPath)) {
                                throw new \RuntimeException('Fichier introuvable : ' . $fullPath);
                            }

                            $service = app(AccountImportService::class);
                            $stats = $service->import($organisation, $fullPath, $data['password'] ?? null);

                            Storage::disk('local')->delete($filePath);

                            Notification::make()
                                ->title('✅ Import terminé')
                                ->body("{$stats['accounts']} comptes importés, {$stats['categories']} catégories, {$stats['skipped']} doublons ignorés.")
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('❌ Erreur lors de l\'import')
                                ->body($e->getMessage())
                                ->danger()
                                ->persistent()
                                ->send();
                        }
                    }),
            ])

            // ═══════════════════════════════════════════════════════════════
            // ACTIONS PAR LIGNE — PAS de Select organisation_id, on a déjà $record
            // ═══════════════════════════════════════════════════════════════
            ->actions([
                Action::make('import_row')
                    ->label('Importer')
                    ->icon('heroicon-m-arrow-up-tray')
                    ->color('gray')
                    ->modalSubmitActionLabel('Importer maintenant')
                    ->form([
                        Forms\Components\FileUpload::make('file')
                            ->label('Fichier JSON')
                            ->acceptedFileTypes(['application/json'])
                            ->required()
                            ->disk('local')
                            ->directory('imports'),
                        Forms\Components\TextInput::make('password')
                            ->label('Mot de passe (si chiffré)')
                            ->password(),
                    ])
                    // ⚠️ SIGNATURE CORRIGÉE : Organisation $record en premier !
                    ->action(function (Organisation $record, array $data) {
                        try {
                            $filePath = $data['file'];
                            $fullPath = Storage::disk('local')->path($filePath);

                            \Log::info('Import row debug', [
                                'org_id'   => $record->id,
                                'filePath' => $filePath,
                                'fullPath' => $fullPath,
                                'exists'   => file_exists($fullPath),
                            ]);

                            if (!file_exists($fullPath)) {
                                throw new \RuntimeException('Fichier introuvable : ' . $fullPath);
                            }

                            $service = app(AccountImportService::class);
                            $stats = $service->import($record, $fullPath, $data['password'] ?? null);

                            Storage::disk('local')->delete($filePath);

                            Notification::make()
                                ->title('✅ Import terminé')
                                ->body("{$stats['accounts']} comptes importés, {$stats['categories']} catégories, {$stats['skipped']} doublons ignorés.")
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('❌ Erreur lors de l\'import')
                                ->body($e->getMessage())
                                ->danger()
                                ->persistent()
                                ->send();
                        }
                    }),

                Action::make('record_payment')
                    ->label('Encaisser')
                    ->icon('heroicon-o-banknotes')
                    ->color('success')
                    ->modalHeading(fn(Organisation $record) => "Paiement — {$record->name}")
                    ->modalDescription('Enregistrez le paiement reçu et choisissez la durée d\'abonnement.')
                    ->modalWidth('lg')
                    ->form([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\Select::make('plan')
                                ->label('Plan souscrit')
                                ->options([
                                    'starter'    => 'Starter — Gratuit',
                                    'pro'        => 'Pro — 10 000 KMF/mois',
                                    'enterprise' => 'Enterprise — Sur devis',
                                ])
                                ->default(fn(Organisation $record) => $record->plan)
                                ->required(),

                            Forms\Components\Select::make('duration_months')
                                ->label('Durée')
                                ->options([
                                    1  => '1 mois',
                                    3  => '3 mois',
                                    6  => '6 mois',
                                    12 => '1 an',
                                ])
                                ->default(1)
                                ->required(),

                            Forms\Components\Select::make('payment_method')
                                ->label('Mode de paiement')
                                ->options([
                                    'cash'          => '💵 Espèces',
                                    'bank_transfer' => '🏦 Virement bancaire',
                                ])
                                ->default('cash')
                                ->required(),

                            Forms\Components\TextInput::make('amount')
                                ->label('Montant encaissé')
                                ->numeric()
                                ->suffix('KMF')
                                ->required()
                                ->minValue(0),
                        ]),

                        Forms\Components\Textarea::make('notes')
                            ->label('Notes / Référence virement')
                            ->placeholder('Ex : Réf. virement VIR2024-001, reçu n°42...')
                            ->rows(2)
                            ->nullable(),
                    ])
                    ->action(function (Organisation $record, array $data): void {
                        $record->recordPayment($data, Auth::id());

                        Notification::make()
                            ->title('✅ Paiement enregistré')
                            ->body("Abonnement de {$record->name} renouvelé pour {$data['duration_months']} mois.")
                            ->success()
                            ->send();
                    }),

                Action::make('payment_history')
                    ->label('Historique')
                    ->icon('heroicon-o-clock')
                    ->color('gray')
                    ->modalHeading(fn(Organisation $record) => "Historique — {$record->name}")
                    ->modalContent(function (Organisation $record) {
                        $payments = $record->payments()->with('recordedBy')->latest('paid_at')->get();
                        return view('filament.modals.payment-history', compact('payments'));
                    })
                    ->modalFooterActions([])
                    ->modalWidth('2xl'),

                Action::make('suspend')
                    ->label('Suspendre')
                    ->icon('heroicon-o-no-symbol')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Suspendre cet abonnement ?')
                    ->modalDescription('L\'organisation n\'aura plus accès à l\'application.')
                    ->action(function (Organisation $record): void {
                        $record->update([
                            'subscription_status' => 'cancelled',
                            'active'              => false,
                        ]);

                        Notification::make()
                            ->title('Organisation suspendue')
                            ->warning()
                            ->send();
                    })
                    ->visible(fn(Organisation $record) => $record->hasActiveAccess()),

                Tables\Actions\EditAction::make()->label('Modifier'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function canAccess(): bool
    {
        return true;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOrganisations::route('/'),
            'create' => Pages\CreateOrganisation::route('/create'),
            'edit'   => Pages\EditOrganisation::route('/{record}/edit'),
        ];
    }
}