import './bootstrap';
import '../css/app.css';
import 'tw-elements';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { InertiaProgress } from '@inertiajs/progress'
import { createPinia } from 'pinia'
import { ZiggyVue } from 'ziggy';

createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })

        app.use(plugin)
        app.use(createPinia())
        app.use(ZiggyVue)
        app.mount(el)

        return app
    },
});

InertiaProgress.init()