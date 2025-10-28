document.addEventListener("DOMContentLoaded", () => {

    /* ================= SLIDER DE MINISTERIOS ================= */
    (function () {
        const cajas = document.querySelector('.cajas');
        const totalCajas = document.querySelectorAll('.caja').length;
        const nexto = document.querySelector('.nexto');
        const prevo = document.querySelector('.prevo');
        let index = 0;

        function mostrarCaja(i) {
            cajas.style.transform = `translateX(-${i * 100}%)`;
        }

        nexto.addEventListener('click', () => {
            index = (index + 1) % totalCajas;
            mostrarCaja(index);
        });

        prevo.addEventListener('click', () => {
            index = (index - 1 + totalCajas) % totalCajas;
            mostrarCaja(index);
        });

        // Auto-play
        setInterval(() => {
            index = (index + 1) % totalCajas;
            mostrarCaja(index);
        }, 3000);
    })();


    /* ================= SLIDER DE NOTICIAS ================= */
    (function () {
        const slides = document.querySelectorAll(".noticia-slide");
        if (slides.length === 0) return; // Evita errores si no hay noticias
        let index = 0;

        function mostrarSlide(i) {
            slides.forEach(slide => slide.classList.remove("active"));
            slides[i].classList.add("active");
        }

        mostrarSlide(index);

        setInterval(() => {
            index = (index + 1) % slides.length;
            mostrarSlide(index);
        }, 5000);
    })();


    /* ================= SLIDER "M�S DE NOSOTROS" ================= */
    (function () {
       
                // Script para el carrusel de ministerios
        let currentMinisterioIndex = 0;
        const ministerioCajas = document.querySelector('.carrusel-ministerios .cajas');
        const totalMinisterios = document.querySelectorAll('.carrusel-ministerios .caja').length;

        function moverCarrusel(direction) {
            currentMinisterioIndex = (currentMinisterioIndex + direction + totalMinisterios) % totalMinisterios;
            ministerioCajas.style.transform = `translateX(-${currentMinisterioIndex * 100}%)`;
        }

        // Auto-play para el carrusel de ministerios
        setInterval(() => {
            moverCarrusel(1);
        }, 5000);

        // Script para el carrusel "Más de nosotros"
        let currentSlideIndex = 0;
        const slidesContainer = document.querySelector('.slider .slides');
        const slides = document.querySelectorAll('.slider .slide');
        const dots = document.querySelectorAll('.slider .dot');
        const totalSlides = slides.length;
        const prevBtn = document.querySelector('.slider .prev');
        const nextBtn = document.querySelector('.slider .next');
        const textContainer = document.querySelector('.Textmas');

        const Textmas = [
            { title: "Himnario de la iglesia", body: " Conozca las 400 alabanzas que han sido seleccionadas donde puede encontrar la pista de audio" },
            { title: "Himnario Inspirado", body: "Conozca las alabanzas hechas para convivios, convenciones, todo hecho con inspiración" },
            { title: "Escuelas sabáticas", body: "Apartado con las escuelas sabáticas de los niños, jóvenes, y hermanas de distintos años para que conozca más" },
            { title: "Doctrina de la iglesia", body: "Conozca la doctrina de la iglesia de Dios" },
            { title: "Documentos de la ID", body: "Temas, estudios y más" },
            { title: "Ubicaciones", body: "Direcciones de las casas de oración" },
            { title: "Eventos", body: " Conozca los próximos eventos de la Iglesia" },
            { title: "Multimedia", body: "Fotos y más" }
        ];

        function showSlide(index) {
            if (index >= totalSlides) currentSlideIndex = 0;
            else if (index < 0) currentSlideIndex = totalSlides - 1;
            else currentSlideIndex = index;

            slidesContainer.style.transform = `translateX(-${currentSlideIndex * 100}%)`;

            dots.forEach(dot => dot.classList.remove("active"));
            dots[currentSlideIndex].classList.add("active");

            if (textContainer) {
                textContainer.innerHTML = `
                    <h2 class="text-xl font-bold mb-4">${Textmas[currentSlideIndex]?.title || ""}</h2>
                    <p class="text-gray-700">${Textmas[currentSlideIndex]?.body || ""}</p>
                `;
            }
        }

        if (nextBtn) nextBtn.addEventListener("click", () => showSlide(currentSlideIndex + 1));
        if (prevBtn) prevBtn.addEventListener("click", () => showSlide(currentSlideIndex - 1));

        dots.forEach((dot, i) => {
            dot.addEventListener("click", () => showSlide(i));
        });

        // Auto-play para el carrusel "Más de nosotros"
        setInterval(() => showSlide(currentSlideIndex + 1), 6000);

        showSlide(currentSlideIndex);

        // Animación para que las secciones aparezcan al hacer scroll
        const sections = document.querySelectorAll('section');
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.2 });

        sections.forEach(section => observer.observe(section));
    })();

});


// Animaci�n para que las secciones aparezcan al hacer scroll
const sections = document.querySelectorAll('section');
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, { threshold: 0.2 });

sections.forEach(section => observer.observe(section));


// Animaci�n para que el bot�n tambi�n aparezca al hacer scroll
const btn = document.querySelector('.btn-container');
const btnObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible-btn');
        }
    });
}, { threshold: 0.2 });

btnObserver.observe(btn);
