<script>
export default {
    props: {
        value: {
            type: Boolean,
            default: false
        },
        id: String,
        name: {
            type: String,
            required: true
        }
    }
}
</script>

<template>
    <input type="checkbox" :name="name" v-model="value" :id="id"
           class="form-check-input">
</template>
