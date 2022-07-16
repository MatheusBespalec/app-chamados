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
        name: 'Raw Body',
        description: 'Body da Requisição',
        data: log.raw_body,
    },
    {
        name: '$_SERVER',
        description: 'Informação do servidor e ambiente de execução',
        data: log.var_server,
    },
    {
        name: '$_GET',
        description: 'Variáveis HTTP GET',
        data: log.var_get,
    },
    {
        name: '$_POST',
        description: 'Variáveis HTTP POST',
        data: log.var_post,
    },
    {
        name: '$_FILES',
        description: 'Variáveis de Upload de Arquivos HTTP',
        data: log.var_files,
    },
    {
        name: '$_SESSION',
        description: 'Variáveis de sessão',
        data: log.var_session,
    },
    {
        name: '$_REQUEST',
        description: 'Variáveis de requisição HTTP',
        data: log.var_request,
    },
    {
        name: '$_ENV',
        description: 'Variáveis de ambiente',
        data: log.var_env,
    },
    {
        name: '$_COOKIE',
        description: 'Cookies HTTP',
        data: log.var_cookie,
    },
    {
        name: '$http_response_header',
        description: 'Cabeçalhos de resposta HTTP',
        data: log.var_headers,
    },
    {
        name: 'Dados',
        description: 'Dados adicionais adicionados ao log',
        data: log.data,
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
