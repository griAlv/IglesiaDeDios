<?php 
include_once(__DIR__ . "/../../controladores/controlador_evento.php"); 
$controlador = new controlador_evento(); 
$actividades = $controlador->listarEventos();   
?>

<!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />

<style>
    /* Header Personalizado */
    .custom-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 60px 0;
        margin-bottom: 40px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .custom-header h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 15px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }
    
    .custom-header p {
        font-size: 1.3rem;
        opacity: 0.95;
    }

    /* Cards de Actividades */
    .activity-card {
        transition: all 0.3s ease;
        overflow: hidden;
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        height: 100%;
        background: white;
    }
    
    .activity-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.2);
    }
    
    .img-container {
        width: 100%;
        height: 250px;
        overflow: hidden;
        position: relative;
        background: #f8f9fa;
    }
    
    .activity-card .card-img-top {
        height: 250px;
        width: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform 0.5s ease;
    }
    
    .activity-card:hover .card-img-top {
        transform: scale(1.1);
    }
    
    .img-placeholder {
        height: 250px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 4rem;
    }

    /* Card Body */
    .activity-card .card-body {
        padding: 25px;
    }

    .activity-card .card-body h4 {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 20px;
        font-size: 1.4rem;
    }

    /* Badges */
    .event-badge {
        display: inline-block;
        padding: 8px 15px;
        margin: 5px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    .badge-custom-success {
        background-color: #10b981;
        color: white;
    }

    .badge-custom-info {
        background-color: #3b82f6;
        color: white;
    }

    /* Botones Mejorados */
    .btn-details {
        border-radius: 25px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        margin-top: 8px;
    }

    .btn-details:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn-primary.btn-details {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .btn-success.btn-details {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    /* Modal Personalizado */
    .modal-header-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 0;
        padding: 20px 25px;
    }

    .modal-header-custom .btn-close {
        filter: brightness(0) invert(1);
    }

    .modal-header-custom h5 {
        font-weight: 700;
        font-size: 1.5rem;
    }

    .modal-img {
        max-height: 400px;
        width: 100%;
        object-fit: contain;
        border-radius: 8px;
    }

    .modal-body {
        padding: 30px;
    }

    .modal-body ul li {
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }

    .modal-body ul li:last-child {
        border-bottom: none;
    }

    /* Calendario */
    .calendar-section {
        background: #f8f9fa;
        padding: 60px 0;
        margin-top: 40px;
    }

    #calendar {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Fix para FullCalendar */
    .fc {
        font-family: inherit;
    }

    .fc .fc-button {
        background-color: #667eea;
        border-color: #667eea;
    }

    .fc .fc-button:hover {
        background-color: #5568d3;
        border-color: #5568d3;
    }

    .fc .fc-button-primary:not(:disabled).fc-button-active {
        background-color: #764ba2;
        border-color: #764ba2;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .custom-header h1 {
            font-size: 2rem;
        }
        
        .custom-header p {
            font-size: 1rem;
        }

        #calendar {
            padding: 15px;
        }
    }
</style>

<!-- Header Personalizado -->
<div class="custom-header">
    <div class="container text-center">
        <h1><i class="bi bi-calendar-event"></i> Nuestras Actividades</h1>
        <p>¡Únete a nosotros y forma parte de nuestra comunidad!</p>
    </div>
</div>

