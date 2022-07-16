<script setup>

import NameValueTable from '@/Components/NameValueTable';
import Breadcrumb from '@/Components/Breadcrumb';
import MainTitle from '@/Components/MainTitle';
import Paginate from '@/Components/Paginate';
import Content from '@/Components/Content';
import Button from '@/Components/Button';
import ChatMessage from '@/Components/ChatMessage'
import SendIcon from '@/Icons/SendIcon'
import Table from '@/Components/Table';
import EyeIcon from '@/Icons/EyeIcon';
import { usePage, Link } from '@inertiajs/inertia-vue3';

const error = usePage().props.value.error;

const note = useForm({
    message: null
});

const createNewNote = () => {
    note.post(route('errors.notes.store', { error: error.id }))
    note.reset()
};

const breadcrumb = [
    {
        text: 'Erros',
        route: 'errors.index'
    },
    {
        text: `Erro ${error.id}`
    }
];

const details = [
    {
        name: 'Mensagem',
        value: error.message
    },
    {
        name: 'Arquivo',
        value: error.file
    },
    {
        name: 'Linha',
        value: error.line
    },
    {
        name: 'Código',
        value: error.code
    },
    {
        name: 'Path',
        value: error.url
    }
]

</script>

<template>
    <Breadcrumb :items="breadcrumb" />

    <Content>
        <div class="row">

            <div class="col-12">
                <h1> Erro {{ error.id }}</h1>
            </div><!-- col-12 -->

            <hr>

            <div class="col-lg-6">
                <h2>Detalhes</h2>

                <NameValueTable :content="details" />
            </div><!-- col-lg-6 -->

            <div class="col-lg-6">
                <h2>Registro de Ocorrências</h2>

                <Table :headers="['ID', 'Banco', 'Data', '']" >
                    <tr v-for="(log, index) in $page.props.logs.data" :key="index">
                        <td>{{ log.id }}</td>
                        <td>{{ log.customer.name }}</td>
                        <td>{{ (new Date(log.created_at)).toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' }) }}</td>
                        <td>
                            <Link :href="route('errors.log', { log: log.id })">
                                <Button type="button" color="primary" classes="btn-sm">
                                    <EyeIcon size="15" />
                                </Button>
                            </Link>
                        </td>
                    </tr>
                </Table>

                <Paginate v-if="$page.props.logs.data.length > 0" :links="$page.props.logs.links" />
            </div><!-- col-lg-6 -->

            <div class="col-12">
                <h2>Anotações</h2>
                <div class="card border">
                    <div class="d-flex justify-start">
                        <div class="avatar-img m-2">
                            <div class="bg-secondary rounded-5" style="width: 50px; height: 50px">

                            </div><!-- avatar-img me-2 -->
                        </div><!-- avatar-img -->
                        <div class="note">
                            <h3>Nome do cidadão</h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam, est maxime molestias perferendis recusandae vitae voluptates. Assumenda commodi corporis ea excepturi ipsam ipsum, iste laudantium maxime nesciunt odio porro quia.
                            </p>
                        </div><!-- note -->
                    </div><!-- d-flex justify-start -->
                </div><!-- card -->
            </div><!-- col-md-6 -->

            <div class="col-12 mt-5">
                <h2>Anotações</h2>

                <ChatMessage
                    v-for="(note, index) in $page.props.error.notes"
                    :key="index"
                    :text="note.text"
                    :color="note.user_id == $page.props.auth.user.id ? 'light' : 'secondary'"
                    :author="{ name: note.user.name }"
                    :classes="note.user_id == $page.props.auth.user.id
                        ? 'bg-primary text-white float-end'
                        : 'bg-info text-dark float-start'"
                />

                <div class="border rounded-circle">
                    <div class="input-group mb-3 border rounded-circle">
                        <span class="input-group-text">Mensagem</span>
                        <textarea class="form-control" v-model="note.message" placeholder="Adicione uma mensagem ..."></textarea>
                        <button class="btn btn-outline-primary" type="button" @click="createNewNote"><SendIcon /></button>
                    </div>
                </div>
            </div><!-- col-12 -->
        </div><!-- row -->
    </Content>
</template>
