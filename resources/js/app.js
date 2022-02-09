import axios from 'axios';

window.axios = axios.create({
    baseURL: `${location.protocol}//${location.hostname}`,
    headers: {
        common: {
            Accept: 'application/json, */*',
            'X-Requested-With': 'XMLHttpRequest',
        },
    },
});

import {createApp} from 'vue';
import App from './app.vue';

createApp(App).mount('#app');
