<script setup>

import FormGroup from '@/Components/Form/FormGroup';
import Select from '@/Components/Form/Select';
import Input from '@/Components/Form/Input';
import Label from '@/Components/Form/Label';
import NameValueTable from '@/Components/NameValueTable';
import ChatMessage from '@/Components/ChatMessage';
import Breadcrumb from '@/Components/Breadcrumb';
import SimpleCard from '@/Components/SimpleCard';
import MainTitle from '@/Components/MainTitle';
import Paginate from '@/Components/Paginate';
import Content from '@/Components/Content';
import Button from '@/Components/Button';
import Table from '@/Components/Table';
import Modal from '@/Components/Modal';
import SendIcon from '@/Icons/SendIcon';
import EyeIcon from '@/Icons/EyeIcon';
import { usePage, useForm, Link } from '@inertiajs/inertia-vue3';
import { Modal as BoostrapModal } from 'bootstrap';
import { onMounted } from 'vue';

let addProjectModal;
let projects;

onMounted(() => {
    addProjectModal = new BoostrapModal(document.getElementById('add-project'));
});

const customer = usePage().props.value.customer;
const openProjectsModal = () => {
    addProjectModal.show()
};
const form = useForm({
    project_id: 0,
    customer_id: customer.id,
});
const message = useForm({
    file: undefined,
    text: undefined
});

const addProject = () => {
    form.post(route('customers.attachProject', { customer: customer.id }), {
        onSuccess() {
            form.reset('project_id');
            addProjectModal.hide()
        }
    });
};

const createNewMessage = () => {
    message.post(route('customers.messages.store', { customer: customer.id }), {
        onSuccess() {
            message.reset()
            window.scrollTo(0, document.body.scrollHeight);
        }
    })
};

const breadcrumb = [
    {
        text: 'Clientes',
        route: 'customers.index'
    },
    {
        text: customer.name
    }
];

</script>

<template>
    <Breadcrumb :items="breadcrumb" />

    <Content>
        <div class="row">
            <div class="col-12">
                <MainTitle :title="customer.name" />
            </div><!-- col-12 -->

            <div class="col-12">
                <h2>Projetos</h2>
                <div class="col-12 mb-3">
                    <Button color="success" @click="openProjectsModal">Adicionar Projeto</Button>
                </div><!-- col-12 mb-3 -->


                <Table :headers="['ID', 'Nome', 'UUID', '']">
                    <tr v-for="(project, index) in $page.props.customer.projects" :key="index">
                        <td>{{ project.id }}</td>
                        <td>
                            <Link :href="route('projects.show', { project: project.id })">
                                {{ project.name }}
                            </Link>
                        </td>
                        <td>{{ project.pivot.uuid }}</td>
                        <td>
                            <Link :href="typeof project.private_route == 'string'
                                ? route(`${project.private_route}.show`, { customer: customer.id })
                                : route('projects.show', project.id)"
                            >
                                    <Button type="button" color="primary" classes="btn-sm">
                                    <EyeIcon size="15" />
                                </Button>
                            </Link>
                        </td>
                    </tr>
                </Table>
            </div><!-- col-12 -->
        </div><!-- row -->

        <div class="col-12 mt-5">
            <h2>Anotações</h2>

            <ChatMessage
                v-for="(message, index) in $page.props.customer.messages"
                :key="index"
                :text="message.text"
                :file="message.file_path"
                :color="message.user_id == $page.props.auth.user.id ? 'light' : 'secondary'"
                :author="{ name: message.from }"
                :classes="message.user_id == $page.props.auth.user.id
                    ? 'bg-primary text-white float-end'
                    : 'bg-info text-dark float-start'"
            />

            <div class="mb-3">
                <input class="form-control" type="file" @input="message.file = $event.target.files[0]">
            </div>

            <div class="mb-3 input-group">
                <span class="input-group-text">Mensagem</span>
                <textarea class="form-control" v-model="message.text" placeholder="Adicione uma mensagem ..."></textarea>
            </div>

            <div class="mb-3">
                <button class="btn btn-outline-primary w-100" type="button" @click="createNewMessage">
                    Salvar <SendIcon />
                </button>
            </div>
        </div><!-- col-12 -->
    </Content>

    <Modal title="Adicionar Projeto" id="add-project">
        <template v-slot:body>
            <FormGroup>
                <Select :resources="$page.props.projects" placeholder="Selecione um projeto" v-model="form.project_id" />
            </FormGroup>
        </template>
        <template v-slot:footer>
            <Button color="primary" @click="addProject">Adicionar</Button>
        </template>
    </Modal>
</template>
