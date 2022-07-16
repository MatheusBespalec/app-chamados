<script setup>

const props = defineProps(['title', 'description'])

</script>

<template>
    <div class="card shadow bg-body rounded" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">{{ title }}</h5>
            <p class="card-text">{{ description }}</p>
        </div><!-- card-body -->
    </div><!-- card -->
</template>
