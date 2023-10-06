<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            EDITAR ACCIÓN PARA PREVENIR
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('accionprevenir.update', ['accionprevenir' => $accionPrevenir->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="accion" class="block text-lg font-medium text-gray-700">Acción:</label>
                            <input type="text" name="accion" id="accion" value="{{ old('accion', $accionPrevenir->accion) }}" class="form-input w-full">
                        </div>
                        <div class="mb-4">
                            <label for="tipo" class="block text-lg font-medium text-gray-700">Tipo de Acción:</label>
                            <select name="tipo" id="tipo" class="form-select w-full">
                                <option value="general" {{ $accionPrevenir->tipo == 'general' ? 'selected' : '' }}>General</option>
                                <option value="especifica" {{ $accionPrevenir->tipo == 'especifica' ? 'selected' : '' }}>Específica</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="dependencias_responsables" class="block text-lg font-medium text-gray-700">Dependencias Responsables:</label>
                            <input type="text" name="dependencias_responsables" id="dependencias_responsables" value="{{ old('dependencias_responsables', $accionPrevenir->dependencias_responsables) }}" class="form-input w-full">
                        </div>
                        <div class="mb-4">
                            <label for="dependencias_coordinadoras" class="block text-lg font-medium text-gray-700">Dependencias Coordinadoras:</label>
                            <input type="text" name="dependencias_coordinadoras" id="dependencias_coordinadoras" value="{{ old('dependencias_coordinadoras', $accionPrevenir->dependencias_coordinadoras) }}" class="form-input w-full">
                        </div>

                        <div class="mb-6 text-center">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                Guardar Acción
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
