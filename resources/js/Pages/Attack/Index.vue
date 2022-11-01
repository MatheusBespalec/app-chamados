<script setup>

import FormGroup from '@/Components/Form/FormGroup';
import Select from '@/Components/Form/Select';
import Label from '@/Components/Form/Label';
import Input from '@/Components/Form/Input';
import Breadcrumb from '@/Components/Breadcrumb';
import MainTitle from '@/Components/MainTitle';
import Paginate from '@/Components/Paginate'
import Button from '@/Components/Button';
import Table from '@/Components/Table';
import EyeIcon from '@/Icons/EyeIcon';
import { Link, usePage, useForm } from '@inertiajs/inertia-vue3';

const params = new URLSearchParams(window.location.search)
const filter = useForm({
    id: params.get('id'),
    route: params.get('route'),
    from: params.get('from'),
    until: params.get('until'),
    project: params.get('project') || 0,
    customer: params.get('customer') || 0,
    description: params.get('description')
});

const updateList = () => {
    filter.get(route('attacks.index'))
};

const resetForm = () => {
    Inertia.get(route('attacks.index'));
};

const breadcrumb = [
    {
        text: 'Ataques',
    }
];

</script>

<template>
    <Breadcrumb :items="breadcrumb" />

        <div class="row">
            <FormGroup class="col-sm-2">
                <Label id="id" value="ID: " />
                <Input id="id" type="number" @change="updateList" v-model="filter.id" />
            </FormGroup>

            <FormGroup class="col-sm-4">
                <Label id="route" value="Rota: " />
                <Input id="route" @change="updateList" v-model="filter.route" />
            </FormGroup>

            <FormGroup class="col-sm-6">
                <Label id="description" value="Descrição: " />
                <Input id="description" @change="updateList" v-model="filter.description" />
            </FormGroup>

            <FormGroup class="col-sm-3">
                <Label id="file" value="Projeto: " />
                <Select placeholder="Selecione..." @change="updateList" :resources="$page.props.projects" v-model="filter.project" />
            </FormGroup>

            <FormGroup class="col-sm-3">
                <Label id="file" value="Cliente: " />
                <Select placeholder="Selecione..." @change="updateList" :resources="$page.props.customers" v-model="filter.customer" />
            </FormGroup>

            <FormGroup class="col-sm-3">
                <Label id="from" value="De: " />
                <Input type="date" id="from" @change="updateList" v-model="filter.from" />
            </FormGroup>

            <FormGroup class="col-sm-3">
                <Label id="until" value="Até: " />
                <Input type="date" id="until" @change="updateList" v-model="filter.until" />
            </FormGroup>
        </div><!-- row -->

    <Button @click="resetForm" type="button" color="warning">
        Limpar Filtros
    </Button>

    <section class="content">
        <MainTitle title="Ataques" />

        <div class="row">
            <div class="col-12">
                <Table :headers="['ID', 'Rota', 'Descrição', 'Ultima Ocorrência', '']">
                    <tr v-for="(attack, index) in $page.props.attacks.data" :key="index">
                        <td>{{ attack.id }}</td>
                        <td>{{ attack.route }}</td>
                        <td>{{ attack.description }}</td>
                        <td>{{ (new Date(attack.updated_at)).toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' }) }}</td>
                        <td>
                            <Link :href="route('attacks.show', attack.id)">
                                <Button type="button" color="primary" classes="btn-sm">
                                    <EyeIcon size="15" />
                                </Button>
                            </Link>
                        </td>
                    </tr>
                </Table>
                <Paginate :liPanks="$page.props.attacks.links" />
            </div>
        </div><!-- com-md-12 -->
    </section>
</template>
