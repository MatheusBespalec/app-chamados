<script setup>
    import Table from '../../Components/Table';
</script>

<script>
</script>
<template>
    <div class="row">
        <div class="col-md-12">
            <Table :rows="$page.props.errors" :headers="$page.props.headers" />
        </div><!-- com-md-12 -->
    </div>
</template>
