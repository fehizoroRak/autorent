// Import de VUE JS
import { createApp } from 'vue';
import App from './js/components/App.vue';
createApp(App).mount('#app');

/*
 * Welcome to your app's main JavaScript file!
 *
 * This file sera inclus sur la page via la fonction importmap() Twig,
 * qui devrait déjà être dans votre base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
