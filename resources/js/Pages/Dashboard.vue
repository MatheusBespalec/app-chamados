<script setup>

import FormGroup from '@/Components/Form/FormGroup';
import Label from '@/Components/Form/Label';
import Input from '@/Components/Form/Input';
import Breadcrumb from '@/Components/Breadcrumb';
import MetricBox from '@/Components/MetricBox';
import MainTitle from '@/Components/MainTitle';
import Content from '@/Components/Content';
import Button from '@/Components/Button';
import Modal from '@/Components/Modal';
import FormatterHelper from '@/Helpers/Formatter';
import Table from '@/Components/Table';
import DashboardIcon from '@/Icons/DashboardIcon';
import TrashIcon from '@/Icons/TrashIcon';
import Formatter from '@/Helpers/Formatter';
import { Modal as BoostrapModal } from 'bootstrap';
import { Link, useForm, usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { onMounted } from 'vue';

let allowIpModal;

onMounted(() => {
    allowIpModal = new BoostrapModal(document.getElementById('allow-ip'));
});

const openAllowIpModal = () => {
    allowIpModal.show();
}

const whitelist = useForm({
    ip: undefined,
    expiration: undefined,
    description: undefined
});

const saveAllowIp = () => {
    whitelist.post(route('whitelist.store'), {
        onSuccess() {
            whitelist.reset();
            allowIpModal.hide();
        }
    })
};

const params = new URLSearchParams(window.location.search)
const filter = useForm({
    from: params.get('from') ?? new Date().toISOString().split('T')[0],
    until: params.get('until') ?? new Date().toISOString().split('T')[0]
});
const breadcrumb = [
    {
        text: 'Dashboard',
    }
];

const updateList = () => {
    filter.get(route('dashboard'));
};

</script>

<template>
    <Breadcrumb :items="breadcrumb" />

    <div class="row">
        <FormGroup class="col-sm-3">
            <Label id="from" value="De: " />
            <Input type="date" id="from" @change="updateList" v-model="filter.from" />
        </FormGroup>

        <FormGroup class="col-sm-3">
            <Label id="until" value="Até: " />
            <Input type="date" id="until" @change="updateList" v-model="filter.until" />
        </FormGroup>
    </div><!-- row -->

    <div class="d-flex justify-content-around flex-wrap">
        <MetricBox bg="#4778B5" :value="$page.props.attacksQtd" title="Logs de Ataques">
            <DashboardIcon />
        </MetricBox>

        <MetricBox bg="#000" :value="$page.props.errorsQtd" title="Logs de Erros">
            <DashboardIcon />
        </MetricBox>

        <MetricBox bg="#4778B5" :value="$page.props.callsQtd" title="Chamados em Aberto">
            <DashboardIcon />
        </MetricBox>
    </div><!-- row -->

    <div class="row">
        <div class="col-6">
            <Content>
                <h2>WhiteList de IP's</h2>
                <Button type="button" color="primary" classes="mb-3" @click="openAllowIpModal">
                    Adicionar IP
                </Button>
                <Table :headers="['IP', 'Expiração', 'Descrição', '']">
                    <tr v-for="(ip, index) in $page.props.allowedIps" :key="index">
                        <td>{{ ip.ip }}</td>
                        <td>{{ ip.expiration == undefined ? 'Permanente' : FormatterHelper.asDate(ip.expiration) }}</td>
                        <td>{{ ip.description }}</td>
                        <td>
                            <Link :href="route('whitelist.destroy', { ip: ip.id })" method="delete">
                                <Button type="button" color="danger" classes="btn-sm">
                                    <TrashIcon size="15" />
                                </Button>
                            </Link>
                        </td>
                    </tr>
                </Table>
            </Content>
        </div><!-- col-12 -->
    </div><!-- row -->

    <Modal title="Liberar IP" id="allow-ip">
        <template v-slot:body>
            <FormGroup>
                <Label value="IP" id="ip" />
                <Input v-model="whitelist.ip" id="name" :class="whitelist.errors.ip ? 'is-invalid' : ''" />
                <div class="invalid-feedback">{{ whitelist.errors.ip }}</div>
            </FormGroup>

            <FormGroup>
                <Label value="Expiração" id="expiration" />
                <Input type="date" v-model="whitelist.expiration" id="expiration" :class="whitelist.errors.expiration ? 'is-invalid' : ''" />
                <div class="invalid-feedback">{{ whitelist.errors.expiration }}</div>
                <div id="expirationHelp" class="form-text">Não preencha nenhum valor caso queira liberar o IP permanentemente.</div>
            </FormGroup>

            <FormGroup>
                <Label value="Descrição" id="description" />
                <Input v-model="whitelist.description" id="description" :class="whitelist.errors.description ? 'is-invalid' : ''" />
                <div class="invalid-feedback">{{ whitelist.errors.description }}</div>
            </FormGroup>
        </template>
        <template v-slot:footer>
            <Button color="primary" @click="saveAllowIp">Salvar</Button>
        </template>
    </Modal>
</template>
