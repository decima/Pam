<script>
    import PaginationItem from "./PaginationItem.svelte";
    import Icon from "../Icon.svelte";
    import {createEventDispatcher} from "svelte";

    const dispatch = createEventDispatcher();

    export let hasNext = true;
    export let hasPrevious = true;
</script>
<div class="flex flex-col items-center my-6">
    <div class="flex text-gray-700">
        <div class="h-8 w-8 mr-1 flex justify-center items-center  cursor-pointer">

            <PaginationItem on:click={()=>{dispatch("clickPrevious")}}
                            disabled={!hasPrevious}>
                <Icon icon="chevron-left"/>

            </PaginationItem>

        </div>
        <div class="h-8 mr-1 flex justify-center items-center">
            <span>
                    <slot/>
                </span>
                </div>
        <div class="h-8 w-8 mr-1 flex justify-center items-center">
            <PaginationItem
                    on:click={()=>{dispatch("clickNext")}}
                    disabled={!hasNext}>
                <Icon icon="chevron-right"/>

            </PaginationItem>
        </div>
    </div>
</div>