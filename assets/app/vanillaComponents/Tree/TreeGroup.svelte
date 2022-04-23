<script>
    import Icon from "../Icon.svelte";
    import Tree from "./Tree.svelte";
    import TreeLeaf from "./TreeLeaf.svelte";

    export let title = "";
    export let open = false;
</script>

<li>
    <div class="flex">
        <TreeLeaf on:click>
            {title}
        </TreeLeaf>
        <a on:click="{()=>{open=!open}}" class=" cursor-pointer pl-1 pr-2">
            {#if open}
                <Icon icon="chevron-down"/>
            {:else}
                <Icon icon="chevron-right"/>

            {/if}
        </a></div>
    <div class:hidden={!open}>
        <Tree>
            <slot></slot>
        </Tree>
    </div>
</li>