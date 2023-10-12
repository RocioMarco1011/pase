<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            EVIDENCIAS DE LA ACCIÓN DE PREVENCIÓN
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Botón para agregar nueva evidencia -->
                    
                    
                    <!-- Tabla para mostrar las evidencias -->
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">Evidencia</th>
                                <th class="px-4 py-2">Mensaje</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Recorre las evidencias de acciones de prevención -->
                            @foreach ($evidencias as $evidencia)
                                <tr>
                                    <td class="px-4 py-2">{{ $evidencia->id }}</td>
                                    <td class="px-4 py-2">{{ $evidencia->nombre }}</td>
                                    <td class="px-4 py-2">{{ $evidencia->mensaje }}</td>
                                    <td class="px-4 py-2">
                                        <!-- Agregar botones de acciones si es necesario (por ejemplo, editar o eliminar) -->
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
