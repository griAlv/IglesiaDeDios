
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<!-- HEADER (navbar) -->
 
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php?url=dashboard_admin">
      <i class="bi bi-speedometer2"></i> Admin Iglesia
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarAdmin" aria-controls="navbarAdmin" 
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarAdmin">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <!-- Personas -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="personasDropdown" role="button" 
             data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-people-fill"></i> usuarioss
          </a>
          <ul class="dropdown-menu" aria-labelledby="personasDropdown">
            <li><a class="dropdown-item" href="index.php?url=lista_usuario">Lista de usuarios</a></li>
            <li><a class="dropdown-item" href="index.php?url=agregar_usuario">Agregar usuario</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="personasDropdown" role="button" 
             data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-people-fill"></i> predicas
          </a>
          <ul class="dropdown-menu" aria-labelledby="personasDropdown">
            <li><a class="dropdown-item" href="index.php?url=lista_predicas">Lista de predicas</a></li>
            <li><a class="dropdown-item" href="index.php?url=nueva_predicacion">Agregar predica</a></li>
          </ul>
        </li>

        <!-- localidades -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="actividadesDropdown" role="button" 
             data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-calendar-event"></i> localidades
          </a>
          <ul class="dropdown-menu" aria-labelledby="actividadesDropdown">
            <li><a class="dropdown-item" href="index.php?url=localidades">Localidades</a></li>
  
          
          </ul>
        </li>

        <!-- escuelas sabáticas -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="gruposDropdown" role="button" 
             data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-collection"></i> escuelas sabáticas y documentos
          </a>
          <ul class="dropdown-menu" aria-labelledby="gruposDropdown">
            <li><a class="dropdown-item" href="index.php?url=listar_escuelas">Lista de escuelas sabáticas</a></li>
            <li><a class="dropdown-item" href="index.php?url=agregar_escuela  ">Crear escuela sabática</a></li>
            <li><a class="dropdown-item" href="index.php?url=nuevo_documento">Nuevo documento</a></li>
            <li><a class="dropdown-item" href="index.php?url=listar_documento">Listar documentos</a></li>
          </ul>
        </li>

        

        <!-- Himnos -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="himnosDropdown" role="button" 
             data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-music-note-list"></i> Himnos
          </a>
          <ul class="dropdown-menu" aria-labelledby="himnosDropdown">
            <li><a class="dropdown-item" href="index.php?url=añadir_alabaza"><i class="bi bi-plus-circle me-2"></i>Agregar Alabanza</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><h6 class="dropdown-header"><i class="bi bi-cloud me-2"></i>Cloudinary</h6></li>
            <li><a class="dropdown-item" href="test_cloudinary.php"><i class="bi bi-cloud-check me-2"></i>Probar Conexión</a></li>
            <li><a class="dropdown-item" href="migrar_a_cloudinary.php"><i class="bi bi-cloud-upload me-2"></i>Migrar Himnos</a></li>
          </ul>
        </li>

        <!-- Sistema -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="sistemaDropdown" role="button" 
             data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-gear-fill"></i> Eventos y actividades
          </a>
          <ul class="dropdown-menu" aria-labelledby="sistemaDropdown">
            <li><a class="dropdown-item" href="index.php?url=todos_evetos">todos los eventos</a></li>
            <li><a class="dropdown-item" href="index.php?url=nuevo_evento">Nuevo evento</a></li>
          </ul>
        </li>

      </ul>

      
      <!-- Perfil -->
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="perfilDropdown" role="button" 
             data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle"></i> <?php echo $_SESSION['usuario']['nombre']; ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="perfilDropdown">
            <li><a class="dropdown-item" href="index.php?url=perfil">Perfil</a></li>
            
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="index.php?url=logout">Cerrar Sesión</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
