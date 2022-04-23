function tagStore() {
//    const {subscribe, set, update} = writable({"loading":true});

    return {
        async autocomplete(keyword) {
            const response = await fetch(`/api/tags?name=${keyword}&order[assets]=DESC`)
            return await response.json();

        },
        async topTags() {
            const response = await fetch('/api/tags?order[assets]=desc&itemsPerPage=20')
            return await response.json()
        },
        async getTag(id) {
            const response = await fetch('/api/tags/' + id)
            return await response.json()
        },
        async updateTag(id, color) {
            return await fetch('/api/tags/' + id, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/merge-patch+json'
                },
                body: JSON.stringify({
                    color: color
                })
            })
        },
        async addTag(name, color) {
            const response =  await fetch('/api/tags', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    name,
                    color
                })
            })
            return await response.json()
        },

    }
}

export const tags = tagStore();
