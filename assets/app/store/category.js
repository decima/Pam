import {writable} from "svelte/store";

// get all categoriesURL

function categoryLoader() {
    async function loadData(id) {

        const response = await fetch(`/api/categories/${id}`)
        return await response.json()
    }

    function getIds(childrenArray) {
        let ids = []
        for (let i = 0; i < childrenArray.length; i++) {
            ids.push(childrenArray[i].id)
            if (childrenArray[i].children.length > 0) {
                ids = ids.concat(getIds(childrenArray[i].children))
            }
        }
        return ids
    }

    const {subscribe, set, update} = writable({loading: true, "hydra:member": []});

    return {
        subscribe,
        async load(id) {

            let data = await loadData(id)
            data.loading = false
            set(data)
            return data
        },
        async getWithAllDescendants(id) {
            let data = await loadData(id)
            let ids = [];
            ids = getIds(data["children"])
            ids.push(data.id)
            return ids
        },
    }

}

export const category = categoryLoader();