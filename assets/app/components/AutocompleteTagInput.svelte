<script>
    import AutocompleteInput from "../vanillaComponents/Autocomplete/AutocompleteInput.svelte";
    import {tags} from "../store/tags";

    export let tagInput=null;
    export let newTag="";
    export let enableFullKeyboardUsage = false;
    export let placeholder="Add tag...";


    async function suggestTag(inputUsed) {
        const r = await tags.autocomplete(inputUsed);
        let result = {};
        for (let i = 0; i < r["hydra:member"].length; i++) {
            result[r["hydra:member"][i].id] = r["hydra:member"][i].name
        }
        return result;
    }

</script>

<AutocompleteInput bind:placeholder on:right bind:this={tagInput} autocompletion={suggestTag} on:select bind:value={newTag} on:blur={()=>{enableFullKeyboardUsage=false}} on:focus={()=>{enableFullKeyboardUsage=true}}/>
