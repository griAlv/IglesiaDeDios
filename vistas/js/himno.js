// Obtener el ID del himno de la URL
const urlParams = new URLSearchParams(window.location.search);
const idHimno = urlParams.get('id');

// Elementos del DOM
const tituloHimno = document.getElementById("titulo-himno");
const letraHimno = document.getElementById("letra-himno");
const atrasBtn = document.getElementById("atras");
const audioHimno = document.getElementById("audioHimno");

// Función para formatear el ID con ceros a la izquierda
function formatearIdHimno(id) {
    return id.toString().padStart(3, '0');
}

console.log('=== INICIO DE CARGA DE HIMNO ===');
console.log('URL completa:', window.location.href);
console.log('ID recibido:', idHimno);

if (!idHimno) {
    letraHimno.textContent = "ID de himno no especificado.";
    console.error('ID de himno no especificado');
} else {
    const idNumerico = parseInt(idHimno);
    console.log('ID numérico:', idNumerico);
    
    if (isNaN(idNumerico) || idNumerico <= 0) {
        letraHimno.textContent = "ID de himno no válido.";
        console.error('ID de himno inválido:', idHimno);
    } else {
        const idFormateado = formatearIdHimno(idNumerico);
        
        const rutaBase = window.location.origin + '/iglesia/vistas';
        const rutaJSON = `${rutaBase}/himnos/${idFormateado}.json`;
        
        console.log('ID formateado:', idFormateado);
        console.log('Ruta base:', rutaBase);
        console.log('Ruta JSON completa:', rutaJSON);
        
        fetch(rutaJSON)
            .then(res => {
                console.log('=== RESPUESTA DEL SERVIDOR ===');
                console.log('Status:', res.status);
                console.log('Status Text:', res.statusText);
                console.log('OK:', res.ok);
                console.log('URL final:', res.url);
                
                if (!res.ok) {
                    throw new Error(`Error ${res.status}: ${res.statusText}`);
                }
                return res.text();
            })
            .then(texto => {
                console.log('=== CONTENIDO RECIBIDO ===');
                console.log('Texto crudo (primeros 200 caracteres):', texto.substring(0, 200));
                
                let data;
                try {
                    data = JSON.parse(texto);
                    console.log('JSON parseado exitosamente:', data);
                } catch (e) {
                    console.error('Error al parsear JSON:', e);
                    throw new Error('El archivo no contiene JSON válido');
                }
                
                if (!data || !data.titulo || !data.letra) {
                    console.error('Datos incompletos:', data);
                    throw new Error("Formato de datos del himno no válido");
                }
                
                console.log('=== DATOS DEL HIMNO ===');
                console.log('ID:', data.id);
                console.log('Título:', data.titulo);
                console.log('Líneas de letra:', data.letra.length);
                console.log('Audio:', data.audio);
                
                // Mostrar el título del himno
                tituloHimno.textContent = data.titulo;
                console.log('Título mostrado:', data.titulo);
                
                // Actualizar título del reproductor
                if (songTitleEl) {
                    songTitleEl.textContent = data.titulo;
                }
                
                letraHimno.innerHTML = data.letra.map(linea => {
                    return linea.trim() === '' ? '<br>' : `<p>${linea}</p>`;
                }).join('');
                console.log('Letra mostrada');

                if (data.audio) {
                    const audioPath = data.audio.startsWith('http') ? 
                        data.audio : 
                        `${rutaBase}/${data.audio}`;
                        
                    console.log('=== CONFIGURACIÓN DE AUDIO ===');
                    console.log('Ruta de audio:', audioPath);
                    
                    // Actualizar mensaje de estado
                    const audioStatus = document.getElementById('audio-status');
                    if (audioStatus) {
                        audioStatus.textContent = 'Pista de audio';
                    }
                    
                    audioHimno.src = audioPath;
                    
                    audioHimno.onloadeddata = function() {
                        console.log('✓ Audio cargado correctamente');
                    };
                    
                    audioHimno.onerror = function(e) {
                        console.error('✗ Error al cargar el archivo de audio');
                        console.error('Evento de error:', e);
                        console.error('Ruta intentada:', audioPath);
                        
                        // Mostrar mensaje al usuario
                        if (audioStatus) {
                            audioStatus.textContent = 'Audio no disponible';
                        }
                    };
                    
                    // Forzar la carga del audio
                    audioHimno.load();
                } else {
                    console.log('No hay audio en el JSON');
                    const audioStatus = document.getElementById('audio-status');
                    
                    // Si no hay audio en el JSON, intentar con el formato estándar
                    const audioPath = `${rutaBase}/PistasHimnos/${idFormateado}.mp3`;
                    console.log('Buscando audio en ruta estándar:', audioPath);
                    
                    fetch(audioPath, { method: 'HEAD' })
                        .then(audioRes => {
                            if (audioRes.ok) {
                                console.log('✓ Audio encontrado en ruta estándar');
                                audioHimno.src = audioPath;
                                audioHimno.load();
                                if (audioStatus) {
                                    audioStatus.textContent = 'Pista de audio';
                                }
                            } else {
                                console.log('✗ No se encontró el archivo de audio en la ruta estándar');
                                if (audioStatus) {
                                    audioStatus.textContent = 'Audio no disponible';
                                }
                            }
                        })
                        .catch(err => {
                            console.error('Error al verificar el archivo de audio:', err);
                            if (audioStatus) {
                                audioStatus.textContent = 'Audio no disponible';
                            }
                        });
                }
            })
            .catch(err => {
                console.error('=== ERROR CRÍTICO ===');
                console.error('Tipo de error:', err.name);
                console.error('Mensaje:', err.message);
                console.error('Stack:', err.stack);
                
                letraHimno.innerHTML = `
                    <div style="padding: 20px; background: #ffebee; border-left: 4px solid #f44336; border-radius: 4px;">
                        <h3 style="color: #c62828; margin-top: 0;">❌ Error al cargar el himno</h3>
                        <p><strong>Mensaje:</strong> ${err.message}</p>
                        <p><strong>Archivo buscado:</strong> <code>${idFormateado}.json</code></p>
                        <p><strong>Ruta completa:</strong> <code>${rutaJSON}</code></p>
                        <hr>
                        <p><strong>Posibles causas:</strong></p>
                        <ul>
                            <li>El archivo JSON no existe en la carpeta <code>/iglesia/vistas/himnos/</code></li>
                            <li>El ID del himno no coincide con ningún archivo</li>
                            <li>Problemas de permisos en el servidor</li>
                        </ul>
                        <p><strong>Sugerencias:</strong></p>
                        <ul>
                            <li>Verifica que el archivo <code>${idFormateado}.json</code> exista</li>
                            <li>Abre la consola del navegador (F12) para más detalles</li>
                            <li>Intenta acceder directamente a: <a href="${rutaJSON}" target="_blank">${rutaJSON}</a></li>
                        </ul>
                    </div>
                `;
            });
    }
}

