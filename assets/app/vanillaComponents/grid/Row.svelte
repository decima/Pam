
<div class="grid grid-cols-1 sm:grid-cols-{small} md:grid-cols-{medium} lg:grid-cols-{large} xl:grid-cols-{xlarge} gap-4">
    <slot></slot>
</div>

<script>
    export let small = 2;
    export let medium = 4;
    export let large = 6;
    export let xlarge = 12;
</script>