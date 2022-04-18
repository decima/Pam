<div class="border p-1 hover:border-gray-800 cursor-pointer" on:click={goToAsset}>
<img class="mx-auto" src="/api/assets/{item.id}/show"/>
</div>
<script>
    import {navigate} from "svelte-navigator";
    export let item;
    function goToAsset(){
        navigate(`/asset/${item.id}`);
    }
</script>