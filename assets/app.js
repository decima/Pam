import "./app.css";
import 'vanilla-framework/_index.scss';

import "https://kit.fontawesome.com/7ee6e16f05.js"
import App from './app/App.svelte';



const app = new App({
    target: document.querySelector("#app")
});

window.app = app;

export default app;