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
        }
    }
}
</script>

<template>
    <button :type="type" class="btn btn-{{ color }}">
        <slot />
    </button>
</template>
