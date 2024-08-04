<?php

namespace App\Http\Controllers;

use App\Models\Lotnumber;
use App\Models\Partnumber;
use App\Models\Schedule;
use App\Models\ScheduleDetail;
use App\Models\Teams;
use Illuminate\Http\Request;

class ScheduleController extends Controller
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
        Schedule::create([
            'date' => $request->input('date'),
            'line' => $request->input('line'),
            'shift' => $request->input('shift'),
        ]);

        return back();
    }

    public function getPrint(Request $request)
    {
        $date = $request->input('date');

        // Ambil semua jadwal berdasarkan tanggal yang diberikan
        $schedules = Schedule::with('details')->where('date', $date)->get();

        // Mengelompokkan berdasarkan shift dan line
        $groupedSchedules = $schedules->groupBy('shift')->map(function ($shiftSchedules) {
            return $shiftSchedules->groupBy('line');
        });


        // Tampilkan hasil dalam view print
        return view('Dashboard.pages.print_schedule', compact('groupedSchedules', 'date'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $partnumber = Partnumber::all();
        $teams = Teams::all();

        // Ambil schedule dengan detailnya
        $schedule = Schedule::with('details')->findOrFail($id);

        $lotnumber = Lotnumber::all();

        // Menggabungkan detail berdasarkan partnumber
        $mergedDetails = $schedule->details->groupBy('partnumber')->map(function ($details) use ($schedule) {
            $firstDetail = $details->first();
            $mergedLotNoQty = $details->map(function ($detail) {
                return [
                    'lot_no' => $detail->lot_no,
                    'qty' => $detail->qty,
                ];
            })->toArray();

            return [
                'id' => $firstDetail->id, // Pastikan ID disertakan
                'id_schedule' => $schedule->id, // Menambahkan id_schedule
                'partnumber' => $firstDetail->partnumber,
                'team' => $firstDetail->team,
                'plan' => $firstDetail->plan,
                'lot_numbers' => $mergedLotNoQty,
                'target_perjam_1' => $firstDetail->target_perjam_1,
                'target_perjam_2' => $firstDetail->target_perjam_2,
                'act' => $firstDetail->act,
                'status' => $firstDetail->status,
            ];
        })->values();

        return view('Dashboard.pages.detailjadwal', compact('schedule', 'partnumber', 'teams', 'mergedDetails', 'lotnumber'));
    }

    public function addDetail(Request $request, $id)
    {
        // Validasi input dari request
        $request->validate([
            'partnumber' => 'required|string|max:255',
            'team' => 'required|string|max:255',
            'plan' => 'required|numeric',
            'lot_no' => 'required|array',
            'lot_no.*' => 'required|string|max:255',
            'qty' => 'required|array',
            'qty.*' => 'required|numeric',
            'act' => 'required|numeric',
        ]);

        // Hitung target per jam berdasarkan plan
        $plan = $request->input('plan');
        $target_perjam_1 = $plan * 0.3138; // 31.38%
        $target_perjam_2 = $plan * 0.6862; // 68.62%

        // Temukan schedule berdasarkan ID
        $schedule = Schedule::findOrFail($id);

        // Tambahkan detail ke schedule
        $lotNumbers = $request->input('lot_no');
        $quantities = $request->input('qty');

        foreach ($lotNumbers as $index => $lotNo) {
            $schedule->details()->create([
                'partnumber' => $request->input('partnumber'),
                'team' => $request->input('team'),
                'plan' => $plan,
                'lot_no' => $lotNo,
                'qty' => $quantities[$index],
                'target_perjam_1' => $target_perjam_1,
                'target_perjam_2' => $target_perjam_2,
                'act' => $request->input('act'),
                'status' => 'pending',
            ]);
        }

        return back();
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function editDetail($id)
    {
        $detail = ScheduleDetail::findOrFail($id);
        $partnumber = Partnumber::all();
        $teams = Teams::all();

        return view('Dashboard.pages.editDetail', compact('detail', 'partnumber', 'teams'));
    }

    public function updateDetail(Request $request, $id)
    {
        $detail = ScheduleDetail::findOrFail($id);

        $request->validate([
            'act' => 'required|numeric',
        ]);

        $detail->update([
            'act' => $request->input('act'),
        ]);

        return redirect('/penjadwalan');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        ScheduleDetail::where('schedule_id', $id)->delete();

        Schedule::findOrFail($id)->delete();

        return back();
    }

    public function deleteDetail($id)
    {
        $detail = ScheduleDetail::findOrFail($id);

        // Cek apakah partnumber dan schedule_id sesuai
        $partnumber = request('partnumber');
        $scheduleId = request('schedule_id');

        ScheduleDetail::where('schedule_id', $scheduleId)
        ->where('partnumber', $partnumber)
        ->delete();

        return back();
    }
}
