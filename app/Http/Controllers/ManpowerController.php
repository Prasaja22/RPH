<?php

namespace App\Http\Controllers;

use App\Imports\ManpowerImport;
use App\Models\Manpower;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ManpowerController extends Controller
{
    // import excel
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        try {
            Excel::import(new ManpowerImport, $request->file('file'));
            return redirect()->back()->with('success', 'Manpower imported successfully.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return redirect()->back()->withErrors($errorMessages);
        }
    }


    public function store(Request $request)
    {
        Manpower::create([
            'noreg' => $request->input('noreg'),
            'name' => $request->input('nama'),
            'team_id' => $request->input('team'),
        ]);

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Manpower::findOrFail($id)->update([
            'noreg' => $request->input('noreg'),
            'name' => $request->input('nama_team'),
            'team_id' => $request->input('team'),
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Manpower::findOrFail($id)->delete();

        return back();
    }

    public function destroyAll()
    {
        Manpower::truncate();

        return back();
    }
}
