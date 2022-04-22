import {writable} from "svelte/store";

function userPreferencesInitializer() {
    const up = localStorage.getItem('userPreferences');
    let unserialized = {
        itemsPerPage: 24,
        lastFilter: "",
    };
    if(up!==null){
        unserialized = JSON.parse(up);
    }
    const {subscribe, set, update} = writable(unserialized);

    subscribe(function (value) {
        localStorage.setItem("userPreferences", JSON.stringify(value))

    });
    return {
        subscribe,
        set,
        setProperty(property, value) {
            update(preferences => {
                preferences[property] = value;
                return preferences;
            });
        }

    }
}

export const userPreferences = userPreferencesInitializer();


