<script>

export default {
    props: ['modelValue', 'resources', 'placeholder'],
    emits: ['update:modelValue']
}

</script>

<template>
    <select class="form-select" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)">
        <option value="0">{{ placeholder }}</option>
        <option v-for="(resource, index) in resources" :key="index" :value="resource.id">{{ resource.name }}</option>
    </select>
</template>
