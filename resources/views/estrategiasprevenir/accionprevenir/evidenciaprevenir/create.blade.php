<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Nueva Evidencia
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="post" action="{{ route('evidenciaprevenir.store', ['estrategiaId' => $estrategia->id, 'accionPrevenirId' => $accionPrevenir->id]) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                            <input type="text" name="nombre" id="nombre" class="form-input">
                        </div>

                        <div class="mb-4">
                            <label for="mensaje" class="block text-gray-700 text-sm font-bold mb-2">Mensaje:</label>
                            <textarea name="mensaje" id="mensaje" class="form-textarea"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="archivo" class="block text-gray-700 text-sm font-bold mb-2">Archivo:</label>
                            <input type="file" name="archivo" id="archivo" class="form-input">
                        </div>

                        <div class="mb-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">Guardar Evidencia</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
