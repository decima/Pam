import {writable} from "svelte/store";

function tagStore() {
//    const {subscribe, set, update} = writable({"loading":true});

    return {
        async autocomplete(keyword) {
            const response = await fetch(`/api/tags?name=${keyword}`)
            const r = await response.json()
            let result=[];
            for(let i=0; i<r["hydra:member"].length; i++) {
                result.push(r["hydra:member"][i].name)
            }
            return result;

        },
    }


}

export const tags = tagStore();
