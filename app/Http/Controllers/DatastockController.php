<?php

namespace App\Http\Controllers;

use App\Imports\DatastockImport;
use App\Models\Datastock;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DatastockController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Datastock::create([
            'partnumber_id' => $request->input('partnumber_id'),
            'date' => $request->input('date'),
            'stock' => $request->input('stock'),
        ]);

        return back();
    }

    public function importExcelDatastock(Request $request){
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        try {
            Excel::import(new DatastockImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data stock imported successfully.');
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Datastock::findOrFail($id)->update([
            'partnumber_id' => $request->input('partnumber_id'),
            'date' => $request->input('date'),
            'stock' => $request->input('stock'),
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Datastock::findOrFail($id)->delete();

        return back();
    }

    public function destroyAll(){
        Datastock::truncate();

        return back();
    }
}
