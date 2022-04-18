<div class="select-none text-white hover:text-gray-600 inline-block cursor-pointer mx-1 rounded-full text-sm font-medium leading-5 text-gray-900 bg-white border-2 hover:bg-gray-100"
     style="border-color: {color}" >
    <span class="pl-3 py-1" on:click on:hover style="color: {color};"><slot/></span>
    <span class="px-2 hover:text-black"><slot name="after"/></span>
</div>
<script>
    export let color;
    let showAction;
</script>