<script setup>

import NameValueTable from '@/Components/NameValueTable';
import FormGroup from '@/Components/Form/FormGroup';
import Input from '@/Components/Form/Input';
import Label from '@/Components/Form/Label';
import SimpleCard from '@/Components/SimpleCard';
import Breadcrumb from '@/Components/Breadcrumb';
import MainTitle from '@/Components/MainTitle';
import Paginate from '@/Components/Paginate';
import Content from '@/Components/Content';
import Button from '@/Components/Button';
import Table from '@/Components/Table';
import Modal from '@/Components/Modal';
import EyeIcon from '@/Icons/EyeIcon';
import { Modal as BoostrapModal } from 'bootstrap';
import { onMounted } from 'vue';
import { usePage, useForm, Link } from '@inertiajs/inertia-vue3';

const project = usePage().props.value.project;
const breadcrumb = [
    {
        text: 'Projetos',
        route: 'projects.index'
    },
    {
        text: project.name
    }
];
let newModuleModal
const openNewModuleModal = () => {
    newModuleModal.show()
}

onMounted(() => {
    newModuleModal = new BoostrapModal(document.getElementById('new-module'));
});

const module = useForm({
    name: '',
    description: '',
    project_id: project.id
})

const saveNewModule = () => {
    module.post(route('modules.store'), {
        onSuccess: () => {
            module.reset();
            newModuleModal.hide();
        },
    })
}

</script>

<template>
    <Breadcrumb :items="breadcrumb" />

    <Content>
        <div class="row">

            <div class="col-12">
                <MainTitle :title="project.name" />
            </div><!-- col-12 -->

            <div class="col-12">
                <h2>Clientes Associados</h2>
                <Table :headers="['ID', 'Nome', 'UUID', '']">
                    <tr v-for="(customer, index) in $page.props.customers.data" :key="index">
                        <td>{{ customer.id }}</td>
                        <td>
                            <Link :href="route('customers.show', { customer: customer.id })">
                                {{ customer.name }}
                            </Link>
                        </td>
                        <td>{{ customer.pivot.uuid }}</td>
                        <td>
                            <Link :href="route('customers.show', { customer: customer.id })">
                                <Button type="button" color="primary" classes="btn-sm">
                                    <EyeIcon size="15" />
                                </Button>
                            </Link>
                        </td>
                    </tr>
                </Table>
                <Paginate :links="$page.props.customers.links" />
            </div><!-- col-12 -->

            <div class="col-12">
                <h2>Modulos</h2>
                <Button type="button" color="primary" @click="openNewModuleModal">Novo Módulo</Button>
                <div class="d-flex align-content-start flex-wrap">
                    <div v-for="(module, index) in $page.props.project.modules" :key="index" class="m-3">
                        <SimpleCard
                            :title="module.name"
                            :description="module.description"
                        />
                    </div>
                </div><!-- d-flex justify-content-around flex-wrap -->
            </div>
        </div><!-- row -->
    </Content>

    <Modal title="Novo Módulo" id="new-module">
        <template v-slot:body>
            <FormGroup>
                <Label value="Nome" id="name" />
                <Input v-model="module.name" id="name" :class="module.errors.name ? 'is-invalid' : ''" />
                <div class="invalid-feedback">{{ module.errors.name }}</div>
            </FormGroup>

            <FormGroup>
                <Label value="Descrição" id="description" />
                <Input v-model="module.description" id="description" :class="module.errors.description ? 'is-invalid' : ''" />
                <div class="invalid-feedback">{{ module.errors.name }}</div>
            </FormGroup>
        </template>
        <template v-slot:footer>
            <Button color="primary" @click="saveNewModule">Salvar</Button>
        </template>
    </Modal>
</template>
