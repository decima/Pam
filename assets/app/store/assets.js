import {writable} from "svelte/store";
import {queryParameters} from "./queryParametersUtils";
import {userPreferences} from "./userPreferences";


async function loadData(path) {

    const response = await fetch(path)
    const jsonResponse = await response.json()
    return jsonResponse
}


async function loadByURL(url) {
    let data = await loadData(url)
    data.loading = false
    return data
}

async function deleteByURL(path) {
    let response = await fetch(path, {
        method: 'DELETE',
    })
    return response.status
}


async function postByUrl(path, content) {
    let response = await fetch(path, {
        method: 'POST',
        body: content
    })
    return response.status
}

function createCurrentPage() {
    let loadedData = {};
    const {subscribe, set, update} = writable({loading: true});
    subscribe((data) => {
        loadedData = data;
    })


    return {
        subscribe,
        async load(params) {
            const str = queryParameters.stringify(params)
            set(await loadByURL(`/api/assets.jsonld?${str}`))

        },
        async nextPage() {
            const next = loadedData["hydra:view"]["hydra:next"]
            set(await loadByURL(next))
            console.log(next)
            return next
        },
        async firstPage() {
            const next = loadedData["hydra:view"]["hydra:first"]
            set(await loadByURL(next))
            console.log(next)
            return next
        },
        async lastPage() {
            const next = loadedData["hydra:view"]["hydra:last"]
            set(await loadByURL(next))
            console.log(next)
            return next
        },
        async previousPage() {
            const previous = loadedData["hydra:view"]["hydra:previous"]
            set(await loadByURL(previous))
            return previous
        }
    }
}

export const AssetPage = createCurrentPage();

function createAsset() {
    const {subscribe, set, update} = writable({loading: true});
    let loadedUserPreferencces = {};
    userPreferences.subscribe((data) => {
        loadedUserPreferencces = data;
    })
    return {
        subscribe,
        async load(id) {
            set(await loadByURL(`/api/assets/${id}`))
        },
        async detachTag(asset, tag) {
            return await deleteByURL(`/api/assets/${asset}/tag/${tag}`)
        },
        async addTag(asset, tag) {
            return await postByUrl(`/api/assets/${asset}/tag`, tag)
        },
        async getPaginations(asset,filters){
            return await loadByURL(`/api/assets/${asset}/siblings?${filters}`)
        },
    }
}

export const Asset = createAsset();