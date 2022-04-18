<div class="
text-center
    w-{large}/12
    col-start-large-{offsetLarge}
    col-start-medium-{offsetMedium}
    col-start-small-{offsetSmall}
    md:w-{small}/6
    sm:w-{medium}/4
    {classes}
">
    <slot/>
</div>
<script>
    export let offsetLarge = 0;
    export let offsetMedium = 0;
    export let offsetSmall = 0;
    export let large = 12;
    export let small = 12;
    export let medium = 12;
    export let classes = "";
</script>