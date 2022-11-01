<script setup>

import NameValueTable from '@/Components/NameValueTable';
import ChatMessage from '@/Components/ChatMessage';
import Breadcrumb from '@/Components/Breadcrumb';
import MainTitle from '@/Components/MainTitle';
import Paginate from '@/Components/Paginate';
import Content from '@/Components/Content';
import Button from '@/Components/Button';
import Table from '@/Components/Table';
import Formatter from '@/Helpers/Formatter';
import SendIcon from '@/Icons/SendIcon';
import EyeIcon from '@/Icons/EyeIcon';
import { Link, usePage, useForm } from '@inertiajs/inertia-vue3';

const attack = usePage().props.value.attack;

const message = useForm({
    file: undefined,
    text: undefined
});

const createNewMessage = () => {
    message.post(route('attacks.messages.store', { attack: attack.id }), {
        onSuccess() {
            message.reset()
            window.scrollTo(0, document.body.scrollHeight);
        }
    })
};

const createNewNote = () => {
    note.post(route('attacks.messages.store', { attack: attack.id }))
    note.reset()
};

const breadcrumb = [
    {
        text: 'Ataques',
        route: 'attacks.index'
    },
    {
        text: `Ataque ${attack.id}`
    }
];

const details = [
    {
        name: 'Descrição',
        value: attack.description
    },
    {
        name: 'Rota',
        value: attack.route
    }
];

</script>

<template>
    <Breadcrumb :items="breadcrumb" />
    <Content>
        <div class="col-12">
            <MainTitle :title="`Ataque ${attack.id}`" />
        </div><!-- col-12 -->

        <div class="col-12">
            <h2>Descrição</h2>

            <NameValueTable :content="details" />
        </div>

        <div class="col-md-12">
            <h2>Registro de Ocorrências</h2>

            <Table :headers="['ID', 'Cliente','Data', '']">
                <tr v-for="(log, key) in $page.props.logs.data" :key="key">
                    <td>{{ log.id }}</td>
                    <td>{{ log.customer.name }}</td>
                    <td>{{ Formatter.asDate(log.created_at) }}</td>
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
        </div><!-- col-md-6 -->

        <div class="col-12 mt-5">
            <h2>Anotações</h2>

            <ChatMessage
                v-for="(message, index) in $page.props.attack.messages"
                :key="index"
                :text="message.text"
                :file="message.file_path"
                :color="message.user_id == $page.props.auth.user.id ? 'light' : 'secondary'"
                :author="{ name: message.from }"
                :classes="message.user_id == $page.props.auth.user.id
                    ? 'bg-primary text-white float-end'
                    : 'bg-info text-dark float-start'"
            />

            <div class="rounded-circle">
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
    </Content>
</template>
