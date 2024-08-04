<?php

namespace App\Imports;

use App\Models\Lotnumber;
use App\Models\Partnumber;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\ValidationException;

class LotnumberImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        // Temukan tim berdasarkan nama
        $partnumber = Partnumber::where('partnumber', $row['partnumber'])->first();

        if (!$partnumber) {
            // Jika tim tidak ditemukan, lemparkan pengecualian
            throw ValidationException::withMessages([
                'partnumber' => ['Team not found: ' . $row['partnumber']],
            ]);
        }

        return new Lotnumber([
            'partnumber_id' => $partnumber->id,
            'lotnumber' => $row['lotnumber'],
            'qty' => $row['qty'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.partnumber' => ['required', 'exists:partnumber,partnumber'],
        ];
    }
}
