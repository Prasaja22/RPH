<?php

namespace App\Imports;

use App\Models\Order;
use App\Models\Partnumber;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\ValidationException;

class OrderImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // Temukan partnumber berdasarkan item_id
        $partnumber = Partnumber::where('item_id', $row['item_id'])->first();

        if (!$partnumber) {
            throw ValidationException::withMessages([
                'item_id' => ['Item Id not found: ' . $row['item_id']],
            ]);
        }

        return new Order([
            'itemid' => $partnumber->id,
            'customer' => $row['customer'],
            'date' => $row['date'],
            'jumlah_order' => $row['jumlah_order'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.item_id' => ['required', 'exists:partnumber,item_id'],
            '*.jumlah_order' => ['required', 'numeric'],
        ];
    }
}


