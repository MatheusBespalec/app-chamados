<script>
export default {
    props: ['modelValue', 'id', 'placeholder'],
    emits: ['update:modelValue']
}
</script>

<template>
    <input class="form-control" :value="modelValue" :id="id" @input="$emit('update:modelValue', $event.target.value)" :placeholder="placeholder">
</template>
