<?php   
include_once($_SERVER['DOCUMENT_ROOT'] . "/iglesia/controladores/controlador_evento.php");
$controlador = new controlador_evento();
$eventos = $controlador->listarEventos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias de la ID</title>
    <link rel="stylesheet" href="vistas/css/himnario.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <section class="relative bg-cover bg-center h-64 flex items-center justify-center text-white"
             style="background-image: url('Imagenes/Notis.png'); ">
        <div class="bg-black bg-opacity-50 p-6 rounded">
            <h1 class="text-3xl md:text-4xl font-bold">Noticias de la ID</h1>
            <br />
            <a href="/iglesia/index.php" class="btn-volver">← Volver</a>
        </div>
    </section>

    


   <section class="container mx-auto py-10 px-6 grid grid-cols-1 md:grid-cols-2 gap-6">
    <?php foreach ($eventos as $evento) { ?>
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden cursor-pointer group"
             onclick="abrirNoticia('<?php echo htmlspecialchars(json_encode($evento)); ?>')">
            <img src="../admin/<?php echo $evento['foto']; ?>"
                 alt="<?php echo htmlspecialchars($evento['titulo']); ?>"
                 class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
            <div class="p-4">
                <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($evento['titulo']); ?></h2>
                <p class="text-gray-500 text-sm">Fecha: <?php echo date('d/m/Y', strtotime($evento['fecha'])); ?></p>
            </div>
        </div>
    <?php } ?>
</section>





    
  <div id="modalNoticia" class="fixed inset-0 bg-black bg-opacity-70 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg max-w-3xl w-full max-h-[90vh] overflow-y-auto p-6 relative">
        <button onclick="cerrarNoticia()" class="absolute top-3 right-3 text-gray-600 hover:text-black text-2xl">&times;</button>
        <h2 id="tituloNoticia" class="text-2xl font-bold mb-4"></h2>
        <div id="imagenesNoticia" class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4"></div>
        <p id="contenidoNoticia" class="text-gray-700 leading-relaxed"></p>
    </div>
</div>


    <script>
function abrirNoticia(eventoJson) {
    const evento = JSON.parse(eventoJson);
    const modal = document.getElementById("modalNoticia");
    const titulo = document.getElementById("tituloNoticia");
    const contenido = document.getElementById("contenidoNoticia");
    const imagenes = document.getElementById("imagenesNoticia");

    titulo.innerText = evento.titulo;
    contenido.innerText = evento.descripcion;
    imagenes.innerHTML = `
        <img src="../admin/${evento.foto}" alt="${evento.titulo}" class="w-full h-48 object-cover rounded-lg">
    `;
    modal.classList.remove("hidden");
}

function cerrarNoticia() {
    document.getElementById("modalNoticia").classList.add("hidden");
}
</script>



</body>
</html>
