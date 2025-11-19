<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Mapa de Iglesias - El Salvador</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            margin-bottom: 20px;
        }

        .header h1 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 2em;
        }

        .tabs {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        .tab-btn {
            padding: 12px 25px;
            border: none;
            background: #e0e7ff;
            color: #667eea;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
        }

        .tab-btn.active {
            background: #667eea;
            color: white;
        }

        .tab-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .panel {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .panel h2 {
            color: #667eea;
            margin-bottom: 20px;
            font-size: 1.5em;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 2px solid #e0e7ff;
            border-radius: 8px;
            font-size: 14px;
            transition: border 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-group small {
            color: #666;
            font-size: 12px;
            display: block;
            margin-top: 3px;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
            font-size: 14px;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        #map, #map-selector {
            height: 600px;
            border-radius: 15px;
            overflow: hidden;
            z-index: 1;
        }

        .leaflet-popup-content {
            margin: 15px;
        }

        .popup-title {
            font-weight: bold;
            color: #667eea;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .popup-info {
            margin: 5px 0;
            font-size: 13px;
            color: #333;
        }

        .iglesias-list {
            max-height: 600px;
            overflow-y: auto;
        }

        .iglesia-item {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            border-left: 4px solid #667eea;
            transition: all 0.3s;
            cursor: pointer;
        }

        .iglesia-item:hover {
            background: #e0e7ff;
            transform: translateX(5px);
        }

        .iglesia-item h3 {
            color: #667eea;
            margin-bottom: 5px;
        }

        .iglesia-item p {
            color: #666;
            font-size: 13px;
            margin: 3px 0;
        }

        .iglesia-actions {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .stat-card h3 {
            font-size: 2em;
            margin-bottom: 5px;
        }

        .stat-card p {
            opacity: 0.9;
        }

        .hidden {
            display: none;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        @media (max-width: 968px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            .stats {
                grid-template-columns: 1fr;
            }
        }

        .search-box {
            margin-bottom: 15px;
        }

        .search-box input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e7ff;
            border-radius: 8px;
            font-size: 14px;
        }

        .map-click-instruction {
            background: #fef3c7;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            border-left: 4px solid #f59e0b;
            font-size: 14px;
        }

        .custom-marker {
            width: 30px;
            height: 40px;
            display: block;
            position: relative;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏛️ Sistema de Gestión de Iglesias</h1>
            <p>Panel de Administración - El Salvador</p>
            
            <div class="tabs">
                <button class="tab-btn active" onclick="showTab('mapa')">📍 Ver Mapa</button>
                <button class="tab-btn" onclick="showTab('agregar')">➕ Agregar Iglesia</button>
                <button class="tab-btn" onclick="showTab('lista')">📋 Lista de Iglesias</button>
            </div>
        </div>

        <div id="alert-container"></div>

        <div id="tab-mapa" class="tab-content">
            <div class="stats">
                <div class="stat-card">
                    <h3 id="total-iglesias">0</h3>
                    <p>Total Iglesias</p>
                </div>
                <div class="stat-card">
                    <h3 id="total-departamentos">0</h3>
                    <p>Departamentos</p>
                </div>
                <div class="stat-card">
                    <h3 id="ultima-actualizacion">--</h3>
                    <p>Última Actualización</p>
                </div>
            </div>

            <div class="panel">
                <h2>🗺️ Mapa Interactivo de El Salvador</h2>
                <div id="map"></div>
            </div>
        </div>

        <div id="tab-agregar" class="tab-content hidden">
            <div class="panel">
                <h2>➕ Agregar Nueva Iglesia</h2>
                
                <div class="map-click-instruction">
                    💡 <strong>Consejo:</strong> Haz clic en el mapa de abajo para seleccionar la ubicación automáticamente
                </div>

                <form id="form-agregar" onsubmit="agregarIglesia(event)">
                    <div class="form-group">
                        <label>Nombre de la Iglesia *</label>
                        <input type="text" id="nombre" required placeholder="Ej: Iglesia Central">
                    </div>

                    <div class="form-group">
                        <label>Departamento *</label>
                        <select id="departamento" required>
                            <option value="">Seleccione un departamento</option>
                            <option value="Ahuachapán">Ahuachapán</option>
                            <option value="Santa Ana">Santa Ana</option>
                            <option value="Sonsonate">Sonsonate</option>
                            <option value="Chalatenango">Chalatenango</option>
                            <option value="La Libertad">La Libertad</option>
                            <option value="San Salvador">San Salvador</option>
                            <option value="Cuscatlán">Cuscatlán</option>
                            <option value="La Paz">La Paz</option>
                            <option value="Cabañas">Cabañas</option>
                            <option value="San Vicente">San Vicente</option>
                            <option value="Usulután">Usulután</option>
                            <option value="San Miguel">San Miguel</option>
                            <option value="Morazán">Morazán</option>
                            <option value="La Unión">La Unión</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Ciudad/Municipio *</label>
                        <input type="text" id="ciudad" required placeholder="Ej: San Salvador">
                    </div>

                    <div class="form-group">
                        <label>Dirección</label>
                        <textarea id="direccion" rows="2" placeholder="Dirección completa"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Coordenadas (Latitud) *</label>
                        <input type="number" id="lat" required step="0.000001" value="13.6929">
                        <small>Haz clic en el mapa para obtener coordenadas</small>
                    </div>

                    <div class="form-group">
                        <label>Coordenadas (Longitud) *</label>
                        <input type="number" id="lng" required step="0.000001" value="-89.2182">
                    </div>

                    <button type="submit" class="btn btn-primary">💾 Guardar Iglesia</button>
                </form>

                <div class="panel" style="margin-top: 20px;">
                    <h3 style="color: #667eea; margin-bottom: 15px;">🗺️ Seleccionar ubicación en el mapa</h3>
                    <div id="map-selector"></div>
                </div>
            </div>
        </div>

        <div id="tab-lista" class="tab-content hidden">
            <div class="panel">
                <h2>📋 Lista de Iglesias Registradas</h2>
                
                <div class="search-box">
                    <input type="text" id="search" onkeyup="filtrarIglesias()" placeholder="🔍 Buscar por nombre, ciudad o departamento...">
                </div>

                <div class="iglesias-list" id="lista-iglesias"></div>
            </div>
        </div>
    </div>

    <script>
        let map;
        let mapSelector;
        let markers = [];
        let tempMarker = null;
        let iglesias = [];

        // Iconos personalizados
        const iconoSede = L.divIcon({
            className: 'custom-marker',
            html: `<svg width="30" height="40" viewBox="0 0 20 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M20 9.81818C20 16.1306 13.1668 21.6976 10.7975 23.4382C10.3169 23.7913 9.68311 23.7913 9.20251 23.4382C6.83318 21.6976 0 16.1306 0 9.81818C8.22968e-08 4.39575 4.47715 0 10 0C15.5228 0 20 4.39575 20 9.81818Z" fill="#ef4444"/>
                <circle cx="10" cy="9" r="3" fill="#FFFFFF"/>
            </svg>`,
            iconSize: [30, 40],
            iconAnchor: [15, 40],
            popupAnchor: [0, -40]
        });

        const iconoFilial = L.divIcon({
            className: 'custom-marker',
            html: `<svg width="30" height="40" viewBox="0 0 20 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M20 9.81818C20 16.1306 13.1668 21.6976 10.7975 23.4382C10.3169 23.7913 9.68311 23.7913 9.20251 23.4382C6.83318 21.6976 0 16.1306 0 9.81818C8.22968e-08 4.39575 4.47715 0 10 0C15.5228 0 20 4.39575 20 9.81818Z" fill="#3b82f6"/>
                <circle cx="10" cy="9" r="3" fill="#FFFFFF"/>
            </svg>`,
            iconSize: [30, 40],
            iconAnchor: [15, 40],
            popupAnchor: [0, -40]
        });

        const iconoMision = L.divIcon({
            className: 'custom-marker',
            html: `<svg width="30" height="40" viewBox="0 0 20 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M20 9.81818C20 16.1306 13.1668 21.6976 10.7975 23.4382C10.3169 23.7913 9.68311 23.7913 9.20251 23.4382C6.83318 21.6976 0 16.1306 0 9.81818C8.22968e-08 4.39575 4.47715 0 10 0C15.5228 0 20 4.39575 20 9.81818Z" fill="#10b981"/>
                <circle cx="10" cy="9" r="3" fill="#FFFFFF"/>
            </svg>`,
            iconSize: [30, 40],
            iconAnchor: [15, 40],
            popupAnchor: [0, -40]
        });

        const iconoTemp = L.divIcon({
            className: 'custom-marker',
            html: `<svg width="30" height="40" viewBox="0 0 20 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M20 9.81818C20 16.1306 13.1668 21.6976 10.7975 23.4382C10.3169 23.7913 9.68311 23.7913 9.20251 23.4382C6.83318 21.6976 0 16.1306 0 9.81818C8.22968e-08 4.39575 4.47715 0 10 0C15.5228 0 20 4.39575 20 9.81818Z" fill="#667eea"/>
                <circle cx="10" cy="9" r="3" fill="#FFFFFF"/>
            </svg>`,
            iconSize: [30, 40],
            iconAnchor: [15, 40],
            popupAnchor: [0, -40]
        });

        window.onload = function() {
            cargarDatos();
            initMap();
            actualizarEstadisticas();
            renderizarLista();
        };

        function initMap() {
            // Mapa principal
            map = L.map('map').setView([13.6929, -89.2182], 9);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            renderizarMarcadores();
        }

        function initMapSelector() {
            if (mapSelector) return;
            
            // Mapa selector
            mapSelector = L.map('map-selector').setView([13.6929, -89.2182], 9);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(mapSelector);

            mapSelector.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;
                
                document.getElementById('lat').value = lat.toFixed(6);
                document.getElementById('lng').value = lng.toFixed(6);

                if (tempMarker) {
                    mapSelector.removeLayer(tempMarker);
                }

                tempMarker = L.marker([lat, lng], { icon: iconoTemp }).addTo(mapSelector);
                mostrarAlerta('Ubicación seleccionada: ' + lat.toFixed(4) + ', ' + lng.toFixed(4), 'success');
            });
        }

        function cargarDatos() {
            fetch('/iglesia/api/localidades.php?action=listar')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        iglesias = data.data;
                        renderizarMarcadores();
                        renderizarLista();
                        actualizarEstadisticas();
                    }
                })
                .catch(error => {
                    console.error('Error al cargar datos:', error);
                    mostrarAlerta('Error al cargar datos', 'error');
                });
        }

        function guardarDatos() {
            // Ya no se usa localStorage, los datos se guardan en la base de datos
        }

        function renderizarMarcadores() {
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];

            iglesias.forEach(function(iglesia) {
                const icono = iconoSede;

                const popupHTML = `
                    <div class="popup-title">${iglesia.nombre}</div>
                    <div class="popup-info"><strong>📍</strong> ${iglesia.ciudad}, ${iglesia.departamento}</div>
                    ${iglesia.direccion ? `<div class="popup-info"><strong>🏠</strong> ${iglesia.direccion}</div>` : ''}
                `;

                const marker = L.marker([iglesia.lat, iglesia.lng], { icon: icono })
                    .bindPopup(popupHTML)
                    .addTo(map);

                markers.push(marker);
            });
        }

        function agregarIglesia(event) {
            event.preventDefault();

            const formData = new FormData();
            formData.append('nombre', document.getElementById('nombre').value);
            formData.append('departamento', document.getElementById('departamento').value);
            formData.append('ciudad', document.getElementById('ciudad').value);
            formData.append('direccion', document.getElementById('direccion').value);
            formData.append('lat', document.getElementById('lat').value);
            formData.append('lng', document.getElementById('lng').value);

            fetch('/iglesia/api/localidades.php?action=agregar', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarAlerta('✅ Iglesia agregada exitosamente', 'success');
                    document.getElementById('form-agregar').reset();
                    
                    if (tempMarker && mapSelector) {
                        mapSelector.removeLayer(tempMarker);
                        tempMarker = null;
                    }

                    cargarDatos();
                    
                    setTimeout(function() {
                        showTab('mapa');
                    }, 1500);
                } else {
                    mostrarAlerta('❌ Error: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarAlerta('❌ Error al guardar la iglesia', 'error');
            });
        }

        function editarIglesia(id) {
            const iglesia = iglesias.find(i => i.id === id);
            if (!iglesia) return;

            document.getElementById('nombre').value = iglesia.nombre;
            document.getElementById('departamento').value = iglesia.departamento;
            document.getElementById('ciudad').value = iglesia.ciudad;
            document.getElementById('direccion').value = iglesia.direccion;
            document.getElementById('lat').value = iglesia.lat;
            document.getElementById('lng').value = iglesia.lng;

            eliminarIglesiaSinConfirmar(id);
            showTab('agregar');
            
            setTimeout(() => {
                initMapSelector();
                if (tempMarker) mapSelector.removeLayer(tempMarker);
                tempMarker = L.marker([iglesia.lat, iglesia.lng], { icon: iconoTemp }).addTo(mapSelector);
                mapSelector.setView([iglesia.lat, iglesia.lng], 13);
            }, 100);

            mostrarAlerta('✏️ Editando iglesia. Modifica los datos y guarda.', 'success');
        }

        function eliminarIglesia(id) {
            if (confirm('¿Estás seguro de eliminar esta iglesia?')) {
                eliminarIglesiaSinConfirmar(id);
            }
        }

        function eliminarIglesiaSinConfirmar(id) {
            fetch('/iglesia/api/localidades.php?action=eliminar&id=' + id, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarAlerta('🗑️ Iglesia eliminada', 'success');
                    cargarDatos();
                } else {
                    mostrarAlerta('❌ Error: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarAlerta('❌ Error al eliminar la iglesia', 'error');
            });
        }

        function volarAIglesia(lat, lng) {
            showTab('mapa');
            setTimeout(() => {
                map.flyTo([lat, lng], 15, {
                    duration: 2
                });
            }, 300);
        }

        function renderizarLista() {
            const lista = document.getElementById('lista-iglesias');
            lista.innerHTML = '';

            if (iglesias.length === 0) {
                lista.innerHTML = '<p style="text-align:center; color:#999; padding:40px;">No hay iglesias registradas</p>';
                return;
            }

            iglesias.forEach(function(iglesia) {
                const item = document.createElement('div');
                item.className = 'iglesia-item';
                item.onclick = () => volarAIglesia(iglesia.lat, iglesia.lng);
                
                let html = `<h3>${iglesia.nombre}</h3>
                    <p><strong>📍 Ubicación:</strong> ${iglesia.ciudad}, ${iglesia.departamento}</p>`;
                
                if (iglesia.direccion) html += `<p><strong>🏠 Dirección:</strong> ${iglesia.direccion}</p>`;
                
                html += `
                    <div class="iglesia-actions">
                        <button class="btn btn-warning" onclick="event.stopPropagation(); editarIglesia(${iglesia.id})">✏️ Editar</button>
                        <button class="btn btn-danger" onclick="event.stopPropagation(); eliminarIglesia(${iglesia.id})">🗑️ Eliminar</button>
                    </div>`;
                
                item.innerHTML = html;
                lista.appendChild(item);
            });
        }

        function filtrarIglesias() {
            const busqueda = document.getElementById('search').value.toLowerCase();
            const items = document.querySelectorAll('.iglesia-item');
            
            items.forEach(function(item) {
                const texto = item.textContent.toLowerCase();
                item.style.display = texto.includes(busqueda) ? 'block' : 'none';
            });
        }

        function actualizarEstadisticas() {
            document.getElementById('total-iglesias').textContent = iglesias.length;
            
            const departamentosUnicos = new Set(iglesias.map(i => i.departamento));
            document.getElementById('total-departamentos').textContent = departamentosUnicos.size;
            
            const ahora = new Date();
            document.getElementById('ultima-actualizacion').textContent = 
                ahora.getHours() + ':' + String(ahora.getMinutes()).padStart(2, '0');
        }

        function showTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            
            document.getElementById('tab-' + tabName).classList.remove('hidden');
            
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');

            if (tabName === 'agregar') {
                setTimeout(() => initMapSelector(), 100);
            }
            
            if (tabName === 'mapa') {
                setTimeout(() => {
                    map.invalidateSize();
                    renderizarMarcadores();
                }, 100);
            }
        }

        function mostrarAlerta(mensaje, tipo) {
            const alertContainer = document.getElementById('alert-container');
            const alert = document.createElement('div');
            alert.className = 'alert alert-' + tipo;
            alert.textContent = mensaje;
            alertContainer.appendChild(alert);
            
            setTimeout(function() {
                alert.remove();
            }, 3000);
        }
    </script>
</body>
</html>