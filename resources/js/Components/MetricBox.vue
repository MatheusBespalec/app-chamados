<script setup>
    const props = defineProps({
        bg: String,
        title: String,
        value: [String, Number]
    })
</script>

<template>
    <div class="dash-box">
        <div class="icon" :style="'background-color:' + bg">
            <slot></slot>
        </div>
        <div class="info">
            <h3>{{ title }}</h3>
            <span>{{ value }}</span>
        </div>
    </div><!-- dash-box -->
</template>
