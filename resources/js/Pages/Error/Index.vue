<script setup>

import FormGroup from '@/Components/Form/FormGroup';
import Select from '@/Components/Form/Select';
import Breadcrumb from '@/Components/Breadcrumb';
import MainTitle from '@/Components/MainTitle';
import Paginate from '@/Components/Paginate';
import Content from '@/Components/Content';
import Button from '@/Components/Button';
import Table from '@/Components/Table';
import Label from '@/Components/Form/Label';
import Input from '@/Components/Form/Input';
import EyeIcon from '@/Icons/EyeIcon';
import Formatter from '@/Helpers/Formatter';
import { Inertia } from '@inertiajs/inertia'
import { Link, useForm, usePage } from '@inertiajs/inertia-vue3';

const params = new URLSearchParams(window.location.search)
const filter = useForm({
    id: params.get('id'),
    file: params.get('file'),
    from: params.get('from'),
    until: params.get('until'),
    project: params.get('project') || 0,
    customer: params.get('customer') || 0,
});

const breadcrumb = [
    {
        text: 'Erros',
    }
];

const updateList = () => {
    filter.get(route('errors.index'))
};

const resetFilters = () => {
    Inertia.get(route('errors.index'));
};

</script>

<template>
    <Breadcrumb :items="breadcrumb" />

    <div class="row">
        <FormGroup class="col-sm-2">
            <Label id="id" value="ID: " />
            <Input id="id" type="number" @change="updateList" v-model="filter.id" />
        </FormGroup>

        <FormGroup class="col-sm-4">
            <Label id="file" value="Arquivo: " />
            <Input id="file" @change="updateList" v-model="filter.file" />
        </FormGroup>

        <FormGroup class="col-sm-3">
            <Label id="file" value="Projeto: " />
            <Select placeholder="Selecione..." @change="updateList" :resources="$page.props.projects" v-model="filter.project" />
        </FormGroup>

        <FormGroup class="col-sm-3">
            <Label id="file" value="Cliente: " />
            <Select placeholder="Selecione..." @change="updateList" :resources="$page.props.customers" v-model="filter.customer" />
        </FormGroup>

        <FormGroup class="col-sm-6">
            <Label id="from" value="De: " />
            <Input type="date" id="from" @change="updateList" v-model="filter.from" />
        </FormGroup>

        <FormGroup class="col-sm-6">
            <Label id="until" value="Até: " />
            <Input type="date" id="until" @change="updateList" v-model="filter.until" />
        </FormGroup>
    </div><!-- row -->

    <Button @click="resetFilters" type="button" color="warning">
        Limpar Filtros
    </Button>

    <Content>
        <MainTitle title="Erros" />

        <div class="row">
            <div class="col-12">
                <Table :headers="['ID', 'Código', 'Arquivo', 'Linha', 'Mensagem', 'Ultima Ocorrência', '']">
                    <tr v-for="(error, index) in $page.props.errors.data" :key="index">
                        <td>{{ error.id }}</td>
                        <td>{{ error.code }}</td>
                        <td>{{ error.file.split('/').pop() }}</td>
                        <td>{{ error.line }}</td>
                        <td>{{ error.message }}</td>
                        <td>{{ Formatter.asFullDateTime(error.updated_at) }}</td>
                        <td>
                            <Link :href="route('errors.show', { error: error.id})">
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
