<?php

namespace App\Imports;

use App\Models\Datastock;
use App\Models\Partnumber;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\ValidationException;

class DatastockImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        // Temukan tim berdasarkan nama
        $itemId = Partnumber::where('item_id', $row['item_id'])->first();

        if (!$itemId) {
            // Jika tim tidak ditemukan, lemparkan pengecualian
            throw ValidationException::withMessages([
                'item_id' => ['Item id not found: ' . $row['item_id']],
            ]);
        }

        $stock = !empty($row['stock']) ? $row['stock'] : 0;

        return new Datastock([
            'partnumber_id' => $itemId->id,
            'date' => $row['date'],
            'stock' => $stock,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.item_id' => ['required', 'exists:partnumber,item_id'],
        ];
    }
}
