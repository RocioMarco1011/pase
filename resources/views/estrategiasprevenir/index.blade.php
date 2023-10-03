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
                                <th class="py-2 px-4 text-lg border-b border-r">No.</th>
                                <th class="py-2 px-4 text-lg border-b border-r">Estrategias</th>
                                <th class="py-2 px-4 text-lg border-b border-r"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    1.
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    Promover dentro de las instituciones públicas acciones que prevengan conductas de violencia contra las mujeres.
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r text-center">
                                    <a href="{{ route('estrategiasprevenir.create') }}" class="inline-flex items-center justify-center w-full h-full px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    2.
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    Impulsar acciones para eliminar estereotipos que generan conductas violentas contra las mujeres.
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r text-center">
                                    <a href="{{ route('estrategiasprevenir.index') }}" class="inline-flex items-cendarkenter justify-center w-full h-full px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    3.
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    Promover procesos formativos que sensibilicen y capaciten con enfoque de derechos humanos, perspectiva de género, interculturalidad, no discriminación y prevención de la violencia contra la mujer, así como la perspectiva de la niñez y la adolescencia.
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r text-center">
                                    <a href="{{ route('estrategiasprevenir.index') }}" class="inline-flex items-center justify-center w-full h-full px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    4.
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    Impulsar acciones para prevenir la violencia contra las mujeres en situación de vulnerabilidad y/o minoritarias.
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r text-center">
                                    <a href="{{ route('estrategiasprevenir.index') }}" class="inline-flex items-center justify-center w-full h-full px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    5.
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r">
                                    Diseñar acciones y programas de prevención de la violencia en contra de las mujeres en espacios públicos.
                                </td>
                                <td class="py-2 px-4 text-lg border-b border-r text-center">
                                    <a href="{{ route('estrategiasprevenir.index') }}" class="inline-flex items-center justify-center w-full h-full px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
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
