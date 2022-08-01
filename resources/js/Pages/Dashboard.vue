<script setup>

import FormGroup from '@/Components/Form/FormGroup';
import Label from '@/Components/Form/Label';
import Input from '@/Components/Form/Input';
import Breadcrumb from '@/Components/Breadcrumb';
import MetricBox from '@/Components/MetricBox';
import Button from '@/Components/Button';
import DashboardIcon from '@/Icons/DashboardIcon';
import Formatter from '@/Helpers/Formatter';
import { Inertia } from '@inertiajs/inertia'
import { Link, useForm, usePage } from '@inertiajs/inertia-vue3';

const params = new URLSearchParams(window.location.search)
const filter = useForm({
    from: params.get('from') ?? new Date().toISOString().split('T')[0],
    until: params.get('until') ?? new Date().toISOString().split('T')[0]
});
const breadcrumb = [
    {
        text: 'Dashboard',
    }
];

const updateList = () => {
    filter.get(route('dashboard'))
};

</script>

<template>
    <Breadcrumb :items="breadcrumb" />

    <div class="row">
        <FormGroup class="col-sm-3">
            <Label id="from" value="De: " />
            <Input type="date" id="from" @change="updateList" v-model="filter.from" />
        </FormGroup>

        <FormGroup class="col-sm-3">
            <Label id="until" value="Até: " />
            <Input type="date" id="until" @change="updateList" v-model="filter.until" />
        </FormGroup>
    </div><!-- row -->

    <div class="d-flex justify-content-around flex-wrap">
        <MetricBox bg="#4778B5" :value="$page.props.attacksQtd" title="Logs de Ataques">
            <DashboardIcon />
        </MetricBox>

        <MetricBox bg="#000" :value="$page.props.errorsQtd" title="Logs de Erros">
            <DashboardIcon />
        </MetricBox>

        <MetricBox bg="#4778B5" :value="$page.props.callsQtd" title="Chamados em Aberto">
            <DashboardIcon />
        </MetricBox>
    </div><!-- row -->
</template>
