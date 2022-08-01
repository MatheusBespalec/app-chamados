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
import Modal from '@/Components/Modal';
import { Modal as BoostrapModal } from 'bootstrap';
import { callStatus } from '@/Helpers/Domain';
import { onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia'
import { usePage, Link, useForm } from '@inertiajs/inertia-vue3';

let finishCallModal;
onMounted(() => {
    finishCallModal = new BoostrapModal(document.getElementById('finish-call'));
});


const openFinishCallModal = () => {
    finishCallModal.show()
}

const message = useForm({
    text: undefined,
    file: undefined
});
const createNewMessage = () => {
    message.post(route('calls.messages.store', { call: usePage().props.value.call.id }), {
        onSuccess() {
            message.reset()
            window.scrollTo(0, document.body.scrollHeight);
        }
    })
};
const finishCall = () => {
    useForm().patch(route('calls.finish', { call: usePage().props.value.call.id }), {
        onFinish() {
            finishCallModal.hide()
            window.scrollTo(0, 0);
        },
    })
};
const breadcrumb = [
    {
        text: 'Chamados',
        route: 'calls.index'
    },
    {
        text: `Chamado ${usePage().props.value.call.id}`
    }
];

const details = [
    {
        name: 'Cliente',
        value: usePage().props.value.call.customer.name
    },
    {
        name: 'Projeto',
        value: usePage().props.value.call.project.name
    },
    {
        name: 'Categoria',
        value: usePage().props.value.call.category
    },
    {
        name: 'Criador do Chamado',
        value: usePage().props.value.call.from
    },
    {
        name: 'Status',
        value: callStatus(usePage().props.value.call.status)
    },
    {
        name: 'UUID',
        value: usePage().props.value.call.uuid
    },
    {
        name: 'Descrição',
        value: usePage().props.value.call.description
    },
];

</script>

<template>
    <Breadcrumb :items="breadcrumb" />

    <Content>
        <div class="row">
            <div class="col-12">
                <MainTitle :title="`${$page.props.call.customer.name} - ${$page.props.call.title}`" />
            </div><!-- col-12 -->

            <div class="col-12">
                <h2>Detalhes</h2>
                <NameValueTable :content="details" />
                <Link :href="route('calls.history', { call: $page.props.call.id })" class="btn btn-warning me-2">Histórico</Link>
                <a v-if="$page.props.call.status == 1" @click="openFinishCallModal" class="btn btn-success me-2">Concluir Chamado</a>
            </div><!-- col-6 -->

            <div class="col-12 mt-5">
                <h2>Anotações</h2>

                <ChatMessage
                    v-for="(message, index) in $page.props.call.messages"
                    :key="index"
                    :text="message.text"
                    :file="message.file_path"
                    :color="message.user_id == $page.props.auth.user.id ? 'light' : 'secondary'"
                    :author="{ name: message.user.name ?? message.from }"
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
        </div><!-- row -->
    </Content>

    <Modal id="finish-call">
        <template v-slot:body>
            <h3>Deseja finalizar este chamado?</h3>
        </template>
        <template v-slot:footer>
            <Button @click="finishCall" color="success">Finalizar</Button>
        </template>
    </Modal>
</template>
