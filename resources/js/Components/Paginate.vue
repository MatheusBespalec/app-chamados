<script setup>

import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    links: Array,
})


const getPageUrl = (link) => {
    if (link == null) {
        return null
    }

    const url = new URL(location.href);
    const query = url.searchParams;

    const params = new URL(link);
    const searchParams = params.searchParams;

    query.set('page', searchParams.get('page') ?? null)

    return url.toString();
}

</script>

<template>
    <nav>
        <ul class="pagination justify-content-center">
            <template v-for="(link, index) in links" :key="index">
                <li
                    :class="link.active ? 'active' : link.url === null ? 'disabled' : ''"
                    class="page-item"
                >
                    <Link class="page-link" :href="getPageUrl(link.url)" :innerHTML="link.label" preserve-scroll preserve-state></Link>
                </li>
            </template>
        </ul><!-- pagination justify-content-center -->
    </nav>
</template>
