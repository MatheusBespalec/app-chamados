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

    <section class="content">
        <div class="row">
            <div class="col-12">
                <h1> Erro: {{ error.message }}</h1>
            </div>
            <div class="col-12">
                <h2>Geral</h2>
                <div class="row">

                </div>
            </div>
        </div>

    </section>
</template>