// Manejar el botón de regresar
if (atrasBtn) {
    atrasBtn.addEventListener("click", () => {
        console.log('Regresando a la página anterior');
        window.history.back();
    });
}

// ===== REPRODUCTOR MODERNO =====
const playerContainer = document.getElementById('playerContainer');
const playPauseBtn = document.getElementById('playPauseBtn');
const playPauseIcon = playPauseBtn ? playPauseBtn.querySelector('i') : null;
const progressBar = document.getElementById('progressBar');
const progressContainer = document.getElementById('progressContainer');
const currentTimeEl = document.getElementById('currentTime');
const songDurationEl = document.getElementById('songDuration');
const volumeSlider = document.getElementById('volumeSlider');
const songTitleEl = document.getElementById('songTitle');

// Función para formatear tiempo
function formatTime(seconds) {
    if (isNaN(seconds) || seconds === Infinity) return '0:00';
    const mins = Math.floor(seconds / 60);
    const secs = Math.floor(seconds % 60);
    return `${mins}:${secs.toString().padStart(2, '0')}`;
}

// Mostrar reproductor cuando el audio esté listo
audioHimno.addEventListener('loadedmetadata', function() {
    if (playerContainer) {
        playerContainer.classList.add('active');
    }
    if (songDurationEl) {
        songDurationEl.textContent = formatTime(audioHimno.duration);
    }
    console.log('Audio metadata cargada, duración:', audioHimno.duration);
});

// Play/Pause
if (playPauseBtn) {
    playPauseBtn.addEventListener('click', function() {
        if (audioHimno.paused) {
            audioHimno.play();
            if (playPauseIcon) {
                playPauseIcon.classList.remove('fa-play');
                playPauseIcon.classList.add('fa-pause');
            }
            if (playerContainer) {
                playerContainer.classList.add('playing');
            }
        } else {
            audioHimno.pause();
            if (playPauseIcon) {
                playPauseIcon.classList.remove('fa-pause');
                playPauseIcon.classList.add('fa-play');
            }
            if (playerContainer) {
                playerContainer.classList.remove('playing');
            }
        }
    });
}

// Actualizar barra de progreso y tiempo
audioHimno.addEventListener('timeupdate', function() {
    const progress = (audioHimno.currentTime / audioHimno.duration) * 100;
    if (progressBar) {
        progressBar.style.width = progress + '%';
    }
    if (currentTimeEl) {
        currentTimeEl.textContent = formatTime(audioHimno.currentTime);
    }
});

// Click en la barra de progreso
if (progressContainer) {
    progressContainer.addEventListener('click', function(e) {
        const rect = progressContainer.getBoundingClientRect();
        const clickX = e.clientX - rect.left;
        const width = rect.width;
        const percentage = clickX / width;
        audioHimno.currentTime = percentage * audioHimno.duration;
    });
}

// Control de volumen
if (volumeSlider) {
    volumeSlider.addEventListener('input', function() {
        audioHimno.volume = volumeSlider.value / 100;
    });
    // Establecer volumen inicial
    audioHimno.volume = 0.7;
}

// Cuando termine el audio
audioHimno.addEventListener('ended', function() {
    if (playPauseIcon) {
        playPauseIcon.classList.remove('fa-pause');
        playPauseIcon.classList.add('fa-play');
    }
    if (playerContainer) {
        playerContainer.classList.remove('playing');
    }
    if (progressBar) {
        progressBar.style.width = '0%';
    }
    audioHimno.currentTime = 0;
});