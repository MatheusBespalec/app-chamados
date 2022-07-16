<script setup>

import Table from '@/Components/Table';
import NameValueTable from '@/Components/NameValueTable';
import Breadcrumb from '@/Components/Breadcrumb';
import Button from '@/Components/Button';
import ChatMessage from '@/Components/ChatMessage'
import SendIcon from '@/Icons/SendIcon'
import EyeIcon from '@/Icons/EyeIcon';
import MainTitle from '@/Components/MainTitle.vue';
import Paginate from '@/Components/Paginate.vue';
import { Link, usePage } from '@inertiajs/inertia-vue3';

const attack = usePage().props.value.attack;

const note = useForm({
    message: null
});

const createNewNote = () => {
    note.post(route('attacks.notes.store', { attack: attack.id }))
    note.reset()
};

const breadcrumb = [
    {
        text: 'Ataques',
        route: 'attacks.index'
    },
    {
        text: `${attack.controller} | ${attack.action}`
    }
];

const details = [
    {
        name: 'Descrição',
        value: attack.description
    },
    {
        name: 'Url',
        value: attack.url
    }
];

</script>

<template>
    <Breadcrumb :items="breadcrumb" />
    <section class="content">
        <div class="col-12">
            <MainTitle :title="`Tentativas de ataque em: ${attack.controller} / ${attack.action}`" />
        </div><!-- col-12 -->

        <div class="col-12">
            <h2>Descrição</h2>

            <NameValueTable :content="details" />
        </div>

        <div class="col-md-12">
            <h2>Registro de Ocorrências</h2>

            <Table :headers="['ID', 'Cliente', 'Método','Data', '']">
                <tr v-for="(log, key) in $page.props.logs.data" :key="key">
                    <td>{{ log.id }}</td>
                    <td>{{ log.customer.name }}</td>
                    <td>{{ log.method }}</td>
                    <td>
                        {{ (new Date(log.created_at)).toLocaleDateString('pt-BR', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit'
                        }) }}
                    </td>
                    <td>
                        <Link :href="route('attacks.log', { log: log.id })">
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
                v-for="(note, index) in $page.props.attack.notes"
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
    </section><!-- content -->
</template>
