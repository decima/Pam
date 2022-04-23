<input bind:value placeholder={placeholder} bind:this={inputField}
       class="outline-0"
       on:focus={onFocus} on:keydown={keyboardActions} on:blur on:input={updateSuggestion}/>
{#if value.trim() && currentItem > -1 && suggestions.length > 0}
    <ul class="shadow border absolute w-96 bg-white dark:bg-black">
        {#each suggestions as suggestion, i}
            <li class="border-t hover:bg-blue-400 " on:click={()=>{chooseValue(suggestion)}} class:selected={currentItem===i}>
                {suggestion.value}
            </li>
        {/each}
    </ul>
{/if}



<script>
    import {createEventDispatcher, onMount} from "svelte";


    const dispatcher = createEventDispatcher();

    let currentItem = 0;
    let suggestions = [];
    let inputField = null;
    let currentKey=-1;

    export let value = '';
    export let placeholder = 'type something...';

    export function focus() {
        inputField.focus();
    }

    export function blur() {
        inputField.blur();
    }

    export function autocompletionClosed() {
        return currentItem === -1 || suggestions.length === 0;
    }

    export let autocompletion = (value) => [value];

    function onFocus() {

        dispatcher('focus')
    }

    function onBlur() {

        dispatcher('blur')
    }

    async function updateSuggestion(event) {
        if (value.trim().length === 0) {
            suggestions = [];
            return;
        }
        suggestions=[];
        const results = await autocompletion(value.trim());
        let list=[];
        for(let id in results) {

            list.push({"key":id,"value":results[id]});
        }
        suggestions=list;
    }

    function chooseValue(selected) {

        sendValue(selected)
        inputField.focus()

    }

    function sendValue(v) {
        dispatcher('select', v)
        value = ''
        currentItem = -1;
    }

    function keyboardActions(event) {
        switch (event.key) {
            case "Enter":
                if (suggestions.length === 0) {
                    currentItem = -1;
                }
                if (currentItem === -1) {
                    sendValue({key: currentKey, value:value.trim()})
                } else {
                    sendValue(suggestions[currentItem])
                }
                event.preventDefault()

                break;
            case "ArrowRight":
                if (currentItem > -1 && suggestions.length > 0) {
                    value = suggestions[currentItem].value
                    currentKey = suggestions[currentItem].key
                    currentItem = -1;
                    event.preventDefault()
                }
                dispatcher('right',{key: currentKey, value:value.trim()})
                break;
            case "ArrowDown":
                if (currentItem < suggestions.length - 1) {
                    currentItem++;
                }
                event.preventDefault()


                break;
            case "ArrowUp":
                if (currentItem > -1) {
                    currentItem--;
                }
                event.preventDefault()
                break;
            case "Escape":
                setTimeout(() => {
                    currentItem = -1;
                    currentKey=-1;
                }, 50)
                event.preventDefault()
                inputField.focus()
                break;
            default:
                currentItem = 0;
        }

    }
</script>


<style>
    .selected {
        @apply bg-blue-400;
    }
</style>