// Archivo preparado para futuras interacciones
console.log("Espacio Juvenil cargado correctamente");


// Modal de eventos
const modal = document.getElementById('modal-evento');
const modalImg = document.getElementById('modal-img');
const modalTitulo = document.getElementById('modal-titulo');
const modalInfo = document.getElementById('modal-info');
const cerrarBtn = document.querySelector('.cerrar');

document.querySelectorAll('.evento-foto').forEach(foto => {
    foto.addEventListener('click', () => {
        modal.style.display = 'block';
        modalImg.src = foto.dataset.img;
        modalTitulo.textContent = foto.dataset.titulo;
        modalInfo.textContent = foto.dataset.info;
    });
});

cerrarBtn.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Cerrar modal al hacer click fuera del contenido
window.addEventListener('click', e => {
    if (e.target == modal) {
        modal.style.display = 'none';
    }
});
