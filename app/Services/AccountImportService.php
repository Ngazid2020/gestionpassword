<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Category;
use App\Models\Organisation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AccountImportService
{
    public function import(Organisation $organisation, string $filePath, ?string $userPassword = null): array
    {
        $content = file_get_contents($filePath);
        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Fichier JSON invalide.');
        }

        // ── DÉCHIFFREMENT PAR MOT DE PASSE (portable, indépendant de APP_KEY) ──
        if ($data['meta']['encrypted'] ?? false) {
            if (!$userPassword) {
                throw new \RuntimeException('Ce fichier est protégé par un mot de passe.');
            }
            try {
                $decrypted = $this->decryptWithPassword($data['data'], $userPassword);
                $data = json_decode($decrypted, true);
            } catch (\Exception $e) {
                throw new \RuntimeException('Mot de passe incorrect ou fichier corrompu.');
            }
        }

        // Validation structure
        $validator = Validator::make($data, [
            'meta.version' => 'required|string',
            'categories' => 'nullable|array',
            'categories.*.name' => 'required|string|max:255',
            'accounts' => 'required|array',
            'accounts.*.name' => 'required|string|max:255',
            'accounts.*.name' => 'nullable|string',
            'accounts.*.password_encrypted' => 'required|string',
            'accounts.*.url' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        return DB::transaction(function () use ($organisation, $data) {
            $stats = ['categories' => 0, 'accounts' => 0, 'skipped' => 0];
            $categoryMap = []; // map old_id => new_id

            // Import des catégories
            foreach ($data['categories'] ?? [] as $catData) {
                $category = $organisation->categories()->firstOrCreate(
                    ['name' => $catData['name']],
                    [
                        'color' => $catData['color'] ?? '#6b7280',
                        'icon' => $catData['icon'] ?? null,
                        'description' => $catData['description'] ?? null,
                    ]
                );
                $categoryMap[$catData['id']] = $category->id;
                $stats['categories']++;
            }

            // Import des comptes
            foreach ($data['accounts'] as $accData) {
                $exists = $organisation->accounts()
                    ->where('name', $accData['name'])
                    ->where('name', $accData['name'])
                    ->exists();

                if ($exists) {
                    $stats['skipped']++;
                    continue;
                }

                Account::create([
                    'organisation_id' => $organisation->id,
                    'category_id' => $categoryMap[$accData['category_id']] ?? null,
                    'identifiant' => $accData['identifiant'],
                    'name' => $accData['name'],
                    'password' => $accData['password_encrypted'],
                    'url' => $accData['url'],
                    'notes' => $accData['notes'] ?? null,
                    'user_id' => $accData['user_id'],
                ]);

                $stats['accounts']++;
            }

            return $stats;
        });
    }

    /**
     * Déchiffrement AES-256-GCM + PBKDF2 (100 000 itérations)
     */
    private function decryptWithPassword(string $encodedData, string $password): string
    {
        $raw = base64_decode($encodedData, true);

        if ($raw === false || strlen($raw) < 44) {
            throw new \RuntimeException('Données chiffrées invalides.');
        }

        $salt = substr($raw, 0, 16);
        $iv = substr($raw, 16, 12);
        $tag = substr($raw, 28, 16);
        $cipherText = substr($raw, 44);

        $key = hash_pbkdf2('sha256', $password, $salt, 100000, 32, true);

        $decrypted = openssl_decrypt(
            $cipherText,
            'aes-256-gcm',
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        if ($decrypted === false) {
            throw new \RuntimeException('Échec du déchiffrement.');
        }

        return $decrypted;
    }
}