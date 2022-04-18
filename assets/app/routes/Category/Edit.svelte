<script>
    import Tree from "../../vanillaComponents/Tree/Tree.svelte";
    import TreeGroup from "../../vanillaComponents/Tree/TreeGroup.svelte";
    import TreeLeaf from "../../vanillaComponents/Tree/TreeLeaf.svelte";
    import Row from "../../vanillaComponents/grid/Row.svelte";
</script>


<Row>

    <Tree>
        <TreeGroup title="Root Folder">

            <TreeGroup title="File">
                <TreeGroup title="Other">
                    <TreeLeaf>Some</TreeLeaf>
                    <TreeLeaf>Leaf</TreeLeaf>
                </TreeGroup>

                <TreeLeaf>subleaf</TreeLeaf>
                <TreeLeaf>subleaf2</TreeLeaf>
            </TreeGroup>

            <TreeLeaf>Root</TreeLeaf>
            <TreeLeaf>Leaf</TreeLeaf>
        </TreeGroup>
    </Tree>
</Row>