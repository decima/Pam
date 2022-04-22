<div class="flex my-4">
    <div class="border-l border-y px-2 py-2">
        <label for="perPage">
        <Icon icon="list"/>
        </label>

        <select id="perPage" bind:value={itemsPerPage} on:change={updatePreferences}>
        <option value="24">24</option>
        <option value="48">48</option>
        <option value="120">120</option>
    </select>
    </div>
    <div class="border-l border-y px-2  py-2">
        <label for="selectAll"><Icon icon="object-group"/></label>    <input type="checkbox" id="selectAll" bind:checked={selectAll} on:change={updateSelectAll} />
    </div>
    <div class="border-x border-y px-2 py-2">
        <Icon icon="tag"/>
        <AutocompleteInput placeholder="tag selected" on:select/>
    </div>

</div>
<script>
    import {createEventDispatcher} from "svelte";
    import {userPreferences} from "../store/userPreferences";
    import AutocompleteInput from "../vanillaComponents/Autocomplete/AutocompleteInput.svelte";
    import Icon from "../vanillaComponents/Icon.svelte";

    const dispatch = createEventDispatcher();

    export let itemsPerPage;
    let selectAll=false;

    function updatePreferences() {
        userPreferences.set({itemsPerPage});
        dispatch("change")
    }

    function updateSelectAll(event){

        if(!selectAll){
            dispatch("deselectAll");
        }else{
            dispatch("selectAll")
        }
    }
</script>