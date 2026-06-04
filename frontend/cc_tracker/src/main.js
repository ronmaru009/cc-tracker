import { createApp } from "vue";
import "./style.css";
import App from "./App.vue";
import router from "./router";
import { createPinia } from "pinia";
import Particles from "@tsparticles/vue3";
import { loadSlim } from "@tsparticles/slim";
import VCalendar from "v-calendar";
import "v-calendar/dist/style.css";

const app = createApp(App);

app.use(Particles, {
  init: async (engine) => {
    await loadSlim(engine);
  },
});

app.use(createPinia());
app.use(router);
app.use(VCalendar);

app.mount("#app");
