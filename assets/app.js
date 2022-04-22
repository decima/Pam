import "./app.css";
import 'vanilla-framework/_index.scss';

import App from './app/App.svelte';



const app = new App({
    target: document.querySelector("#app")
});

window.app = app;

export default app;