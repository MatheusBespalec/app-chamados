<script setup>

import Breadcrumb from '@/Components/Breadcrumb'
import MainTitle from '@/Components/MainTitle';
import NameValueTable from '@/Components/NameValueTable';
import Input from '@/Components/Form/Input'
import Select from '@/Components/Form/Select'
import Button from '@/Components/Button'
import SendIcon from '@/Icons/SendIcon'
import Content from '@/Components/Content'
import ChatMessage from '@/Components/ChatMessage'
import { callStatus } from '@/Helpers/DomainStatus';
import { usePage, Link, useForm } from '@inertiajs/inertia-vue3';

const call = usePage().props.value.call;

const note = useForm({
    message: null
});

const createNewNote = () => {
    note.post(route('calls.notes.store', { call: call.id }))
    note.reset()
};

const breadcrumb = [
    {
        text: 'Chamados',
        route: 'calls.index'
    },
    {
        text: `Chamado ${call.id}`
    }
];

const details = [
    {
        name: 'Cliente',
        value: call.customer.name
    },
    {
        name: 'Projeto',
        value: call.project.name
    },
    {
        name: 'Categoria',
        value: call.category
    },
    {
        name: 'Status',
        value: callStatus(call.status)
    },
    {
        name: 'Descrição',
        value: call.description
    },
];

</script>

<template>
    <Breadcrumb :items="breadcrumb" />

    <Content>
        <div class="row">
            <div class="col-12">
                <MainTitle :title="`${call.customer.name} - ${call.title}`" />
            </div><!-- col-12 -->

            <div class="col-12">
                <h2>Detalhes</h2>
                <NameValueTable :content="details" />
                <Link :href="route('calls.history', { call: call.id })" class="btn btn-warning">Histórico</Link>
            </div><!-- col-6 -->

            <div class="col-12 mt-5">
                <h2>Anotações</h2>

                <ChatMessage
                    v-for="(note, index) in $page.props.call.notes"
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
