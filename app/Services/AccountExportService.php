<?php

namespace App\Services;

use App\Models\Organisation;
use Illuminate\Support\Facades\Storage;

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
                    'password_encrypted' => $account->password,
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

        // ── CHIFFREMENT PAR MOT DE PASSE (portable, indépendant de APP_KEY) ──
        if ($withPasswordEncryption && $userPassword) {
            $json = json_encode($payload);
            $encrypted = $this->encryptWithPassword($json, $userPassword);

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

    /**
     * Chiffrement AES-256-GCM + PBKDF2 (100 000 itérations)
     */
    private function encryptWithPassword(string $plainText, string $password): string
    {
        $salt = random_bytes(16);
        $key = hash_pbkdf2('sha256', $password, $salt, 100000, 32, true);
        $iv = random_bytes(12);
        $tag = '';

        $cipherText = openssl_encrypt(
            $plainText,
            'aes-256-gcm',
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag,
            '',
            16
        );

        if ($cipherText === false) {
            throw new \RuntimeException('Échec du chiffrement.');
        }

        return base64_encode($salt . $iv . $tag . $cipherText);
    }
}