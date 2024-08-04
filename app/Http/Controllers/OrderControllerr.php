<?php

namespace App\Http\Controllers;

use App\Imports\OrderImport;
use App\Models\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderControllerr extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Order::create([
            'itemid' => $request->input('item_id'),
            'customer' => $request->input('customer'),
            'date' => $request->input('date'),
            'jumlah_order' => $request->input('jumlah_order'),
        ]);

        return back();
    }

    public function importExcelOrder(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        try {
            Excel::import(new OrderImport(), $request->file('file'));
            return redirect()->back()->with('success', 'Orders imported successfully.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return redirect()->back()->withErrors($errorMessages);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
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
        Order::findOrFail($id)->update([
            'itemid' => $request->input('item_id'),
            'customer' => $request->input('customer'),
            'date' => $request->input('date'),
            'jumlah_order' => $request->input('jumlah_order'),
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Order::findOrFail($id)->delete();

        return back();
    }

    public function destroyAll(){

        Order::truncate();

        return back();

    }
}
