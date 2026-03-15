<?php

namespace App\Imports;

use App\Models\Account;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class AccountImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {

        foreach ($collection as $index => $row) {
            if ($index === 0) continue; // ignorer les en-têtes

            Account::create([
                'name'        => $row[0],
                'url' => $row[1],
                'identifiant' => $row[2],
                'password'    => $row[3],
                'notes' => $row[4],
                'user_id'     => auth()->user()->id, // ✅ injecté automatiquement
                'organisation_id' => auth()->user()->organisations()->first()->id,
            ]);
        }
    }
}
