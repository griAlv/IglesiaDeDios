 <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Himnario Seleccionado</title>
    <link rel="stylesheet" href="/iglesia/css/himnario.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-gray-50 text-gray-800 pt-20">

    <!-- HEADER -->
    

    <!-- CONTENIDO -->
    <main class="container mx-auto mt-32 px-4">
        <!-- Caja de búsqueda -->
        <form id="buscador" class="mb-6 text-center">
            <input type="text"
                   id="buscar"
                   placeholder="Buscar por número o palabra..."
                   class="w-full md:w-1/2 px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        </form>

        <ul id="lista-himnos" class="space-y-2 text-lg">
            <!-- Los himnos se cargarán aquí dinámicamente -->
        </ul>
    </main>

    <!-- Script externo -->
    <script src="/iglesia/vistas/js/Himnario.js"></script>
</body>
</html>
