<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Truck;
use Carbon\Carbon;
use App\Models\TruckMileage;
use App\Models\User;
use PDF;


class DocumentController extends Controller
{
    public function showDocumentOptions()
    {
        // Отримуємо всі замовлення та вантажівки для випадаючих списків
        $orders = Order::where('user_id', auth()->id())->get();
        $trucks = Truck::where('user_id', auth()->id())->get();
    
        return view('documents.options', compact('orders', 'trucks'));
    }
    
    //генерація документів
    public function generateWorkAct($orderId)
    {
        $order = Order::findOrFail($orderId);
        $pdf = PDF::loadView('documents.work_act', compact('order'));
        $pdf->setOptions(['defaultFont' => 'times']);

        return $pdf->download('Work_Act_Order_'.$orderId.'.pdf');
    }

    public function generateIncomeReportPdf(Request $request)
    {
        $period = $request->get('period', 'month');
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

        // Отримання даних про доходи
        $incomeData = Order::where('user_id', auth()->id())
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get(['created_at', 'client', 'transport_cost', 'loading_place', 'unloading_place']);

        // Генерація PDF за допомогою шаблону
        $pdf = PDF::loadView('documents.income_report', [
            'incomeData' => $incomeData,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);

        return $pdf->download('income_report.pdf');
    }

    public function generateExpenseReportPdf(Request $request)
    {
        $period = $request->get('period', 'month');
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

        // Отримання даних про витрати
        $expenseData = TruckMileage::whereHas('truck', function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->whereBetween('date', [$startDate, $endDate])
        ->get(['date', 'total_fuel_cost', 'total_amortization_cost']);

        // Генерація PDF за допомогою шаблону
        $pdf = PDF::loadView('documents.expense_report', [
            'expenseData' => $expenseData,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);

        return $pdf->download('expense_report.pdf');
    }

    public function generateFinancialReportPdf(Request $request)
    {
        $period = $request->get('period', 'month');
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

        // Підрахунок доходів та витрат
        $orders = Order::where('user_id', auth()->id())
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $income = $orders->sum('transport_cost');

        $expenses = TruckMileage::whereHas('truck', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $totalExpenses = $expenses->sum(function($expense) {
            return $expense->total_fuel_cost + $expense->total_amortization_cost;
        });

        // Розрахунок чистого прибутку
        $netProfit = $income - $totalExpenses;

        // Генерація PDF за допомогою шаблону
        $pdf = PDF::loadView('documents.financial_report', [
            'orders' => $orders,
            'expenses' => $expenses,
            'income' => $income,
            'totalExpenses' => $totalExpenses,
            'netProfit' => $netProfit,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'period' => $period,
        ]);

        return $pdf->download('financial_report.pdf');
        
    }

    public function generateMileageHistory($truckId)
    {
        $truck = Truck::findOrFail($truckId);
        $mileageHistory = TruckMileage::where('truck_id', $truckId)->get();

        $pdf = PDF::loadView('documents.mileage_history', compact('truck', 'mileageHistory'));
        return $pdf->download('Mileage_History_'.$truck->brand.' '.$truck->model.'.pdf');
    }

    public function generateAllOrders(Request $request)
    {
       // Отримання періоду для звіту: місяць, тиждень або користувацький
       $period = $request->get('period', 'month');
       $startDate = $request->get('start_date');
       $endDate = $request->get('end_date');

       // Встановлення початкової та кінцевої дати залежно від вибраного періоду
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

       // Вибірка замовлень поточного користувача за обраний період
       $orders = Order::where('user_id', auth()->id())
       ->whereBetween('created_at', [$startDate, $endDate])
       ->get();
       
       // Генерація PDF з альбомною орієнтацією
       $pdf = Pdf::loadView('documents.all_orders', compact('orders', 'startDate', 'endDate'))
           ->setPaper('a4', 'landscape'); // Альбомна орієнтація

       // Завантаження PDF як файлу
       return $pdf->download('orders_report.pdf');
    }  
    
    public function generateUserFleet()
    {
        $user = auth()->user(); // Отримуємо дані користувача
    
        $trucks = Truck::where('user_id', $user->id)
        ->with(['mileages' => function ($query) {
            $query->orderBy('date', 'desc')->limit(1); // Отримуємо останній пробіг
        }])
        ->get();
    
        // Створюємо PDF з використанням в'юшки documents.user_fleet
        $pdf = PDF::loadView('documents.user_fleet', compact('user', 'trucks'));
    
        // Повертаємо PDF на завантаження
        return $pdf->download('User_Fleet_Report.pdf');
    }
}
