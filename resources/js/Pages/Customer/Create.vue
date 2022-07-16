<script setup>

import FormGroup from '@/Components/Form/FormGroup';
import SimpleCard from '@/Components/SimpleCard';
import Breadcrumb from '@/Components/Breadcrumb';
import MainTitle from '@/Components/MainTitle';
import Paginate from '@/Components/Paginate';
import Input from '@/Components/Form/Input';
import Label from '@/Components/Form/Label';
import Content from '@/Components/Content';
import Button from '@/Components/Button';
import Table from '@/Components/Table';
import EyeIcon from '@/Icons/EyeIcon';
import { onMounted } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';

onMounted(() => {
    $('input#name').click(() => form.clearErrors('name'));
});

const form = useForm({
    name: null
})


const breadcrumb = [
    {
        text: 'Clientes',
        route: 'customers.index'
    },
    {
        text: 'Novo projeto'
    }
];

const sendForm = () => form.post(route('customers.store'));

</script>

<template>
    <Breadcrumb :items="breadcrumb" />

    <Content>
        <MainTitle title="Novo Cliente" />

        <div class="row">
            <div class="col-12 mb-3">
                <FormGroup>
                    <Label value="Nome" id="name" />
                    <Input v-model="form.name" id="name" :class="form.errors.name ? 'is-invalid' : ''" />
                    <div class="invalid-feedback">{{ form.errors.name }}</div>
                </FormGroup>
                <Button type="button" color="primary" @click="sendForm">Salvar</Button>
            </div><!-- col-12 -->
        </div><!-- row -->
    </Content>
</template>
