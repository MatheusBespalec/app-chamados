<script setup>

import Breadcrumb from '../../Components/Breadcrumb'
import { usePage } from '@inertiajs/inertia-vue3';

const error = usePage().props.value.error;

const breadcrumb = [
    {
        text: 'Erros',
        route: 'errors.index'
    },
    {
        text: 'Erro ' + error.id
    }
]

</script>

<template>
    <Breadcrumb :items="breadcrumb" />
</template>
