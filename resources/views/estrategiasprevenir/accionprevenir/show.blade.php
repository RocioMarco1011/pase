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
                                <td class="py-2 px-4 text-lg">{{ $accionPrevenir->dependencias_responsables }}</td>
                            </tr>
                            <tr>
                                <th class="w-1/4 py-2 px-4 text-lg font-semibold">Dependencias Coordinadoras:</th>
                                <td class="py-2 px-4 text-lg">{{ $accionPrevenir->dependencias_coordinadoras}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
