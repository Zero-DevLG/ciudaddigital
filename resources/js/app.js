import './bootstrap';
import './register.js';


import Alpine from 'alpinejs';

import $ from 'jquery';
window.$ = window.jQuery = $;

import Swal from 'sweetalert2';

import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'bootstrap/dist/css/bootstrap.min.css';

import './register.js';

window.Swal = Swal;


window.$ = $;
window.jQuery = $;

window.Alpine = Alpine;

Alpine.start();


window.inicializarMapa = function() {
    console.log('Mapa inicializado!');
    // Aquí pones la lógica para crear o refrescar tu mapa, e.g. Leaflet, Google Maps, etc.
}
