<?php

namespace App\Http\Controllers;

use App\Models\EstrategiasPrevenir;
use App\Models\AccionPrevenir;
use Illuminate\Http\Request;

class EstrategiasPrevenirController extends Controller
{
    public function index()
    {
        $estrategias = EstrategiasPrevenir::all();
        return view('estrategiasprevenir.index', compact('estrategias'));
    }

    public function create()
    {
        return view('estrategiasprevenir.create');
    }

    public function store(Request $request)
    {
        // Valida y guarda la estrategia en la base de datos
        $estrategia = new EstrategiasPrevenir();
        $estrategia->nombre = $request->input('nombre');
        // Otros campos...
        $estrategia->save();
    
        // Redirige a la página de la lista de estrategias
        return redirect()->route('estrategiasprevenir.index');
    }

    public function show($id)
    {
        $estrategia = EstrategiasPrevenir::find($id);
        $accionPrevenir = $estrategia->accionPrevenir;
        return view('estrategiasprevenir.show', compact('estrategia', 'accionPrevenir'));
    }


    public function edit($id) {
        // Obtener la estrategia que se va a editar usando el $id
        $estrategia = EstrategiasPrevenir::find($id);
    
        // Verificar si la estrategia existe antes de continuar
        if (!$estrategia) {
            return abort(404); // Puedes personalizar el manejo de estrategias no encontradas
        }
    
        // Pasar la estrategia a la vista de edición
        return view('estrategiasprevenir.edit', ['estrategia' => $estrategia]);
    }
    
    public function update(Request $request, $id)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|max:255', // Ajusta las reglas de validación según tus necesidades
        ]);

        // Obtener la estrategia a actualizar
        $estrategia = EstrategiasPrevenir::find($id);

        // Verificar si la estrategia existe
        if (!$estrategia) {
            return abort(404); // O manejo personalizado para estrategias no encontradas
        }

        // Actualizar los datos de la estrategia
        $estrategia->nombre = $request->nombre;
        $estrategia->save();

        // Redirigir a la página de detalles o a donde sea necesario
        return redirect()->route('estrategiasprevenir.show', ['estrategia' => $estrategia->id]);
    }

    public function destroy($id)
    {
        // Buscar la estrategia por ID
        $estrategia = EstrategiasPrevenir::find($id);

        // Verificar si la estrategia existe
        if (!$estrategia) {
            return abort(404); // O manejo personalizado para estrategias no encontradas
        }

        // Eliminar la estrategia
        $estrategia->delete();

        // Redirigir a la página de índice o a donde sea necesario
        return redirect()->route('estrategiasprevenir.index');
    }
}
