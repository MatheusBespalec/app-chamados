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
    $('input').click(() => form.clearErrors());
});

const form = useForm({
    name: undefined,
    email: undefined,
    password: undefined,
    password_confirmation: undefined
})


const breadcrumb = [
    {
        text: 'Usuarios',
        route: 'users.index'
    },
    {
        text: 'Novo Usuario'
    }
];

const sendForm = () => form.post(route('users.store'));

</script>

<template>
    <Breadcrumb :items="breadcrumb" />

    <Content>
        <MainTitle title="Novo Usuario" />

        <div class="row">
            <div class="col-12 mb-3">
                <FormGroup>
                    <Label value="Nome" id="name" />
                    <Input v-model="form.name" id="name" :class="form.errors.name ? 'is-invalid' : ''" />
                    <div class="invalid-feedback">{{ form.errors.name }}</div>
                </FormGroup>

                <FormGroup>
                    <Label value="Email" id="email" />
                    <Input v-model="form.email" id="email" :class="form.errors.email ? 'is-invalid' : ''" />
                    <div class="invalid-feedback">{{ form.errors.email }}</div>
                </FormGroup>

                <FormGroup>
                    <Label value="Senha" id="password" />
                    <Input v-model="form.password" type="password" id="password" :class="form.errors.password ? 'is-invalid' : ''" />
                    <div class="invalid-feedback">{{ form.errors.password }}</div>
                </FormGroup>

                <FormGroup>
                    <Label value="Confirmação de Senha" id="password-confirmation" />
                    <Input v-model="form.password_confirmation" type="password" id="password-confirmation" :class="form.errors.password_confirmation ? 'is-invalid' : ''" />
                    <div class="invalid-feedback">{{ form.errors.password_confirmation }}</div>
                </FormGroup>

                <Button type="button" color="primary" @click="sendForm">Salvar</Button>
            </div><!-- col-12 -->
        </div><!-- row -->
    </Content>
</template>
