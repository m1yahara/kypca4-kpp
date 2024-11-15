<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    // Відображення списку вантажівок, що належать поточному користувачу
    public function index()
    {
        $trucks = Truck::where('user_id', auth()->id())->get();
        return view('trucks.index', compact('trucks'));
    }

    // Показ форми для створення нової вантажівки
    public function create()
    {
        return view('trucks.create');
    }

    // Збереження нової вантажівки
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'license_plate' => 'required|string|unique:trucks',
            'load_capacity' => 'required|numeric',
            'condition' => 'required|string|max:255',
        ]);

        Truck::create(array_merge($validatedData, [
            'user_id' => auth()->id(),
        ]));

        return redirect()->route('trucks.index')->with('success', 'Вантажівка додана успішно!');
    }

    // Показ форми для редагування конкретної вантажівки
    public function edit($id)
    {
        $truck = Truck::where('user_id', auth()->id())->findOrFail($id);
        return view('trucks.edit', compact('truck'));
    }

    // Оновлення даних вантажівки
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'license_plate' => 'required|string|unique:trucks,license_plate,' . $id,
            'load_capacity' => 'required|numeric',
            'condition' => 'required|string|max:255',
        ]);

        $truck = Truck::where('user_id', auth()->id())->findOrFail($id);
        $truck->update($validatedData);

        return redirect()->route('trucks.index')->with('success', 'Вантажівку оновлено успішно!');
    }

    // Видалення конкретної вантажівки
    public function destroy($id)
    {
        $truck = Truck::where('user_id', auth()->id())->findOrFail($id);
        $truck->mileages()->delete(); // Видаляємо всі записи пробігу, пов'язані з цією вантажівкою
        $truck->delete(); // Видаляємо вантажівку
    
        return redirect()->route('trucks.index')->with('success', 'Вантажівка та її записи про пробіг видалені успішно!');
    }


    // Показ інформації про конкретну вантажівку
    public function show($id)
    {
        $truck = Truck::where('user_id', auth()->id())->findOrFail($id);
        return view('trucks.show', compact('truck'));
    }
}