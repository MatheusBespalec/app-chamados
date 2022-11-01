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
import { usePage, Link, useForm } from '@inertiajs/inertia-vue3';

const error = usePage().props.value.error;

const message = useForm({
    file: undefined,
    text: undefined
});
const createNewMessage = () => {
    message.post(route('errors.messages.store', { error: error.id }), {
        onSuccess() {
            message.reset()
            window.scrollTo(0, document.body.scrollHeight);
        }
    })
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
        name: 'Url',
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

                <Table :headers="['ID', 'Cliente', 'Data', '']" >
                    <tr v-for="(log, index) in $page.props.logs.data" :key="index">
                        <td>{{ log.id }}</td>
                        <td>{{ log.customer.name }}</td>
                        <td>{{ (new Date(log.created_at)).toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' }) }}</td>
                        <td>
                            <Link :href="route('logs.show', { log: log.id })">
                                <Button type="button" color="primary" classes="btn-sm">
                                    <EyeIcon size="15" />
                                </Button>
                            </Link>
                        </td>
                    </tr>
                </Table>

                <Paginate v-if="$page.props.logs.data.length > 0" :links="$page.props.logs.links" />
            </div><!-- col-lg-6 -->

            <div class="col-12 mt-5">
            <h2>Anotações</h2>

            <ChatMessage
                v-for="(message, index) in $page.props.error.messages"
                :key="index"
                :text="message.text"
                :file="message.file_path"
                :color="message.user_id == $page.props.auth.user.id ? 'light' : 'secondary'"
                :author="{ name: message.from }"
                :classes="message.user_id == $page.props.auth.user.id
                    ? 'bg-primary text-white float-end'
                    : 'bg-info text-dark float-start'"
            />

            <div class="border rounded-circle">
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
            </div>
        </div><!-- col-12 -->
        </div><!-- row -->
    </Content>
</template>
