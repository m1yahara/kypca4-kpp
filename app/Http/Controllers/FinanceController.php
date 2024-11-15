<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\TruckMileage;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'month'); // За замовчуванням – місяць
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        // Визначення початкової та кінцевої дати залежно від вибраного періоду
        if ($period === 'week') {
            $startDate = Carbon::now()->subWeek()->startOfDay();
            $endDate = Carbon::now()->endOfDay();
        } elseif ($period === 'month') {
            $startDate = Carbon::now()->subMonth()->startOfDay();
            $endDate = Carbon::now()->endOfDay();
        } elseif ($period === 'custom') {
            $startDate = $startDate ? Carbon::parse($startDate)->startOfDay() : Carbon::now()->startOfDay();
            $endDate = $endDate ? Carbon::parse($endDate)->endOfDay() : Carbon::now()->endOfDay();
        }

         // Підрахунок доходів
         $income = Order::where('user_id', auth()->id())
         ->whereBetween('created_at', [$startDate, $endDate])
         ->sum('transport_cost'); 

     // Підрахунок витрат
     $expenses = TruckMileage::whereHas('truck', function($query) {
             $query->where('user_id', auth()->id());
         })
         ->whereBetween('date', [$startDate, $endDate])
         ->sum('total_fuel_cost') + TruckMileage::whereHas('truck', function($query) {
             $query->where('user_id', auth()->id());
         })
         ->whereBetween('date', [$startDate, $endDate])
         ->sum('total_amortization_cost');

     // Розрахунок чистого прибутку
     $netProfit = $income - $expenses;

     return view('finances.index', compact('income', 'expenses', 'netProfit', 'startDate', 'endDate', 'period'));
 }
}
