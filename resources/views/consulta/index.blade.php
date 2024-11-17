<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Certificado Alumno</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 text-gray-800 font-sans">

    <nav class="bg-white p-1 flex items-center shadow-md">
        <!-- Logo -->
        <div class="flex items-center space-x-4">
            <img src="https://aguasamazonicas.org/wp-content/uploads/2021/06/imagem_2023-05-29_120804614.png" alt="Logo" class="h-16 w-16 rounded-md">
        </div>
        <!-- Enlaces -->
        <div class="flex space-x-6">
            <a href="http://iiap.org.pe/web/presentacion_iiap.aspx" class="text-black text-lg font-bold hover:text-gray-600">IIAP</a>
            <a href="https://amazonia.iiap.gob.pe/" class="text-black text-lg font-bold hover:text-gray-600">Guía Ilustrada</a>
            <a href="http://ictiologicas.iiap.gob.pe/" class="text-black text-lg font-bold hover:text-gray-600">Ictiología</a>
        </div>
    </nav>

    <br>
    <br>
    <br>

    <div class="container mx-auto py-10 px-4">
        <h1 class="text-center text-4xl font-bold mb-10">Consulta Certificado</h1>

        <div class="search-bar mb-10 mx-auto flex justify-center">
            <form action="{{ route('consulta.index') }}" method="GET" class="w-full max-w-2xl relative flex flex-col sm:flex-row gap-2">
                <input
                    type="text"
                    name="dni"
                    placeholder="Ingrese su DNI"
                    class="w-full px-6 py-4 text-lg border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <button
                    type="submit"
                    class="bg-blue-500 text-white px-6 py-2 rounded-full text-lg font-semibold hover:bg-blue-600 shadow">
                    Buscar
                </button>
                @if ($alumnos && $alumnos->isNotEmpty())
                <button
                    type="button"
                    onclick="window.location.href='{{ route('consulta.index') }}'"
                    class="bg-gray-500 text-white px-6 py-2 rounded-full text-lg font-semibold hover:bg-gray-600 shadow">
                    Limpiar
                </button>
                @endif
            </form>
        </div>

        @if ($errors->any())
            <div id="error-messages" class="bg-red-500 text-white p-4 rounded-lg mb-10">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($alumnos && $alumnos->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="table-auto w-full bg-white shadow-lg rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Nombre</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Apellido</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">DNI</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Curso</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Certificado</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alumnos as $alumno)
                            <tr class="border-t border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $alumno->nombre }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $alumno->apellido }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $alumno->dni }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ optional($alumno->curso)->nombre }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ optional(optional($alumno->curso)->certificado)->nombre }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('consulta.index', ['dni' => $alumno->dni, 'action' => 'download', 'curso_id' => optional($alumno->curso)->idcurso]) }}"
                                            class="px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 text-center">Descargar</a>
                                        <a href="{{ route('consulta.index', ['dni' => $alumno->dni, 'action' => 'view', 'curso_id' => optional($alumno->curso)->idcurso]) }}"
                                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 text-center" target="_blank">Ver</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center mt-10">
                @if (request()->has('dni') && $alumnos->isEmpty())
                    <h2 class="text-lg font-semibold text-gray-700">No se encontraron resultados para el DNI ingresado.</h2>
                @endif
            </div>
        @endif
    </div>

    <!-- Script para ocultar automáticamente el mensaje de error -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const errorMessages = document.getElementById('error-messages');
            if (errorMessages) {
                setTimeout(() => {
                    errorMessages.style.transition = 'opacity 0.5s ease';
                    errorMessages.style.opacity = '0';
                    setTimeout(() => {
                        errorMessages.remove();
                    }, 500); // Elimina del DOM tras desvanecerse
                }, 3000); // 3 segundos antes de iniciar
            }
        });
    </script>
</body>

</html>
