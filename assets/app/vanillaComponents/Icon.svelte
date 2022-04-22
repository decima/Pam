<i class="fa-{icon} fa-{size}x"
   class:fa-regular={!solid&&!light&&!thin&&!brand}
   class:fa-solid={solid}
   class:fa-light={light}
   class:fa-thin={thin}
   class:fa-brand={brand}
   class:fa-duotone={duotone}
   class:fa-inverse={inverse}

   class:fa-2xs={size2XS}
   class:fa-xs={sizeXS}
   class:fa-sm={sizeSM}
   class:fa-lg={sizeLG}
   class:fa-xl={sizeXL}
   class:fa-2xl={size2XL}

   on:click
   on:focus
   on:blur
   on:mouseover
   on:mousedown
   on:mouseup
   on:mouseout


></i>

<script>
    export let icon = "unicorn"
    export let solid = false
    export let light = false
    export let thin = false
    export let brand = false
    export let duotone = false
    export let inverse = false
    export let size = 1


    export let size2XS = false
    export let sizeXS = false
    export let sizeSM = false
    export let sizeLG = false
    export let sizeXL = false
    export let size2XL = false
</script>