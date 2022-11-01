<script setup>
import NameValueTable from "@/Components/NameValueTable";
import FormGroup from "@/Components/Form/FormGroup";
import Input from "@/Components/Form/Input";
import Label from "@/Components/Form/Label";
import SimpleCard from "@/Components/SimpleCard";
import Breadcrumb from "@/Components/Breadcrumb";
import MainTitle from "@/Components/MainTitle";
import Paginate from "@/Components/Paginate";
import Content from "@/Components/Content";
import Button from "@/Components/Button";
import Table from "@/Components/Table";
import Modal from "@/Components/Modal";
import EyeIcon from "@/Icons/EyeIcon";
import Formatter from "@/Helpers/Formatter";
import { Modal as BoostrapModal } from "bootstrap";
import { onMounted } from "vue";
import { usePage, useForm, Link } from "@inertiajs/inertia-vue3";

const project = usePage().props.value.project;
const bancoDigital = usePage().props.value.bancoDigital;
const customer = usePage().props.value.customer;
const breadcrumb = [
    {
        text: "Projetos",
        route: "projects.index",
    },
    {
        text: "Banco Digital",
        route: "banco-digital.index",
    },
    {
        text: customer.name,
        route: "customers.show",
        params: { customer: customer.id },
    },
];

let webhookModal;
let lambdaModal;

onMounted(() => {
    webhookModal = new BoostrapModal(document.getElementById('edit-webhook'));
    lambdaModal = new BoostrapModal(document.getElementById('edit-lambda'));
});

const editWebhookModal = () => {
    webhookModal.show();
}

const editLambdaModal = () => {
    lambdaModal.show();
}

const editWebhook = () => {
    webhook.patch(route('banco-digital.updateWebhook', { customer: customer.id }), {
        onSuccess() {
            webhookModal.hide();
        }
    });
};

const editLambda = () => {
    lambda.patch(route('banco-digital.updateLambda', { customer: customer.id }), {
        onSuccess() {
            lambdaModal.hide();
        }
    });
};

const webhook = useForm({
    webhook: bancoDigital.webhook
});

const lambda = useForm({
    lambda: bancoDigital.env_lambda
});

</script>

<template>
    <Breadcrumb :items="breadcrumb" />

    <Content>
        <div class="row">
            <div class="col-12">
                <MainTitle :title="`${project.name} | ${customer.name}`" />
            </div>
            <!-- col-12 -->

            <div class="col-12 mb-3">
                <Link :href="route('banco-digital.disableVan', { customer: customer.id })" class="btn btn-danger btn-sm m-2" method="post" as="button">
                    Desabilitar Van
                </Link>

                <Link :href="route('banco-digital.disableDebug', { customer: customer.id })" class="btn btn-danger btn-sm m-2" method="post" as="button">
                    Desabilitar Debug
                </Link>

                <Link :href="route('banco-digital.enableIpDebug', { customer: customer.id })" class="btn btn-success btn-sm m-2" method="post" as="button">
                    Habilitar IP para Debug
                </Link>

                <Link :href="route('banco-digital.enableDebug', { customer: customer.id })" class="btn btn-success btn-sm m-2" method="post" as="button">
                    Habilitar Debug
                </Link>

                <Button type="button" color="primary" classes="btn-sm m-2" @click="editWebhookModal">
                    Editar Webhook
                </Button>

                <Button type="button" color="primary" classes="btn-sm m-2" @click="editLambdaModal">
                    Editar Lambda
                </Button>
            </div><!-- col-12 -->

            <div class="col-md-6">
                <h2>Detalhes</h2>
                <NameValueTable :content="[
                    {
                        name: 'Debug',
                        value: $page.props.debugIsEnable ? 'Habilidato' : 'Desabilidato'
                    },
                    {
                        name: 'IP Habilitado para debug',
                        value: $page.props.ipDebug
                    },
                    {
                        name: 'Van',
                        value: $page.props.vanIsEnable ? 'Habilitada' : 'Desabilitada'
                    },
                    {
                        name: 'Webhook de Chamados',
                        value: $page.props.bancoDigital.webhook
                    },
                    {
                        name: 'Função Lambda',
                        value: $page.props.bancoDigital.env_lambda
                    }
                ]" />
            </div><!-- col-12 -->

            <div class="col-12">
                <h2>Logs</h2>

                <Table :headers="['ID', 'Cliente', 'Projeto','Ocorrência', '']">
                    <tr v-for="(log, index) in $page.props.logs" :key="index">
                        <td>{{ log.id }}</td>
                        <td>{{ customer.name }}</td>
                        <td>{{ project.name }}</td>
                        <td>{{ Formatter.asDateTime(log.created_at) }}</td>
                        <td>
                            <Link :href="route('logs.show', { log: log.id })">
                                <Button type="button" color="primary" classes="btn-sm">
                                    <EyeIcon size="15" />
                                </Button>
                            </Link>
                        </td>
                    </tr>
                    <tr v-if="$page.props.logs.length == 0">
                        <td class="text-center" colspan="5">Nenhum log encontrado</td>
                    </tr>
                </Table>

                <Link v-if="$page.props.logs.length > 0"
                    :href="route('logs.index', { customer: customer.id, project: project.id })"
                >
                    <EyeIcon size="15" /> Ver Mais
                </Link>
            </div><!-- col-12 -->
        </div><!-- row -->
    </Content>

    <Modal title="Editar Webhook" id="edit-webhook">
        <template v-slot:body>
            <FormGroup>
                <Label value="Webhook" id="webhook" />
                <Input type="text" v-model="webhook.webhook" id="webhook" :class="webhook.errors.webhook ? 'is-invalid' : ''" />
                <div class="invalid-feedback">{{ webhook.errors.webhook }}</div>
            </FormGroup>
        </template>
        <template v-slot:footer>
            <Button color="primary" @click="editWebhook">Salvar</Button>
        </template>
    </Modal>

    <Modal title="Editar Função Lambda" id="edit-lambda">
        <template v-slot:body>
            <FormGroup>
                <Label value="Função Lambda" id="lambda" />
                <Input type="text" v-model="lambda.lambda" id="lambda" :class="lambda.errors.lambda ? 'is-invalid' : ''" />
                <div class="invalid-feedback">{{ lambda.errors.lambda }}</div>
            </FormGroup>
        </template>
        <template v-slot:footer>
            <Button color="primary" @click="editLambda">Salvar</Button>
        </template>
    </Modal>
</template>
