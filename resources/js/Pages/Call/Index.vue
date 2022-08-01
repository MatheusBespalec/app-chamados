<script setup>

import Breadcrumb from '@/Components/Breadcrumb';
import MainTitle from '@/Components/MainTitle';
import Content from '@/Components/Content';
import Button from '@/Components/Button';
import Table from '@/Components/Table';
import EyeIcon from '@/Icons/EyeIcon';
import Formatter from '@/Helpers/Formatter';
import Paginate from '@/Components/Paginate';
import { callStatus } from '@/Helpers/Domain';
import { Link, usePage } from '@inertiajs/inertia-vue3';

const breadcrumb = [
    {
        text: 'Chamados',
    }
];

</script>

<template>
    <Breadcrumb :items="breadcrumb" />

    <Content>
        <MainTitle title="Chamados" />

        <div class="row">
            <div class="col-12">
                <Table :headers="['ID', 'Titulo', 'Cliente', 'Projeto', 'Status', 'Ultima Atualização', 'Data de Criação', '']">
                    <tr v-for="(call, index) in $page.props.calls.data" :key="index">
                        <td>{{ call.id }}</td>
                        <td>{{ call.title }}</td>
                        <td>{{ call.customer.name }}</td>
                        <td>{{ call.project.name }}</td>
                        <td>{{ callStatus(call.status) }}</td>
                        <td>{{ Formatter.asDateTime(call.updated_at) }}</td>
                        <td>{{ Formatter.asDateTime(call.created_at) }}</td>
                        <td>
                            <Link :href="route('calls.show', { call: call.id})">
                                <Button type="button" color="primary" classes="btn-sm">
                                    <EyeIcon size="15" />
                                </Button>
                            </Link>
                        </td>
                    </tr>
                </Table>
                <Paginate :links="$page.props.calls.links" />
            </div>
        </div><!-- com-md-12 -->
    </Content>
</template>
