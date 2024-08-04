<?php

namespace App\Imports;

use App\Models\Manpower;
use App\Models\Teams;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\ValidationException;

class ManpowerImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        // Temukan tim berdasarkan nama
        $team = Teams::where('name', $row['team_name'])->first();

        if (!$team) {
            // Jika tim tidak ditemukan, lemparkan pengecualian
            throw ValidationException::withMessages([
                'team_name' => ['Team not found: ' . $row['team_name']],
            ]);
        }

        return new Manpower([
            'noreg' => $row['noreg'],
            'name' => $row['name'],
            'team_id' => $team->id,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.team_name' => ['required', 'exists:teams,name'],
        ];
    }
}
