import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import './bootstrap';
import 'bootstrap';
import vuex from './vuex'
import Layout from './Layouts/Authenticated';

// Jquery
import $ from 'jquery';
window.$ = window.jQuery = $;

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    //resolve: (name) => require(`./Pages/${name}.vue`),
    resolve: (name) => {
        const page = require(`./Pages/${name}`).default
        if (page.__name != 'Login') {
            page.layout = Layout
        }
        return page
    },
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(vuex)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4d8b86' });
