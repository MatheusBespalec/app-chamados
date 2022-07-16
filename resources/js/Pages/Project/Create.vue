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
    name: null,
    modules: []
})

let newModule = useForm({
    name: '',
    description: ''
});

const breadcrumb = [
    {
        text: 'Projetos',
        route: 'projects.index'
    },
    {
        text: 'Novo projeto'
    }
];

const addModule = () => {
    form.modules.push({...newModule})
    newModule.reset()
}

const sendForm = () => form.post(route('projects.store'));

</script>



<template>
    <Breadcrumb :items="breadcrumb" />

    <Content>
        <MainTitle title="Novo Projeto" />

        <div class="row">
            <div class="col-12 mb-3">
                <FormGroup>
                    <Label value="Nome" id="name" />
                    <Input v-model="form.name" id="name" :class="form.errors.name ? 'is-invalid' : ''" />
                    <div class="invalid-feedback">{{ form.errors.name }}</div>
                </FormGroup>
                <Button type="button" color="primary" @click="sendForm">Salvar</Button>
            </div><!-- col-12 -->

            <div class="col-12 mb-3">
                <h3>Módulos do Projeto {{ form.name }}</h3>
                <FormGroup>
                    <Label value="Nome do Módulo" id="module-name" />
                    <Input v-model="newModule.name" id="module-name" />
                </FormGroup>
                <FormGroup>
                    <Label value="Descrição do Módulo" id="module-description" />
                    <Input v-model="newModule.description" id="module-description" />
                </FormGroup>
                <Button type="button" color="success" @click="addModule">Adicionar</Button>
            </div><!-- col-12 -->
            <div class="col-12">
                <div class="d-flex align-content-start flex-wrap">
                    <div v-for="(module, index) in form.modules" :key="index" class="m-3">
                        <SimpleCard
                            :title="module.name"
                            :description="module.description"
                        />
                    </div>
                </div><!-- d-flex justify-content-around flex-wrap -->
            </div><!-- col-md-12 -->
        </div><!-- row -->
    </Content>
</template>
