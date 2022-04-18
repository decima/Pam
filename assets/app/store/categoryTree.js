import {writable} from "svelte/store";
// get all categoriesURL
const categoriesURL = "/api/categories.jsonld?page=1&itemsPerPage=1000&exists%5Bparent%5D=false";

function categoryTree() {
    async function loadData() {

        const response = await fetch(categoriesURL)
        return await response.json()
    }


    const {subscribe, set, update} = writable({loading: true, "hydra:member": []});

    return {
        subscribe,
        async load() {

            let data = await loadData()
            data.loading = false
            set(data)
            return data
        },
    }

}

export const categories = categoryTree();