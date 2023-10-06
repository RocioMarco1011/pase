<?php

namespace App\Http\Controllers;

use App\Models\AccionPrevenir;
use Illuminate\Http\Request;

class AccionPrevenirController extends Controller
{
    public function index()
    {
        $accionesPrevenir = AccionPrevenir::all();
        return view('accionprevenir.index', compact('accionesPrevenir'));
    }

    public function create()
    {
        return view('accionprevenir.create');
    }

    public function store(Request $request)
    {
        // Valida y guarda la acción para prevenir en la base de datos
        $accionPrevenir = new AccionPrevenir();
        $accionPrevenir->accion = $request->input('accion');
        $accionPrevenir->tipo = $request->input('tipo');
        $accionPrevenir->dependencias_responsables = $request->input('dependencias_responsables');
        $accionPrevenir->dependencias_coordinadoras = $request->input('dependencias_coordinadoras');
        $accionPrevenir->save();

        // Redirige a la página de la lista de acciones para prevenir
        return redirect()->route('accionprevenir.index');
    }

    public function show($id)
    {
        $accionPrevenir = AccionPrevenir::find($id);
        return view('accionprevenir.show', ['accionPrevenir' => $accionPrevenir]);
    }

    public function edit($id)
    {
        // Obtener la acción para prevenir que se va a editar usando el $id
        $accionPrevenir = AccionPrevenir::find($id);

        // Verificar si la acción para prevenir existe antes de continuar
        if (!$accionPrevenir) {
            return abort(404); // Puedes personalizar el manejo de acciones para prevenir no encontradas
        }

        // Pasar la acción para prevenir a la vista de edición
        return view('accionprevenir.edit', ['accionPrevenir' => $accionPrevenir]);
    }

    public function update(Request $request, $id)
    {
        // Validación de datos
        $request->validate([
            'accion' => 'required|max:255',
            'tipo' => 'required|in:general,especifica', // Ajusta las reglas de validación según tus necesidades
            'dependencias_responsables' => 'nullable|max:255',
            'dependencias_coordinadoras' => 'nullable|max:255',
        ]);

        // Obtener la acción para prevenir a actualizar
        $accionPrevenir = AccionPrevenir::find($id);

        // Verificar si la acción para prevenir existe
        if (!$accionPrevenir) {
            return abort(404); // O manejo personalizado para acciones para prevenir no encontradas
        }

        // Actualizar los datos de la acción para prevenir
        $accionPrevenir->accion = $request->accion;
        $accionPrevenir->tipo = $request->tipo;
        $accionPrevenir->dependencias_responsables = $request->dependencias_responsables;
        $accionPrevenir->dependencias_coordinadoras = $request->dependencias_coordinadoras;
        $accionPrevenir->save();

        // Redirigir a la página de detalles o a donde sea necesario
        return redirect()->route('accionprevenir.show', ['accionprevenir' => $accionPrevenir->id]);
    }

    public function destroy($id)
    {
        // Buscar la acción para prevenir por ID
        $accionPrevenir = AccionPrevenir::find($id);

        // Verificar si la acción para prevenir existe
        if (!$accionPrevenir) {
            return abort(404); // O manejo personalizado para acciones para prevenir no encontradas
        }

        // Eliminar la acción para prevenir
        $accionPrevenir->delete();

        // Redirigir a la página de índice o a donde sea necesario
        return redirect()->route('accionprevenir.index');
    }
}
