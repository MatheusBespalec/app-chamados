<script setup>

import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['items']);

</script>

<template>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li v-for="(item, index) in items" :key="index" class="breadcrumb-item" :class="items.length == (index + 1) ? 'active' : ''">
                <Link v-if="item.route" :href="route(item.route)">{{ item.text }}</Link>
                <a v-else :aria-current="items.length == (index + 1) ? 'page' : ''">{{ item.text }}</a>
            </li>
        </ol>
    </nav>
</template>
