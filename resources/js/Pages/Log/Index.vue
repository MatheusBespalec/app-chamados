<script setup>

import FormGroup from '@/Components/Form/FormGroup';
import Select from '@/Components/Form/Select';
import Label from '@/Components/Form/Label';
import Input from '@/Components/Form/Input';
import Breadcrumb from '@/Components/Breadcrumb';
import MainTitle from '@/Components/MainTitle';
import Paginate from '@/Components/Paginate';
import Content from '@/Components/Content';
import Button from '@/Components/Button';
import Table from '@/Components/Table';
import EyeIcon from '@/Icons/EyeIcon';
import Formatter from '@/Helpers/Formatter';
import { Inertia } from '@inertiajs/inertia'
import { Link, useForm } from '@inertiajs/inertia-vue3';

const params = new URLSearchParams(window.location.search)
const filter = useForm({
    id: params.get('id'),
    project: params.get('project') || 0,
    customer: params.get('customer') || 0,
    from: params.get('from'),
    until: params.get('until')
});

const breadcrumb = [
    {
        text: 'Logs',
    }
];

const updateList = () => {
    filter.get(route('logs.index'))
};

const resetFilters = () => {
    Inertia.get(route('logs.index'));
};

</script>

<template>
    <Breadcrumb :items="breadcrumb" />

    <div class="row">
        <FormGroup class="col-sm-2">
            <Label id="id" value="ID: " />
            <Input id="id" type="number" @change="updateList" v-model="filter.id" />
        </FormGroup>

        <FormGroup class="col-sm-3">
            <Label id="file" value="Projeto: " />
            <Select placeholder="Selecione..." @change="updateList" :resources="$page.props.projects" v-model="filter.project" />
        </FormGroup>

        <FormGroup class="col-sm-3">
            <Label id="file" value="Cliente: " />
            <Select placeholder="Selecione..." @change="updateList" :resources="$page.props.customers" v-model="filter.customer" />
        </FormGroup>

        <FormGroup class="col-sm-2">
            <Label id="from" value="De: " />
            <Input type="date" id="from" @change="updateList" v-model="filter.from" />
        </FormGroup>

        <FormGroup class="col-sm-2">
            <Label id="until" value="Até: " />
            <Input type="date" id="until" @change="updateList" v-model="filter.until" />
        </FormGroup>
    </div><!-- row -->

    <Button @click="resetFilters" type="button" color="warning">
        Limpar Filtros
    </Button>

    <Content>
        <MainTitle title="Logs Recebidos" />

        <div class="row">
            <div class="col-12">
                <Table :headers="['ID', 'Cliente', 'Projeto', 'Ocorrência', '']" >
                    <tr v-for="(log, index) in $page.props.logs.data" :key="index">
                        <td>{{ log.id }}</td>
                        <td>{{ log.customer.name }}</td>
                        <td>{{ log.project.name }}</td>
                        <td>{{ (new Date(log.created_at)).toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' }) }}</td>
                        <td>
                            <Link :href="route('logs.show', { log: log.id })">
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
