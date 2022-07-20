<script setup>

import UserIcon from '@/Icons/UserIcon';
import DowloadIcon from '@/Icons/DowloadIcon';

const props = defineProps({
    text: String,
    author: Object,
    classes: String,
    file: String,
    color: {
        type: String,
        default: 'secondary'
    }
})

const isImage = (path) => {
    const imageExtensions = ['jpg', 'jpeg', 'png'];
    return imageExtensions.includes(path.split('.').pop());
};

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
                <p class="m-0">{{ text }}</p>
                <div v-if="file">
                    <img v-if="isImage(file)" style="max-width: 300px; width: 100%" :src="route('storage', { filePath: file })" class="mb-2">
                    <div></div>
                    <a :href="route('storage', { filePath: file })" download class="text-light">
                        <DowloadIcon classes="align-middle" size="16" /> <span class="align-middle">Download</span>
                    </a>
                </div>
            </div><!-- note -->
        </div><!-- d-flex justify-start -->
    </div><!-- card -->
</template>
