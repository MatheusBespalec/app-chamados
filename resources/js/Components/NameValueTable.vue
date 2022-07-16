<script setup>

const props = defineProps({
    content: Array,
})

</script>

<template>
    <div class="table-responsive">
        <table class="table table-borderless">
            <tbody>
                <tr v-for="(item, index) in content" :key="index" class="align-top">
                    <th>{{ item.name }}</th>
                    <td>{{ item.value }}</td>
                </tr>
            </tbody>
        </table><!-- table table-borderless -->
    </div><!-- table-responsive -->
</template>
