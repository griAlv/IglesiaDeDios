<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa de Iglesias - El Salvador</title>
    <!-- Bootstrap 5 y Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Leaflet CSS y JS -->
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
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            margin-bottom: 20px;
            text-align: center;
        }

        .header h1 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 2.5em;
        }

        .header p {
            color: #666;
            font-size: 1.1em;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card .icon {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .stat-card h3 {
            font-size: 2.5em;
            color: #667eea;
            margin-bottom: 5px;
        }

        .stat-card p {
            color: #666;
            font-weight: bold;
        }

        .content-area {
            display: grid;
            grid-template-columns: 350px 1fr;
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
            display: flex;
            align-items: center;
            gap: 10px;
        }

        #map {
            height: 700px;
            border-radius: 15px;
            overflow: hidden;
        }

        .search-box {
            margin-bottom: 20px;
        }

        .search-box input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e7ff;
            border-radius: 8px;
            font-size: 14px;
        }

        .search-box input:focus {
            outline: none;
            border-color: #667eea;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 8px 15px;
            border: 2px solid #e0e7ff;
            background: white;
            color: #667eea;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
            font-size: 12px;
        }

        .filter-btn.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .filter-btn:hover {
            transform: translateY(-2px);
        }

        .iglesias-list {
            max-height: 520px;
            overflow-y: auto;
        }

        .iglesia-card {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 12px;
            border-left: 4px solid #667eea;
            transition: all 0.3s;
            cursor: pointer;
        }

        .iglesia-card:hover {
            background: #e0e7ff;
            transform: translateX(5px);
            box-shadow: 0 3px 10px rgba(102, 126, 234, 0.3);
        }

        .iglesia-card.sede {
            border-left-color: #ef4444;
        }

        .iglesia-card.filial {
            border-left-color: #3b82f6;
        }

        .iglesia-card.mision {
            border-left-color: #10b981;
        }

        .iglesia-card h3 {
            color: #667eea;
            margin-bottom: 8px;
            font-size: 1.1em;
        }

        .iglesia-card p {
            color: #666;
            font-size: 13px;
            margin: 4px 0;
        }

        .tipo-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            margin-top: 8px;
        }

        .tipo-badge.sede {
            background: #fee2e2;
            color: #991b1b;
        }

        .tipo-badge.filial {
            background: #dbeafe;
            color: #1e40af;
        }

        .tipo-badge.mision {
            background: #d1fae5;
            color: #065f46;
        }

        .leaflet-popup-content {
            margin: 15px;
        }

        .popup-title {
            font-weight: bold;
            color: #667eea;
            font-size: 18px;
            margin-bottom: 12px;
        }

        .popup-info {
            margin: 8px 0;
            font-size: 14px;
            color: #333;
        }

        .custom-marker {
            width: 30px;
            height: 40px;
            display: block;
            position: relative;
        }

        .no-results {
            text-align: center;
            color: #999;
            padding: 40px 20px;
            font-style: italic;
        }

        .legend {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            border: 2px solid #e0e7ff;
        }

        .legend h4 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 8px 0;
            font-size: 13px;
        }

        .legend-icon {
            width: 20px;
            height: 26px;
        }

        @media (max-width: 968px) {
            .content-area {
                grid-template-columns: 1fr;
            }
            
            .stats {
                grid-template-columns: 1fr;
            }
        }

        /* Scrollbar personalizado */
        .iglesias-list::-webkit-scrollbar {
            width: 8px;
        }

        .iglesias-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .iglesias-list::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 10px;
        }

        .iglesias-list::-webkit-scrollbar-thumb:hover {
            background: #5568d3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏛️ Mapa de Iglesias</h1>
            <p>Encuentra las iglesias más cercanas - El Salvador</p>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="icon">🏛️</div>
                <h3 id="total-iglesias">0</h3>
                <p>Total Iglesias</p>
            </div>
            <div class="stat-card">
                <div class="icon">📍</div>
                <h3 id="total-departamentos">0</h3>
                <p>Departamentos</p>
            </div>
        </div>

        <div class="content-area">
            <div class="panel">
                <h2>📋 Lista de Iglesias</h2>
                
                <div class="search-box">
                    <input type="text" id="search" placeholder="🔍 Buscar por nombre, ciudad o departamento..." onkeyup="filtrarIglesias()">
                </div>


                <div class="iglesias-list" id="lista-iglesias"></div>

            </div>

            <div class="panel">
                <h2>🗺️ Mapa Interactivo</h2>
                <div id="map"></div>
            </div>
        </div>
    </div>

    <script>
        let map;
        let markers = [];
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

        window.onload = function() {
            cargarDatos();
            initMap();
            renderizarLista();
            actualizarEstadisticas();
            
            // Actualización automática cada 3 segundos
            setInterval(function() {
                const cantidadAnterior = iglesias.length;
                cargarDatos();
                
                if (iglesias.length !== cantidadAnterior) {
                    renderizarMarcadores();
                    renderizarLista();
                    actualizarEstadisticas();
                }
            }, 3000);
        };

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
                });
        }

        function initMap() {
            map = L.map('map').setView([13.6929, -89.2182], 9);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            renderizarMarcadores();
        }

        function renderizarMarcadores() {
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];

            const iglesiasVisibles = iglesias;

            iglesiasVisibles.forEach(function(iglesia) {
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

            // Ajustar el mapa para mostrar todos los marcadores
            if (markers.length > 0) {
                const group = L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.1));
            }
        }

        function renderizarLista() {
            const lista = document.getElementById('lista-iglesias');
            lista.innerHTML = '';

            const iglesiasVisibles = iglesias;

            if (iglesiasVisibles.length === 0) {
                lista.innerHTML = '<div class="no-results">No hay iglesias para mostrar</div>';
                return;
            }

            iglesiasVisibles.forEach(function(iglesia) {
                const card = document.createElement('div');
                card.className = 'iglesia-card';
                card.onclick = () => volarAIglesia(iglesia.lat, iglesia.lng);
                
                let html = `
                    <h3>${iglesia.nombre}</h3>
                    <p>📍 ${iglesia.ciudad}, ${iglesia.departamento}</p>
                `;
                
                if (iglesia.direccion) html += `<p>🏠 ${iglesia.direccion}</p>`;
                
                card.innerHTML = html;
                lista.appendChild(card);
            });
        }

        function volarAIglesia(lat, lng) {
            map.flyTo([lat, lng], 16, {
                duration: 1.5
            });
        }

        function filtrarIglesias() {
            const busqueda = document.getElementById('search').value.toLowerCase();
            const cards = document.querySelectorAll('.iglesia-card');
            
            cards.forEach(function(card) {
                const texto = card.textContent.toLowerCase();
                card.style.display = texto.includes(busqueda) ? 'block' : 'none';
            });
        }


        function actualizarEstadisticas() {
            document.getElementById('total-iglesias').textContent = iglesias.length;
            
            const departamentosUnicos = new Set(iglesias.map(i => i.departamento));
            document.getElementById('total-departamentos').textContent = departamentosUnicos.size;
            
        }
    </script>
</body>
</html>