import axios from 'axios';
import Echo from 'laravel-echo';
import io from 'socket.io-client';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.io = io;

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});

window.Echo.connector.socket.on('connect', () => {
    console.log('Successfully connected to Socket.IO server');
});

window.Echo.channel('laravel_database_rows')
    .listen('.row.created', (event) => {
        console.log('Новая строка:', event);
    });

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

/*import './echo';*/
