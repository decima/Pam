<script>
    import {createEventDispatcher} from "svelte";
    import Icon from "../Icon.svelte";
    import PaginationItem from "./PaginationItem.svelte";
    import PaginationEmptyItem from "./PaginationEmptyItem.svelte";

    const dispatch = createEventDispatcher();

    export let currentPage = 1;
    export let maxNumberOfPages = 10;
    export let totalItems = 100;
    export let hydraView = {};
</script>


<div class="flex flex-col items-center my-6">
    <div class="flex text-gray-700">
        <div class="h-8 w-8 mr-1 flex justify-center items-center  cursor-pointer">

            <PaginationItem on:click={()=>{dispatch("clickPrevious")}}
                            disabled={currentPage<=1}>

                <Icon icon="chevron-left"/>
            </PaginationItem>

        </div>
        <div class="flex h-8 font-medium ">
            {#if currentPage >= 3}
                <PaginationItem on:click={()=>{dispatch("clickFirst")}}>
                    1
                </PaginationItem>

                {#if currentPage > 3}
                    <PaginationEmptyItem>...</PaginationEmptyItem>
                {/if}
            {/if}

            {#if currentPage > 1}


                <PaginationItem on:click={()=>{dispatch("clickPrevious")}}>
                    {parseInt(currentPage) - 1}
                </PaginationItem>
            {/if}
            <PaginationItem active>
                {currentPage}
            </PaginationItem>
            {#if currentPage < maxNumberOfPages}

                <PaginationItem on:click={()=>{dispatch("clickNext")}}>
                    {parseInt(currentPage) + 1}
                </PaginationItem>
            {/if}
            {#if currentPage <= maxNumberOfPages - 2}
                {#if currentPage < maxNumberOfPages - 2}
                    <PaginationEmptyItem>...</PaginationEmptyItem>
                {/if}
                <PaginationItem on:click={()=>{dispatch("clickLast")}}>
                    {maxNumberOfPages}
                </PaginationItem>
            {/if}
        </div>
        <div class="h-8 w-8 mr-1 flex justify-center items-center">
            <PaginationItem
                    on:click={()=>{dispatch("clickNext")}}
                    disabled={currentPage>=maxNumberOfPages}>
                <Icon icon="chevron-right"/>
            </PaginationItem>
        </div>
    </div>
</div>