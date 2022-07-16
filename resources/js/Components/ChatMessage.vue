<script setup>

import UserIcon from '@/Icons/UserIcon';

const props = defineProps({
    text: String,
    author: Object,
    classes: String,
    color: {
        type: String,
        default: 'secondary'
    }
})

</script>

<template>
    <div class="card border border-2 rounded-3 mb-3 p-3 w-75" :class="classes">
        <div class="d-flex justify-start">
            <div class="avatar-img me-4">
                <div :class="`border border-${color} rounded-circle text-${color} d-flex justify-content-center align-items-center`" style="width: 50px; height: 50px">
                    <UserIcon size="30" />
                </div><!-- avatar-img me-2 -->
            </div><!-- avatar-img -->
            <div class="note">
                <h3 class="h5">{{ author.name }}</h3>
                <p>
                    {{ text }}
                </p>
            </div><!-- note -->
        </div><!-- d-flex justify-start -->
    </div><!-- card -->
</template>
