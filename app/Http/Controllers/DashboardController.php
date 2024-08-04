<?php

namespace App\Http\Controllers;

use App\Models\Datastock;
use App\Models\Lotnumber;
use App\Models\Manpower;
use App\Models\Order;
use App\Models\Partnumber;
use App\Models\Schedule;
use App\Models\Teams;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $chartPie = Datastock::with('partnumber')
        ->selectRaw('partnumber_id, SUM(stock) as total_stock')
        ->groupBy('partnumber_id')
        ->orderBy('partnumber_id')
        ->where('stock', '>', 0)
        ->get();

        // Siapkan data untuk chart
        $chartData = $chartPie->map(function($data) {
            return [
                'value' => $data->total_stock,
                'name' => $data->partnumber->item_id,
            ];
        });

        $manpower = Manpower::count();

        $sumOnStock = Datastock::where('stock', '>', 0)->sum('stock');

        $today = Carbon::today()->toDateString();
        $schedules = Schedule::where('date', $today)->get();

       // Ambil bulan saat ini dan dua bulan sebelumnya
        $currentMonth = Carbon::now()->format('m');
        $previousMonths = [
            Carbon::now()->subMonth(1)->format('m'), // Bulan sebelumnya
            Carbon::now()->subMonth(2)->format('m'), // Dua bulan sebelumnya
        ];

        // Ambil total order berdasarkan bulan saat ini dan dua bulan sebelumnya
        $totalOrders = Order::with('partnumber')
        ->select(DB::raw('itemid, sum(jumlah_order) as total'))
        ->whereBetween('date', [now()->subMonths(2)->startOfMonth(), now()->endOfMonth()])
        ->groupBy('itemid')
        ->orderBy('itemid')
        ->get();

        $orderWidget = Order::sum('jumlah_order');


        return view('Dashboard.pages.dashboard', compact('chartData', 'manpower', 'sumOnStock', 'schedules', 'totalOrders', 'orderWidget'));
    }

    public function indexImportDataOrder()
    {

        $partnumber = Partnumber::all();


        $partnumberCheck = Partnumber::count();

        $data = Order::with('partnumber')->get();


        return view('Dashboard.pages.order', compact('partnumber', 'data', 'partnumberCheck'));
    }

    public function indexImportDataManpower(){
        $data = Manpower::with('team')->get();

        $teams = Teams::all();

        $teamsCheck = Teams::count();

        return view('Dashboard.pages.manpower',  compact('data', 'teams', 'teamsCheck'));
    }

    // menampilkan halaman teams
    public function indexTeam(){
        $data = Teams::all();

        return view('Dashboard.pages.team', compact('data'));
    }

    public function indexPartNumber()
    {
        $data = Partnumber::all();

        return view('Dashboard.pages.partnumber', compact('data'));
    }

    public function indexLotNumber(){
        $partnumber = Partnumber::all();

        $data = Lotnumber::with('partnumber')->get();

        $partnumberCheck = Partnumber::count();

        return view('Dashboard.pages.lotnumber', compact('partnumber', 'data', 'partnumberCheck'));
    }

    public function indexDataStock(){

        $partnumber = Partnumber::all();

        $data = Datastock::with('partnumber')->get();

        $partnumberCheck = Partnumber::count();

        return view('Dashboard.pages.datastock', compact('partnumber', 'data', 'partnumberCheck'));
    }

    public function indexPenjadwalan(){

        $data = Schedule::all();

        $manpowerCheck = Manpower::count();

        return view('Dashboard.pages.penjadwalan', compact('data', 'manpowerCheck'));
    }
}
