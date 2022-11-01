<script setup>

const props = defineProps({
    content: Array,
    maxHeightComponent: {
        type: Number,
        default: 500
    }
});

</script>

<template>
    <div class="row border rounded-2">
        <div class="col-4 ps-0" :style="`max-height: ${maxHeightComponent}px; overflow: auto;`">
            <div
                class="list-group"
                id="list-tab"
                role="tablist"
            >
                <a  v-for="(item, index) in content"
                    class="list-group-item list-group-item-action"
                    data-bs-toggle="list"
                    role="tab"
                    :key="index"
                    :class="index == 0 ? 'active' : ''"
                    :id="`list-${index}-list`"
                    :href="`#list-${index}`"
                    :aria-controls="`list-${index}`"
                >
                    <p class="mb-1">{{ item.name }}</p>
                    <small>{{ item.description }}</small>
                </a><!-- list-group-item list-group-item-action -->
            </div><!-- list-group -->
        </div><!-- col-4 -->
        <div class="col-8">
            <div class="tab-content" id="nav-tabContent" :style="`max-height: ${maxHeightComponent}px; overflow: auto;`">
                <div v-for="(item, index) in content"
                    role="tabpanel"
                    class="p-3 tab-pane fade"
                    :class="index == 0 ? 'show active' : ''"
                    :key="index"
                    :id="`list-${index}`"
                    :aria-labelledby="`list-${index}-list`"
                >
                    <pre v-if="item.data != undefined" >{{ JSON.parse(item.data, null, 2) }}</pre>
                </div>
            </div><!-- tab-content -->
        </div><!-- col-8 -->
    </div><!-- row border rounded-2 -->
</template>
