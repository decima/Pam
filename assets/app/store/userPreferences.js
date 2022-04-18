import {writable} from "svelte/store";

function userPreferencesInitializer() {
    const {subscribe, set, update} = writable(JSON.parse(
        localStorage.getItem('userPreferences') ||
        {
            itemsPerPage: 24,
        }
    ));

    subscribe(function (value) {
        localStorage.setItem("userPreferences", JSON.stringify(value))
    });
    return {
        subscribe,
        set,

    }
}

export const userPreferences = userPreferencesInitializer();
