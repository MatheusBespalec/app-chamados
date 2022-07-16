<script setup>

const props = defineProps({
    headers: Array,
    classes: String
})

</script>

<template>
    <div class="table-responsive">
        <table class="table table-hover table-bordered" :class="classes">
            <thead class="table-dark">
                <tr>
                    <th v-for="(header, index) in headers" :key="index" scope="col">{{ header }}</th>
                </tr>
            </thead><!-- table-dark -->
            <tbody>
                <slot></slot>
            </tbody>
        </table><!-- table table-hover table-bordered -->
    </div><!-- table-responsive -->
</template>
