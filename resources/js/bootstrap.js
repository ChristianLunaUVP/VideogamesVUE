import axios from 'axios';
import $ from 'jquery';
window.jQuery = window.$ = $;
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
