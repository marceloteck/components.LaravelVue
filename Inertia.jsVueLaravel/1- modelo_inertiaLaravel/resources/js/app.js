import './bootstrap';
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import ComponentsMap from './components/components.js'

import DefaultLayout from '@/PagesView/Layout/default_layout.vue';
import carregamento from '@/config/isLoading.js';
import globalVariables from '@/config/globalVariables.js';

createInertiaApp({
    resolve: name => resolvePageComponent(`./PagesView/${name}.vue`, import.meta.glob('./PagesView/**/*.vue')),
    progress: {color: '#FF0000'},
    setup({el, App, props, plugin}) {
        const app = createApp({
            render: () => h(DefaultLayout, { carregamento, globalVariables }, () => [h(App, props)]), 
        });
            // chamada dos componentes
            Object.entries(ComponentsMap).forEach(([name, component]) => {
                app.component(name, component);
            });

            app.use(plugin);
            app.mount(el);

    },
});
