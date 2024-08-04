<?php

namespace App\Http\Controllers;

use App\Imports\LotnumberImport;
use App\Models\Lotnumber;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LotnumberController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Lotnumber::create([
            'partnumber_id' => $request->input('partnumber_id'),
            'lotnumber' => $request->input('lotnumber'),
            'qty' => $request->input('qty'),
        ]);

        return back();
    }

    public function importExcelLotnumber(Request $request){
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        try {
            Excel::import(new LotnumberImport, $request->file('file'));
            return redirect()->back()->with('success', 'Lotnumber imported successfully.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return redirect()->back()->withErrors($errorMessages);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Lotnumber::findOrFail($id)->update([
            'partnumber_id' => $request->input('partnumber_id'),
            'lotnumber' => $request->input('lotnumber'),
            'qty' => $request->input('qty'),
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyAll()
    {
        Lotnumber::truncate();

        return back();
    }

    public function destroy(string $id){

        Lotnumber::findOrFail($id)->delete();

        return back();
    }
}
