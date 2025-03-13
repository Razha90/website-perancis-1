import './bootstrap';
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect'; // Tambahkan ini

Alpine.plugin(intersect); // Registrasikan plugin Intersect

window.Alpine = Alpine;
Alpine.start();
