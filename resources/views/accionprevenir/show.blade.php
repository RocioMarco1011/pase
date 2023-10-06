<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            DETALLES DE LA ACCIÓN DE PREVENCIÓN
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('accionprevenir.index') }}" class="inline-flex items-center px-4 py-2 mb-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                        Regresar a Acciones de Prevención
                    </a>
                    <table class="min-w-full">
                        <tbody>
                            <tr>
                                <th class="w-1/4 py-2 px-4 text-lg font-semibold">No.:</th>
                                <td class="py-2 px-4 text-lg">{{ $accionPrevenir->id }}</td>
                            </tr>
                            <tr>
                                <th class="w-1/4 py-2 px-4 text-lg font-semibold">Acción:</th>
                                <td class="py-2 px-4 text-lg">{{ $accionPrevenir->accion }}</td>
                            </tr>
                            <tr>
                                <th class="w-1/4 py-2 px-4 text-lg font-semibold">Tipo de Acción:</th>
                                <td class="py-2 px-4 text-lg">{{ $accionPrevenir->tipo }}</td>
                            </tr>
                            <tr>
                                <th class="w-1/4 py-2 px-4 text-lg font-semibold">Dependencias Responsables:</th>
                                <td class="py-2 px-4 text-lg">{{ $accionPrevenir->dependencias_responsables ?? 'No especificado' }}</td>
                            </tr>
                            <tr>
                                <th class="w-1/4 py-2 px-4 text-lg font-semibold">Dependencias Coordinadoras:</th>
                                <td class="py-2 px-4 text-lg">{{ $accionPrevenir->dependencias_coordinadoras ?? 'No especificado' }}</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <!-- Botones de Editar y Eliminar horizontalmente con separación -->
                    <div class="mt-4 text-center">
                        <div class="flex justify-center space-x-8">
                            <a href="{{ route('accionprevenir.edit', ['accionprevenir' => $accionPrevenir->id]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                Editar Acción
                            </a>
                            <form method="POST" action="{{ route('accionprevenir.destroy', ['accionprevenir' => $accionPrevenir->id]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                    Eliminar Acción
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
