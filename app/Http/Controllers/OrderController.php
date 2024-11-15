<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
       $orders = Order::where('user_id', auth()->id())->get();
       return view('orders.index', compact('orders'));
    }

    public function create()
    {
        
       return view('orders.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'loading_place' => 'required|string|max:255',
            'unloading_place' => 'required|string|max:255',
            'loading_date' => 'required|date',
            'unloading_date' => 'required|date',
            'cargo_type' => 'required|string|max:255',
            'grain_quantity' => 'required|numeric',
            'price_per_ton' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        // Обчислення вартості перевезення
        $transportCost = $validatedData['grain_quantity'] * $validatedData['price_per_ton'];

        // Збереження нового замовлення із додаванням user_id
        Order::create(array_merge($validatedData, [
            'user_id' => auth()->id(),
            'transport_cost' => $transportCost,
        ]));

        return redirect()->route('orders.index')->with('success', 'Замовлення створено успішно!');
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validatedData = $request->validate([
            'client' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'loading_place' => 'required|string|max:255',
            'unloading_place' => 'required|string|max:255',
            'loading_date' => 'required|date',
            'unloading_date' => 'required|date',
            'cargo_type' => 'required|string|max:255',
            'grain_quantity' => 'required|numeric',
            'price_per_ton' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        // Обчислення нової вартості перевезення
        $validatedData['transport_cost'] = $validatedData['grain_quantity'] * $validatedData['price_per_ton'];

        $order->update($validatedData);

        return redirect()->route('orders.index')->with('success', 'Замовлення оновлено.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Замовлення видалено успішно.');
    }
}
