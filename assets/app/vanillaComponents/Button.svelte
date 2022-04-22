<button
        class="min-w-auto px-6 p-2 text-white rounded-xl font-semibold text-{size}"

        class:bg-blue-400={base||(!positive&&!negative&&!brand&&!link)}
        class:hover:bg-blue-600={base||(!positive&&!negative&&!brand&&!link)}
        class:bg-green-400={positive}
        class:hover:bg-green-600={positive}
        class:bg-red-400={negative}
        class:hover:bg-red-600={negative}

        class:bg-gray-800={brand}
        class:hover:bg-gray-600={brand}

        class:bg-white={link}
        class:text-blue-500={link}
        class:hover:text-blue-600={link}
        class:underline={link}
        class:hover:bg-white={link}
        disabled="{disabled}"

        on:click
        on:focus
        on:blur
        on:mouseover
        on:mouseleave
        on:mousedown
        on:mouseup

>
    <slot/>

</button>


<script>
    import Icon from "./Icon.svelte";

    export let disabled = false;

    /** layout */
    export let inline = false;

    /** colors */
    export let base = false;
    export let positive = false;
    export let negative = false;
    export let brand = false;
    export let link = false;


    /** sizes */
    export let size="md";
    export let xs=false;
    export let sm=false;
    export let md=false;
    export let lg=false;
    export let xl=false;

    /** icons*/
    export let iconPrefix = false;
    export let iconSuffix = false;

</script>
