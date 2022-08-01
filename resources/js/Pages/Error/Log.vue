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
        text: 'Erros',
        route: 'errors.index'
    },
    {
        text: `Erro ${log.logable.id}`,
        route: 'errors.show',
        params: [log.logable.id]
    },
    {
        text: `Log ${log.id}`
    }
];

const dataList = [
    {
        name: 'Body',
        description: 'Body da Requisição',
        data: log.raw_body,
    },
    {
        name: '$_SERVER',
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
        name: 'Dados',
        description: 'Dados adicionais adicionados ao log',
        data: log.additional_data,
    },
    {
        name: 'Trilha',
        description: 'Caminho do log',
        data: log.trace,
    }
];

</script>

<template>
    <Breadcrumb :items="breadcrumb" />

    <Content>
        <div class="row">
            <MainTitle :title="`Log de Erro ${log.id}`" />

            <div class="col-12">
                <h2>Dados</h2>
                <DataList :content="dataList" />
            </div><!-- col-12 -->
        </div><!-- row -->
    </Content>
</template>
