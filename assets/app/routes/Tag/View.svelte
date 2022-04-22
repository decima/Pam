<script>
    import AssetList from "../../components/AssetList.svelte";


    export let id = 0;
    let filter = {"tags.id[1]": id};

</script>
<AssetList filters={filter}></AssetList>
