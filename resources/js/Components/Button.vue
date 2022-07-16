<script>
export default {
    props: {
        type: {
            type: String,
            default: 'submit',
        },
        color: {
            type: String,
            default: 'primary'
        },
        classes: {
            type: String,
            default: ''
        }
    }
}
</script>

<template>
    <button :type="type" class="btn" :class="`btn-${color} ${classes}`">
        <slot />
    </button>
</template>
