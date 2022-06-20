<script setup>

const props = defineProps({
    // Array with name of headers of table
    headers: Array,
    // Array with rows values of table
    rows: Array,
})

</script>

<template>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-dark">
<!--                <tr>-->
<!--                    <th scope="col">#</th>-->
<!--                    <th scope="col">First</th>-->
<!--                    <th scope="col">Last</th>-->
<!--                    <th scope="col">Handle</th>-->
<!--                </tr>-->
                <tr>
                    <th v-for="(header, index) in headers" :key="index" scope="col">{{ header }}</th>
                </tr>
            </thead><!-- table-dark -->
            <tbody>
                <tr v-for="(row, index) in rows" :key="index">
                    <td v-for="(col, index) in row" :key="index">{{ col }}</td>
                </tr>

<!--                <tr>-->
<!--                    <th scope="row">1</th>-->
<!--                    <td>Mark</td>-->
<!--                    <td>Otto</td>-->
<!--                    <td>@mdo</td>-->
<!--                </tr>-->

                <slot></slot>
            </tbody>
        </table><!-- table table-hover table-bordered -->
    </div><!-- table-responsive -->
</template>
