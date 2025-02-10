import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.Echo.channel('rows')
    .listen('.row.created', (event) => {
        console.log('Новая строка:', event);
    });