<!-- Sección de Cards -->
<div class="container py-5">
    <div class="row g-4">
        <?php foreach ($actividades as $evento): ?>
            <div class="col-lg-4 col-md-6">
                <div class="card activity-card">
                    
                    <!-- Imagen -->
                    <div class="img-container">
                        <?php if (!empty($evento['foto'])): ?>
                            <img src="/iglesia/vistas/admin/Imagenes/imagen/<?= basename($evento['foto']) ?>" 
                                 class="card-img-top" 
                                 alt="<?= htmlspecialchars($evento['titulo']) ?>">
                        <?php else: ?>
                            <div class="img-placeholder">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Contenido -->
                    <div class="card-body text-center">
                        <h4><?= htmlspecialchars($evento['titulo']) ?></h4>
                        
                        <p class="mb-2 text-muted">
                            <i class="bi bi-calendar3"></i> <?= htmlspecialchars($evento['fecha']) ?>
                        </p>
                        <p class="mb-2 text-muted">
                            <i class="bi bi-clock"></i> <?= htmlspecialchars($evento['hora']) ?>
                        </p>
                        <p class="mb-3 text-muted">
                            <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($evento['lugar']) ?>
                        </p>

                        <div class="my-3">
                            <span class="event-badge badge-custom-success">
                                <i class="bi bi-tag"></i> Gratis
                            </span>
                            <span class="event-badge badge-custom-info">
                                <i class="bi bi-person"></i> <?= htmlspecialchars($evento['tipo']) ?>
                            </span>
                        </div>

                        <div class="d-grid gap-2">
                            <button class="btn btn-primary btn-details" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalActividad<?= $evento['idevento'] ?>">
                                <i class="bi bi-info-circle"></i> Ver detalles
                            </button>
                            <button class="btn btn-success btn-details scroll-to-calendar" 
                                    data-fecha="<?= htmlspecialchars($evento['fecha']) ?>">
                                <i class="bi bi-calendar-check"></i> Ver en calendario
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modales Bootstrap 5 -->
<?php foreach ($actividades as $evento): ?>
    <div class="modal fade" id="modalActividad<?= $evento['idevento'] ?>" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title">
                        <i class="bi bi-calendar-event"></i> <?= htmlspecialchars($evento['titulo']) ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <?php if (!empty($evento['foto'])): ?>
                                <img src="/iglesia/vistas/admin/Imagenes/imagen/<?= basename($evento['foto']) ?>" 
                                     class="modal-img img-fluid" 
                                     alt="<?= htmlspecialchars($evento['titulo']) ?>">
                            <?php else: ?>
                                <div class="bg-light p-5 rounded d-flex align-items-center justify-content-center" style="min-height: 300px;">
                                    <i class="bi bi-image" style="font-size: 4rem; color: #999;"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled fs-6">
                                <li>
                                    <i class="bi bi-calendar3 text-primary"></i> 
                                    <strong>Fecha:</strong> <?= htmlspecialchars($evento['fecha']) ?>
                                </li>
                                <li>
                                    <i class="bi bi-clock text-primary"></i> 
                                    <strong>Hora:</strong> <?= htmlspecialchars($evento['hora']) ?>
                                </li>
                                <li>
                                    <i class="bi bi-geo-alt text-primary"></i> 
                                    <strong>Lugar:</strong> <?= htmlspecialchars($evento['lugar']) ?>
                                </li>
                                <li>
                                    <i class="bi bi-person text-info"></i> 
                                    <strong>Tipo:</strong> <?= htmlspecialchars($evento['tipo']) ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Sección Calendario -->
<div class="calendar-section">
    <div class="container">
        <h3 class="text-center fw-bold text-dark mb-5" style="font-size: 2rem;">
            <i class="bi bi-calendar3"></i> Calendario de Actividades
        </h3>
        <div id='calendar'></div>
    </div>
</div>

<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/es.global.min.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar el calendario
    var calendarEl = document.getElementById('calendar');
    
    if (calendarEl) {
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            height: 'auto',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                list: 'Lista'
            },
            events: [
                <?php 
                $count = 0;
                foreach ($actividades as $evento): 
                    $count++;
                ?>
                {
                    title: "<?= htmlspecialchars($evento['titulo']) ?>",
                    start: "<?= htmlspecialchars($evento['fecha']) ?>",
                    url: "#modalActividad<?= $evento['idevento'] ?>",
                    color: '#667eea',
                    extendedProps: {
                        modalId: 'modalActividad<?= $evento['idevento'] ?>'
                    }
                }<?= $count < count($actividades) ? ',' : '' ?>
                <?php endforeach; ?>
            ],
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                
                // Abrir modal de Bootstrap 5
                if (info.event.extendedProps.modalId) {
                    var modalElement = document.getElementById(info.event.extendedProps.modalId);
                    if (modalElement) {
                        var modal = new bootstrap.Modal(modalElement);
                        modal.show();
                    }
                }
            }
        });
        
        calendar.render();

        // Botón "Ver en calendario" con smooth scroll
        document.querySelectorAll('.scroll-to-calendar').forEach(function(button) {
            button.addEventListener('click', function() {
                var fecha = this.getAttribute('data-fecha');
                
                // Scroll suave al calendario
                document.getElementById('calendar').scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                
                // Cambiar la fecha del calendario
                if (fecha) {
                    setTimeout(function() {
                        calendar.gotoDate(fecha);
                    }, 800);
                }
            });
        });
    }
});
</script>