<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;
use Illuminate\Support\Facades\Http;

class RouteController extends Controller
{
    // Метод для відображення головної сторінки
    public function index()
    {
        return view('routes.index');
    }

    // Метод для розрахунку маршруту
    public function calculateRoute(Request $request)
    {
        $startAddress = $request->input('start_location');
        $endAddress = $request->input('end_location');
    
        // Геокодування початкової адреси
        $startResponse = Http::get("https://nominatim.openstreetmap.org/search", [
            'q' => $startAddress,
            'format' => 'json',
            'limit' => 1
        ]);
    
        $endResponse = Http::get("https://nominatim.openstreetmap.org/search", [
            'q' => $endAddress,
            'format' => 'json',
            'limit' => 1
        ]);
    
        if ($startResponse->successful() && $endResponse->successful() && !empty($startResponse[0]) && !empty($endResponse[0])) {
            $startCoords = $startResponse[0];
            $endCoords = $endResponse[0];
    
            // Формуємо координати для запиту до OSRM
            $startLocation = $startCoords['lon'] . ',' . $startCoords['lat'];
            $endLocation = $endCoords['lon'] . ',' . $endCoords['lat'];
    
            // Використання OSRM API для маршруту
            $routeResponse = Http::get("http://router.project-osrm.org/route/v1/driving/$startLocation;$endLocation", [
                'overview' => 'full',
                'geometries' => 'geojson'
            ]);
    
            if ($routeResponse->successful()) {
                $routeData = $routeResponse->json();
                $route = $routeData['routes'][0];
    
                return response()->json([
                    'distance' => $route['distance'] / 1000,
                    'duration' => $route['duration'] / 60,
                    'geometry' => $route['geometry'],
                ]);
            } else {
                return response()->json(['error' => 'Не вдалося розрахувати маршрут'], 500);
            }
        } else {
            return response()->json(['error' => 'Не вдалося знайти координати для вказаних адрес'], 500);
        }
    }
    

    // Метод для збереження маршруту
    public function saveRoute(Request $request)
    {
        $route = new Route();
        $route->user_id = auth()->id(); // Прив'язка до поточного користувача
        $route->start_location = $request->input('start_location');
        $route->end_location = $request->input('end_location');
        $route->distance = $request->input('distance');
        $route->duration = $request->input('duration');
        $route->coordinates = json_encode($request->input('geometry')); // Зберігаємо координати як JSON
    

        if ($route->save()) {
            return response()->json(['success' => 'Маршрут збережено успішно']);
        } else {
            return response()->json(['error' => 'Помилка при збереженні маршруту'], 500);
        }
    }

    
    public function showRoutes()
    {
        // Отримуємо маршрути, пов'язані з авторизованим користувачем
        $routes = Route::where('user_id', auth()->id())->get();
    
        return view('routes.show', compact('routes'));
    }
    

    public function deleteRoute($id)
    {
        $route = Route::findOrFail($id);
        if ($route->user_id === auth()->id()) {
            $route->delete();
            return redirect()->route('my.routes')->with('success', 'Маршрут видалено успішно.');
        }
        
        return redirect()->route('my.routes')->with('error', 'Виникла помилка при видаленні маршруту.');
    }
    

    public function getRoute($id)
    {
        $route = Route::findOrFail($id);
        
        return response()->json([
            'geometry' => json_decode($route->coordinates) // Повертаємо координати у форматі GeoJSON
        ]);
    }
    
}
