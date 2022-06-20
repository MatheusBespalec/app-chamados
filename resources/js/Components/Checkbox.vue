<script>
export default {
    props: {
        modelValue: {
            type: Boolean,
            default: false
        },
        id: String,
        name: {
            type: String,
            required: true
        }
    },
    emits: ['update:modelValue'],
}
</script>

<template>
    <input type="checkbox" :name="name" :id="id"
           class="form-check-input" @input="$emit('update:modelValue', $event.target.checked)">
</template>
