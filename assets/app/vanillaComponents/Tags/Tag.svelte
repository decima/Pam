<div class="select-none text-white  inline-block cursor-pointer mx-1 rounded-full text-sm font-medium leading-5 text-gray-900 bg-white border-2
hover:brightness-125"
     style="background-color: {color}" >
    <span class="pl-3 py-1" on:click on:hover style="color: {foregroundColor};"><slot/></span>
    <span class="px-2 hover:text-black"  style="color: {foregroundColor};"><slot name="after"/></span>
</div>
<script>
    export let color="#000000";
    export let foregroundColor="#FFFFFF";
    let showAction;
</script>