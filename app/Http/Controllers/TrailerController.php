<?php

namespace App\Http\Controllers;

use App\Models\Trailer;
use App\Models\Truck;
use Illuminate\Http\Request;

class TrailerController extends Controller
{
    // Відображення списку причепів, що належать поточному користувачу
    public function index()
    {
        $trailers = Trailer::where('user_id', auth()->id())->get();
        return view('trailers.index', compact('trailers'));
    }

    // Показ форми для створення нового причепа
    public function create()
    {
        $trucks = Truck::where('user_id', auth()->id())->get();
        return view('trailers.create', compact('trucks'));
    }

    // Збереження нового причепа
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'license_plate' => 'required|string|unique:trailers',
            'type' => 'required|string|max:255',
            'load_capacity' => 'required|numeric',
            'condition' => 'required|string|max:255',
        ]);

        Trailer::create(array_merge($validatedData, [
            'user_id' => auth()->id(),
        ]));

        return redirect()->route('trailers.index')->with('success', 'Причіп додано успішно!');
    }

    // Показ форми для редагування конкретного причепа
    public function edit(Trailer $trailer)
    {
        $trucks = Truck::where('user_id', auth()->id())->get();
        return view('trailers.edit', compact('trailer', 'trucks'));
    }

    // Оновлення даних причепа
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'truck_id' => 'required|exists:trucks,id',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'license_plate' => 'required|string|unique:trailers,license_plate,' . $id,
            'type' => 'required|string|max:255',
            'load_capacity' => 'required|numeric',
            'condition' => 'required|string|max:255',
        ]);

        $trailer = Trailer::where('user_id', auth()->id())->findOrFail($id);
        $trailer->update($validatedData);

        return redirect()->route('trailers.index')->with('success', 'Причіп оновлено успішно!');
    }

    // Видалення конкретного причепа
    public function destroy($id)
    {
        $trailer = Trailer::where('user_id', auth()->id())->findOrFail($id);
        $trailer->delete();

        return redirect()->route('trailers.index')->with('success', 'Причіп видалено успішно!');
    }

    // Показ інформації про конкретний причіп
    public function show($id)
    {
    
        $trailer = Trailer::where('user_id', auth()->id())->findOrFail($id);

        $truck = $trailer->truck()->where('user_id', auth()->id())->first();

        return view('trailers.show', compact('trailer', 'truck'));
    }
}