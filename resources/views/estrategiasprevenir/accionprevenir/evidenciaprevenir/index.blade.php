<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            EVIDENCIAS DE LA ACCIÓN DE PREVENCIÓN
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <a href="{{ route('evidenciaprevenir.create', ['estrategiaId' => $estrategia->id, 'accionPrevenirId' => $accionPrevenir->id]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                            Añadir Evidencia
                        </a>
                    </div>
                    <table class="min-w-full border-collapse border-2 border-gray-300">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-lg border-b border-r">ID</th>
                                <th class="py-2 px-4 text-lg border-b border-r">Nombre</th>
                                <th class="py-2 px-4 text-lg border-b border-r">Mensaje</th>
                                <th class="py-2 px-4 text-lg border-b border-r">Archivo</th>
                                <th class="py-2 px-4 text-lg border-b border-r"></th>
                                <th class="py-2 px-4 text-lg border-b border-r"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($evidencias as $evidencia)
                                <tr>
                                    <td class="py-2 px-4 text-lg border-b border-r">{{ $evidencia->id }}</td>
                                    <td class="py-2 px-4 text-lg border-b border-r">{{ $evidencia->nombre }}</td>
                                    <td class="py-2 px-4 text-lg border-b border-r">{{ $evidencia->mensaje }}</td>
                                    <td class="py-2 px-4 text-lg border-b border-r">
                                        <a href="{{ route('file.download', ['filename' => $evidencia->archivo, 'nombreArchivo' => $evidencia->nombre]) }}" class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-700">
                                            Descargar Archivo
                                        </a>                                        
                                    </td>
                                    
                                    <td class="py-2 px-4 text-lg border-b border-r">
                                        <a href="{{ route('evidenciaprevenir.edit', ['estrategiaId' => $estrategia->id, 'accionPrevenirId' => $accionPrevenir->id, 'evidenciaId' => $evidencia->id]) }}" class="text-indigo-600 hover:text-indigo-900">
                                            Editar
                                        </a>
                                    </td>
                                    <td class="py-2 px-4 text-lg border-b border-r">
                                        <form action="{{ route('evidenciaprevenir.destroy', ['estrategiaId' => $estrategia->id, 'accionPrevenirId' => $accionPrevenir->id, 'evidenciaId' => $evidencia->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
