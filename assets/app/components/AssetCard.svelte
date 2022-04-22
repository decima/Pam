<div class="card border p-1 hover:border-gray-700 cursor-pointer">
    {#if item}

    <div class:hidden={!checked} class:border-blue-500="{checked}" class="flex content-center justify-center items-center checking bg-white absolute border m-1 w-4 h-4 hover:border-blue-600" on:click={()=>{checked=!checked}}>
        {#if checked}
            <div class="w-3 h-3  bg-blue-500"></div>
        {:else }
        {/if}

    </div>

    <img class="mx-auto" src="/api/assets/{item.id}/show" on:click={clickEvent}/>
    {/if}

</div>

<script>
    import Icon from "../vanillaComponents/Icon.svelte";
    import {createEventDispatcher} from "svelte";

    const dispatcher = createEventDispatcher();
    export let item;
    export let clickForCheck = false;
    export let checked = false;

    $: if(checked){
        check();
    }else{
        uncheck();

    }

    function clickEvent() {
        if (clickForCheck) {
            toggleCheck();
        } else {
            dispatcher("click")
        }
    }

    export function check() {
        checked = true;
        dispatcher("check")
    }

    export function uncheck() {
        checked = false;
        dispatcher("uncheck")
    }

    function toggleCheck() {
        if (checked) {
            uncheck();
        } else {
            check();
        }
    }

</script>
<style>
    .card:hover .checking {
        display: flex;
    }

</style>

