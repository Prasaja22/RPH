<?php

namespace App\Http\Controllers;

use App\Imports\PartnumberImport;
use App\Models\Datastock;
use App\Models\Lotnumber;
use App\Models\Order;
use App\Models\Partnumber;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PHPUnit\Framework\Attributes\BackupGlobals;
use PHPUnit\Framework\MockObject\Stub\ReturnReference;

class PartnumberController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Partnumber::create([
            'item_id' => $request->input('itemid'),
            'partnumber' => $request->input('partnumber'),
        ]);

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function importExcelPartNumber(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        try {
            Excel::import(new PartnumberImport(), $request->file('file'));
            return redirect()->back()->with('success', 'Partnumber imported successfully.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return redirect()->back()->withErrors($errorMessages);
        }
    }

    public function update(Request $request, string $id){

        Partnumber::findOrFail($id)->update([
            'item_id' => $request->input('itemid'),
            'partnumber' => $request->input('partnumber'),
        ]);

        return back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         // Temukan partnumber
        $partnumber = Partnumber::findOrFail($id);

        // Hapus entri yang bergantung
        $partnumber->datastock()->delete();

        // Hapus partnumber
        $partnumber->delete();

        return back()->with('success', 'Partnumber deleted successfully.');
    }

    public function destroyAll(){
        // Hapus semua entri di datastock yang terkait dengan partnumber
        // Hapus semua entri di lotnumber yang terkait dengan partnumber
        Lotnumber::query()->delete();

        // Hapus semua entri di datastock yang terkait dengan partnumber
        Datastock::query()->delete();

        // Hapus semua entri di order yang terkait dengan partnumber
        Order::query()->delete();

        // Sekarang hapus semua entri di partnumber
        Partnumber::query()->delete(); // Menghapus semua entri di partnumber

        return back();
    }
}
