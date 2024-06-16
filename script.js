const hamBurger = document.querySelector(".toggle-btn");

hamBurger.addEventListener("click", function () {
  document.querySelector("#sidebar").classList.toggle("expand");
});

document.addEventListener('DOMContentLoaded', function () {
    const modeToggle = document.getElementById('mode-toggle');
    const body = document.body;

    modeToggle.addEventListener('click', function () {
        body.classList.toggle('dark-mode');

        const icon = modeToggle.querySelector('i');
        const span = modeToggle.querySelector('span');
        
        if (body.classList.contains('dark-mode')) {
            icon.classList.replace('fa-moon', 'fa-sun');
            span.textContent = 'Mode Clair';
        } else {
            icon.classList.replace('fa-sun', 'fa-moon');
            span.textContent = 'Mode Sombre';
        }
    });
});