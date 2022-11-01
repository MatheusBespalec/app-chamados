<script setup>

import Breadcrumb from '@/Components/Breadcrumb';
import MainTitle from '@/Components/MainTitle';
import DataList from '@/Components/DataList'
import Content from '@/Components/Content'
import Table from '@/Components/Table';
import { usePage, Link } from '@inertiajs/inertia-vue3';

const log = usePage().props.value.log;

const breadcrumb = [
    {
        text: 'Logs',
        route: 'logs.index'
    },
    {
        text: `Log ${log.id}`
    }
];

const dataList = [
    {
        name: 'Dados',
        description: 'Dados adicionais adicionados',
        data: log.additional_data,
    },
    {
        name: 'Body',
        description: 'Body da Requisição',
        data: log.raw_body,
    },
    {
        name: 'Server',
        description: 'Informação do servidor e ambiente de execução',
        data: log.server,
    },
    {
        name: 'Request',
        description: 'Variáveis de requisição HTTP',
        data: log.request,
    },
    {
        name: 'Header',
        description: 'Headers da requisição',
        data: log.headers,
    },
    {
        name: 'Sessão',
        description: 'Dados de Sessão',
        data: log.session,
    }
];

</script>

<template>
    <Breadcrumb :items="breadcrumb" />

    <Content>
        <div class="row">
            <MainTitle :title="`Log ${log.id}`" />
            <Link :href="route(`${$page.props.originRoute}.show`, log.logable_id)">
                Origem
            </Link>
            <div class="col-12">
                <h2>Dados</h2>
                <DataList :content="dataList" />
            </div><!-- col-12 -->
        </div><!-- row -->
    </Content>
</template>
