<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountResource\Pages;
use App\Models\Account;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * 🔒 Multitenancy : filtre par organisation connectée
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('organisation_id', filament()->getTenant()->id);
    }

    /**
     * 📝 FORM
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('url')
                    ->maxLength(255),

                Forms\Components\TextInput::make('identifiant')
                    ->label('Identifiant / Email')
                    ->required()
                    ->maxLength(255)
                    ->suffixAction(
                        Action::make('copy')
                            ->icon('heroicon-o-clipboard')
                            ->tooltip('Copier')
                            ->extraAttributes([
                                'x-on:click.stop' => '
                                    let value = $el.closest(".fi-input-wrp").querySelector("input").value;
                                    navigator.clipboard.writeText(value);
                                ',
                            ])
                    ),

                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),

                Forms\Components\Select::make('category_id')
                    ->label('Catégorie')
                    ->relationship(
                        'category',
                        'name',
                        fn(Builder $query) => $query
                            ->where('organisation_id', filament()->getTenant()->id)
                    )
                    ->required(),

                Hidden::make('user_id')
                    ->default(fn() => auth()->id()),
            ]);
    }

    /**
     * 📊 TABLE
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('url')
                    ->searchable(),

                Tables\Columns\TextColumn::make('identifiant')
                    ->label('Identifiant')
                    ->searchable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Catégorie')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    /**
     * 🔐 Injecte automatiquement l'organisation à la création
     */
    protected static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['organisation_id'] = filament()->getTenant()->id;

        return $data;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccounts::route('/'),
            // 'create' => Pages\CreateAccount::route('/create'),
            // 'edit' => Pages\EditAccount::route('/{record}/edit'),
        ];
    }
}
