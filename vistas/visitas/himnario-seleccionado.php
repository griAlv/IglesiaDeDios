<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Himnario Seleccionado</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="/iglesia/css/himnario.css">
    
    <style>
        body {
            font-family: sans-serif;
            background-color: #f9fafb;
            color: #1f2937;
            padding-top: 5rem;
        }

        main {
            margin-top: 8rem;
        }

        #buscar {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            transition: all 0.3s;
        }

        #buscar:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        #lista-himnos {
            list-style: none;
            padding: 0;
        }

        #lista-himnos li {
            margin-bottom: 0.5rem;
            font-size: 1.125rem;
        }
    </style>
</head>
<body>

  
    <!-- CONTENIDO -->
    <main class="container px-1">
        <!-- Caja de búsqueda -->
        <form id="buscador" class="mb-3 text-center">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6">
                    <input type="text"
                           id="buscar"
                           placeholder="Buscar por número o palabra..."
                           class="form-control form-control-lg">
                </div>
            </div>
        </form>

        <ul id="lista-himnos">
            <!-- Los himnos se cargarán aquí dinámicamente -->
        </ul>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script personalizado -->
    <script src="/iglesia/vistas/js/Himnario.js"></script>
</body>
</html>