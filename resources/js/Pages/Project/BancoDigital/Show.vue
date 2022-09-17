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

const details = [
    {
        name: 'Debug',
        value: 'Ativo'
    },
    {
        name: 'IP Habilitado para debug',
        value: '127.0.0.1'
    },
    {
        name: 'Van',
        value: 'Ativa'
    }
];

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
                <Link href="" class="btn btn-danger btn-sm me-2">
                    Desabilitar Van
                </Link>

                <Link href="" class="btn btn-success btn-sm me-2">
                    Habilitar IP para Debug
                </Link>

                <Link href="" class="btn btn-success btn-sm me-2">
                    Habilitar Debug
                </Link>
            </div><!-- col-12 -->

            <div class="col-md-6">
                <h2>Detalhes</h2>
                <NameValueTable :content="details" />
            </div><!-- col-12 -->

            <div class="col-12">
                <h2>Logs</h2>

                <Table :headers="['ID', 'Cliente', 'Projeto', 'Ocorrência', '']">
                    <tr v-for="(log, index) in $page.props.customer.logs" :key="index">
                        <td>{{ log.id }}</td>
                        <td>{{ log.customer.name }}</td>
                        <td>{{ log.project.name }}</td>
                        <td>{{ Formatter.asDateTime(log.created_at) }}</td>
                        <td>
                            <Link :href="route('logs.show', { log: log.id })">
                                <Button type="button" color="primary" classes="btn-sm">
                                    <EyeIcon size="15" />
                                </Button>
                            </Link>
                        </td>
                    </tr>
                    <tr v-if="$page.props.customer.logs.length == 0">
                        <td class="text-center" colspan="5">Nenhum log encontrado</td>
                    </tr>
                </Table>

                <Link v-if="$page.props.customer.logs.length > 0"
                    :href="route('logs.index', { customer: customer.id, project: project.id })"
                >
                    <EyeIcon size="15" /> Ver Mais
                </Link>
            </div><!-- col-12 -->
        </div><!-- row -->
    </Content>
</template>
