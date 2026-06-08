<?php

namespace App\Services;

use App\Models\Organisation;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class AccountExportService
{
    public function export(Organisation $organisation, bool $withPasswordEncryption = true, ?string $userPassword = null): string
    {
        $categories = $organisation->categories()
            ->select('id', 'name')
            ->get();

        $accounts = $organisation->accounts()
            ->with('category:id,name')
            ->get()
            ->map(function ($account) {
                return [
                    'id' => $account->id,
                    'category_id' => $account->category_id,
                    'name' => $account->name,
                    'username' => $account->username,
                    'password_encrypted' => $account->password, // déjà chiffré par le cast
                    'user_id' => $account->user_id,
                    'url' => $account->url,
                    'identifiant' => $account->identifiant,
                    'notes' => $account->notes,
                    'created_at' => $account->created_at->toIso8601String(),
                    'updated_at' => $account->updated_at->toIso8601String(),
                ];
            });

        $payload = [
            'meta' => [
                'version' => '1.0',
                'exported_at' => now()->toIso8601String(),
                'organisation_id' => $organisation->id,
                'organisation_name' => $organisation->name,
                'encrypted' => false,
                'record_counts' => [
                    'categories' => $categories->count(),
                    'accounts' => $accounts->count(),
                ],
            ],
            'categories' => $categories,
            'accounts' => $accounts,
        ];

        // Chiffrement optionnel avec mot de passe utilisateur
        if ($withPasswordEncryption && $userPassword) {
            $json = json_encode($payload);
            $encrypted = Crypt::encryptString($json); // ou openssl avec PBKDF2
            $payload = [
                'meta' => [
                    'version' => '1.0',
                    'encrypted' => true,
                    'organisation_name' => $organisation->name,
                ],
                'data' => $encrypted,
            ];
        }

        $filename = 'lakile-export-' . $organisation->slug . '-' . now()->format('Y-m-d-His') . '.json';
        $path = 'exports/' . $filename;

        Storage::disk('local')->put($path, json_encode($payload, JSON_PRETTY_PRINT));

        return Storage::disk('local')->path($path);
    }
}