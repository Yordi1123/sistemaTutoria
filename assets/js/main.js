// Confirmación de eliminación y validaciones
document.addEventListener('DOMContentLoaded', function() {
    
    // Manejar confirmaciones de eliminación
    const deleteLinks = document.querySelectorAll('.btn-danger');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!confirm('¿Estás seguro de que deseas eliminar este registro?')) {
                e.preventDefault();
            }
        });
    });

    // Validación básica de formularios
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const inputs = form.querySelectorAll('input[required]');
            let valid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    valid = false;
                    input.style.borderColor = 'red';
                } else {
                    input.style.borderColor = '#ddd';
                }
            });
            
            if (!valid) {
                e.preventDefault();
                alert('Por favor, completa todos los campos obligatorios');
            }
        });
    });

    // Resaltar enlace activo en el menú
    const currentUrl = window.location.href;
    const menuLinks = document.querySelectorAll('header nav ul a');
    menuLinks.forEach(link => {
        if (currentUrl.includes(link.getAttribute('href'))) {
            link.style.color = '#3498db';
            link.style.fontWeight = 'bold';
        }
    });
});

