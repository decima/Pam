<script>
    import {onMount} from "svelte";
    import {queryParameters} from "../../store/queryParametersUtils";
    import {tags} from "../../store/tags";
    import {navigate} from "svelte-navigator";


    let name="";
    let color="#000000";

    onMount(()=>{
       const parameters= queryParameters.get()
        name=parameters.name;
    })
    async function sendForm(event) {
        event.preventDefault()

        const addedTag = await tags.addTag(name, color);
        if (addedTag) {
            navigate("/tags/"+addedTag.id)
        }

    }

</script>

<form on:submit={sendForm}>
    <div class="mb-6">
        <label for="tag" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tag</label>
        <input type="tag" id="tag" bind:value={name}  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
    </div>
    <div class="mb-6">
        <label for="color" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Color</label>

        <div class="flex items-center h-5">

            <input type="color" id="color" placeholder="Color" bind:value={color}
                   class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block " required/>

        </div>
    </div>
    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
</form>
