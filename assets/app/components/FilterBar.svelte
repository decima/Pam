<div class="flex">
    <select id="perPage" bind:value={itemsPerPage} on:change={updatePreferences}>
        <option value="24">24</option>
        <option value="48">48</option>
        <option value="120">120</option>
    </select>
    <label for="perPage">items per page</label>

</div>
<script>
    import {createEventDispatcher, onMount} from "svelte";
    import {userPreferences} from "../store/userPreferences";

    const dispatch = createEventDispatcher();

    export let itemsPerPage;

    function updatePreferences() {
        userPreferences.set({itemsPerPage});
        dispatch("change")
    }
</script>