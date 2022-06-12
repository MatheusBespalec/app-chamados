<script setup>
defineProps(['value']);
</script>

<template>
    <label class="form-label" for>
        <span v-if="value">{{ value }}</span>
    </label>
</template>
