<script setup>
defineProps({
    value: String,
    id: String
});
</script>

<template>
    <label class="form-label" :for="id">{{ value }}</label>
</template>
