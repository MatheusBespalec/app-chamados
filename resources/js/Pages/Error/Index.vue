<script setup>

import Breadcrumb from '@/Components/Breadcrumb';
import MainTitle from '@/Components/MainTitle'
import Paginate from '@/Components/Paginate'
import Content from '@/Components/Content';
import Button from '@/Components/Button';
import Table from '@/Components/Table';
import EyeIcon from '@/Icons/EyeIcon';
import { Link } from '@inertiajs/inertia-vue3';

const breadcrumb = [
    {
        text: 'Erros',
    }
];

</script>

<template>
    <Breadcrumb :items="breadcrumb" />

    <Content>
        <MainTitle title="Erros" />

        <div class="row">
            <div class="col-12">
                <Table :headers="['ID', 'Código', 'Arquivo', 'Linha', 'Mensagem', 'Status', 'Ultima Ocorrência', '']">
                    <tr v-for="(error, index) in $page.props.errors.data" :key="index">
                        <td>{{ error.id }}</td>
                        <td>{{ error.code }}</td>
                        <td>{{ error.file }}</td>
                        <td>{{ error.line }}</td>
                        <td>{{ error.message }}</td>
                        <td>{{ error.status }}</td>
                        <td>{{ (new Date(error.updated_at)).toLocaleString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' }) }}</td>
                        <td>
                            <Link :href="route('errors.show', error.id)">
                                <Button type="button" color="primary" classes="btn-sm">
                                    <EyeIcon size="15" />
                                </Button>
                            </Link>
                        </td>
                    </tr>
                </Table>

                <Paginate :links="$page.props.errors.links" />
            </div>
        </div><!-- com-md-12 -->
    </Content>
</template>
