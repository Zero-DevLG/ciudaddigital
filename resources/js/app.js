import './bootstrap';

import Alpine from 'alpinejs';

import $ from 'jquery';

import Swal from 'sweetalert2';

import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'bootstrap/dist/css/bootstrap.min.css';


window.Swal = Swal;


window.$ = $;
window.jQuery = $;

window.Alpine = Alpine;

Alpine.start();
