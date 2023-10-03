<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            ESTRATEGIAS DE PREVENCIÓN
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-full border-collapse border-2 border-gray-300">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-lg border-b border-r">Acción</th>
                                <th class="py-2 px-4 text-lg border-b border-r">Tipo de Acción</th>
                                <th class="py-2 px-4 text-lg border-b border-r">Dependencias y/o Entidades Responsables</th>
                                <th class="py-2 px-4 text-lg border-b border-r">Dependencias y/o Entidades Coordinadoras</th>
                                <th class="py-2 px-4 text-lg border-b border-r"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    Implementar cursos de sensibilización a las y los servidores públicos sobre la violencia contra las mujeres.
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    General
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    Ministerio de Igualdad
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    Ministerio de Educación
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r text-center">
                                    <a href="{{ route('estrategiasprevenir.create', 1) }}" class="inline-flex items-center justify-center w-full h-full px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    Elaborar un protocolo para prevenir la violencia contra las mujeres dentro de los centros de trabajo de los tres órdenes de gobierno.
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    General
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    Ministerio de Salud
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    Ministerio de Comunicación
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r text-center">
                                    <a href="{{ route('estrategiasprevenir.index', 2) }}" class="inline-flex items-center justify-center w-full h-full px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                            <!-- Agregar más filas según sea necesario -->
                            <tr>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    Promover la certificación de todas las Dependencias y Entidades del Ejecutivo, así como de los 
                                    poderes legislativo, judicial y los ayuntamientos, en la Norma Mexicana NMX-R025-SCFI-2015 en 
                                    Igualdad Laboral y No Discriminación.
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    General
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    Secretaría de Educación
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    Ministerio de la Mujer
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r text-center">
                                    <a href="{{ route('estrategiasprevenir.index', 3) }}" class="inline-flex items-center justify-center w-full h-full px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                            <!-- Agregar más filas según sea necesario -->
                            <tr>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    Reforzar la capacitación de los servidores Públicos respecto a la reeducación de agresores de mujeres.
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    General
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    Secretaría de Educación
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    Ministerio de la Mujer
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r text-center">
                                    <a href="{{ route('estrategiasprevenir.index', 3) }}" class="inline-flex items-center justify-center w-full h-full px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
