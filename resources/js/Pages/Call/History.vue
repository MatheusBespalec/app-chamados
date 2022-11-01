<script setup>

import Breadcrumb from '@/Components/Breadcrumb';
import Content from '@/Components/Content';
import MainTitle from '@/Components/MainTitle';
import ChatMessage from '@/Components/ChatMessage';
import SendIcon from '@/Icons/SendIcon'
import { usePage, Link, useForm } from '@inertiajs/inertia-vue3';

const call = usePage().props.value.call
const breadcrumb = [
    {
        text: 'Chamados',
        route: 'calls.index'
    },
    {
        text: `Chamado ${call.id}`,
        route: `calls.show`,
        params: { call: call.id }
    },
    {
        text: 'Historico'
    }
];

const message = useForm({
    text: undefined,
    file: undefined
});
const createNewMessage = () => {
    message.post(route('calls.messages.send', { call: call.id }), {
        onSuccess() {
            message.reset()
            window.scrollTo(0, document.body.scrollHeight);
        }
    })
};

</script>
<template>
    <Breadcrumb :items="breadcrumb" />

    <Content>
        <MainTitle :title="`Histórico do Chamado ${call.id}`" />

        <div class="row">
            <div class="col-12">
                <ChatMessage
                    v-for="(message, index) in $page.props.call.messages"
                    :id="message.id"
                    :key="index"
                    :canDelete="false"
                    :text="message.text"
                    :file="message.file_path"
                    :color="message.user_id == $page.props.auth.user.id ? 'light' : 'secondary'"
                    :author="{ name: message.user == null ? message.from : message.user.name }"
                    :classes="message.user_id == $page.props.auth.user.id
                        ? 'bg-primary text-white float-end'
                        : 'bg-light text-dark float-start'"
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
                        Enviar <SendIcon />
                    </button>
                </div>
            </div><!-- col-12 -->
        </div><!-- row -->
    </Content>
</template>
