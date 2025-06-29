import './bootstrap';
import '../css/app.css';

import Alpine from 'alpinejs';
import productModal from './product-modal.js';

window.Alpine = Alpine;
window.productModal = productModal;

Alpine.start();
