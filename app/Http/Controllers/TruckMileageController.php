<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use App\Models\TruckMileage;
use Illuminate\Http\Request;

class TruckMileageController extends Controller
{
    public function index($truckId)
    {
        $truck = Truck::findOrFail($truckId);
        $mileages = $truck->mileages()->orderBy('date', 'desc')->get();

        return view('truck_mileages.index', compact('truck', 'mileages'));
    }

    public function create($truckId)
    {
        $truck = Truck::findOrFail($truckId);
        $lastMileage = $truck->mileages()->latest()->first();

        return view('truck_mileages.create', compact('truck', 'lastMileage'));
    }

    public function store(Request $request, $truckId)
    {
        $request->validate([
            'date' => 'required|date',
            'mileage' => 'required|integer',
            'fuel_cost_per_100km' => 'required|numeric',
            'amortization_cost_per_100km' => 'required|numeric',
        ]);

        $truck = Truck::findOrFail($truckId);
        $previousMileage = $truck->mileages()->orderBy('date', 'desc')->first();

        $mileageDifference = $previousMileage ? $request->mileage - $previousMileage->mileage : $request->mileage;
        $totalFuelCost = ($mileageDifference / 100) * $request->fuel_cost_per_100km;
        $totalAmortizationCost = ($mileageDifference / 100) * $request->amortization_cost_per_100km;

        TruckMileage::create([
            'truck_id' => $truckId,
            'date' => $request->date,
            'mileage' => $request->mileage,
            'fuel_cost_per_100km' => $request->fuel_cost_per_100km,
            'amortization_cost_per_100km' => $request->amortization_cost_per_100km,
            'total_fuel_cost' => $totalFuelCost,
            'total_amortization_cost' => $totalAmortizationCost,
        ]);

        return redirect()->route('truck_mileages.index', $truckId)->with('success', 'Історія пробігу додана успішно!');
    }

    public function edit($truckId, $mileageId)
    {
        $truck = Truck::findOrFail($truckId);
        $mileage = TruckMileage::where('truck_id', $truckId)->findOrFail($mileageId);

        return view('truck_mileages.edit', compact('truck', 'mileage'));
    }

    public function update(Request $request, $truckId, $mileageId)
    {
        $request->validate([
            'date' => 'required|date',
            'mileage' => 'required|integer',
            'fuel_cost_per_100km' => 'required|numeric',
            'amortization_cost_per_100km' => 'required|numeric',
        ]);

        $mileage = TruckMileage::where('truck_id', $truckId)->findOrFail($mileageId);

        $previousMileage = TruckMileage::where('truck_id', $truckId)
            ->where('id', '<', $mileageId)
            ->orderBy('date', 'desc')
            ->first();

        $mileageDifference = $previousMileage ? $request->mileage - $previousMileage->mileage : $request->mileage;
        $totalFuelCost = ($mileageDifference / 100) * $request->fuel_cost_per_100km;
        $totalAmortizationCost = ($mileageDifference / 100) * $request->amortization_cost_per_100km;

        $mileage->update([
            'date' => $request->date,
            'mileage' => $request->mileage,
            'fuel_cost_per_100km' => $request->fuel_cost_per_100km,
            'amortization_cost_per_100km' => $request->amortization_cost_per_100km,
            'total_fuel_cost' => $totalFuelCost,
            'total_amortization_cost' => $totalAmortizationCost,
        ]);

        return redirect()->route('truck_mileages.index', $truckId)->with('success', 'Запис пробігу оновлено успішно!');
    }

    public function destroy($truckId, $mileageId)
    {
        $mileage = TruckMileage::where('truck_id', $truckId)->findOrFail($mileageId);
        $mileage->delete();

        return redirect()->route('truck_mileages.index', $truckId)->with('success', 'Запис пробігу видалено успішно!');
    }
}

