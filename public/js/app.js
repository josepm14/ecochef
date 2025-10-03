// JavaScript para la aplicación EcoChef

document.addEventListener('DOMContentLoaded', function() {
    console.log('EcoChef app.js cargado!');

    // Ejemplo de funcionalidad: desplazamiento suave a las secciones
    document.querySelectorAll('nav a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});