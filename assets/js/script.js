document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.dashicon-picker');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const targetInput = this.getAttribute('data-target');
            const iconPicker = document.createElement('div');
            iconPicker.classList.add('icon-picker-popup');
            
            // Add Dashicons
            const dashicons = ['dashicons-admin-post', 'dashicons-media-code', 'dashicons-format-image', 'dashicons-businessperson'];
            dashicons.forEach(icon => {
                const iconItem = document.createElement('div');
                iconItem.classList.add('dashicon-item');
                iconItem.classList.add(icon);
                iconItem.addEventListener('click', function() {
                    document.querySelector(`[name="${targetInput}"]`).value = icon;
                    iconPicker.remove();
                });
                iconPicker.appendChild(iconItem);
            });
            
            document.body.appendChild(iconPicker);
        });
    });
});
