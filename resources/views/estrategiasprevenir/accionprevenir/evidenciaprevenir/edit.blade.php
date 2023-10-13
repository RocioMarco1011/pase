<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Evidencia
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('evidenciaprevenir.update', ['estrategiaId' => $estrategia->id, 'accionPrevenirId' => $accionPrevenir->id, 'evidenciaId' => $evidencia->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" name="nombre" id="nombre" value="{{ $evidencia->nombre }}" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="mensaje" class="block text-sm font-medium text-gray-700">Mensaje</label>
                            <textarea name="mensaje" id="mensaje" class="form-textarea mt-1 block w-full rounded-md shadow-sm" rows="4">{{ $evidencia->mensaje }}</textarea>
                        </div>

                        <!-- Agrega más campos si es necesario -->

                        <div class="flex items-center justify-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-700">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
