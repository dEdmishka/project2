import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import '../css/app.css';
import { createI18n } from 'vue-i18n'
import en from './lang/en.json'
import ua from './lang/ua.json'

const i18n = createI18n({
  legacy: false,
  globalInjection: true,
  locale: 'ua', // Default language
  fallbackLocale: 'en',
  messages: {
    en,
    ua
  }
})

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(i18n)
      .mount(el)
  },
})
