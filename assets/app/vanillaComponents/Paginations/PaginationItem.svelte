<a class="md:flex"
   class:no-global-style={styleDisabled||disabled}
   class:border-transparent={!active}
   class:border-red-500={active}
   class:dark:border-green-500 ={active}
   class:text-slate-300={disabled}
   class:dark:text-slate-600={disabled}
   class:cursor-not-allowed={disabled}
   on:click={()=>{!disabled?dispatch("click"):""}}>
    <slot/>
</a>

<script>
    import {createEventDispatcher} from "svelte";

    export let active = false;
    export let disabled = false;
    export let styleDisabled = false;
    const dispatch = createEventDispatcher();
</script>

<style>
    a {
        @apply w-8 justify-center items-center leading-5 transition duration-150 ease-in;
        @apply border-t-2;
    }
</style>