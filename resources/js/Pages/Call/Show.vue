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
import { callStatus } from '@/Helpers/DomainStatus';
import { onMounted } from 'vue';
import { usePage, Link, useForm } from '@inertiajs/inertia-vue3';

let finishCallModal;
onMounted(() => {
    finishCallModal = new BoostrapModal(document.getElementById('finish-call'));
});

const openFinishCallModal = () => {
    finishCallModal.show()
}

const call = usePage().props.value.call;
const message = useForm({
    text: undefined,
    file: undefined
});
const createNewMessage = () => {
    message.post(route('calls.messages.store', { call: call.id }), {
        onSuccess() {
            message.reset()
            window.scrollTo(0, document.body.scrollHeight);
        }
    })
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
        name: 'Criador do Chamado',
        value: call.from
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
                <Link :href="route('calls.history', { call: call.id })" class="btn btn-warning me-2">Histórico</Link>
                <Link :href="route('calls.history', { call: call.id })" class="btn btn-info me-2">Atribuir Chamado</Link>
                <a @click="openFinishCallModal" class="btn btn-success me-2">Concluir Chamado</a>
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
            <Button color="success">Finalizar</Button>
        </template>
    </Modal>
</template>
