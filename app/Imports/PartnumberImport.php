<?php

namespace App\Imports;

use App\Models\Partnumber;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PartnumberImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new Partnumber([
            'item_id' => $row['item_id'],
            'partnumber' => $row['part_number'],
        ]);
    }
}
