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
        text: 'Clientes',
    }
];

</script>

<template>
    <Breadcrumb :items="breadcrumb" />

    <Content>
        <MainTitle title="Clientes" />

        <div class="row">
            <div class="col-12 mb-3">
                <Link :href="route('customers.create')" class="btn btn-primary">Novo Cliente</Link>
            </div><!-- col-12 -->
            <div class="col-12">
                <Table :headers="['ID', 'Nome', '']">
                    <tr v-for="(customer, index) in $page.props.customers.data" :key="index">
                        <td>{{ customer.id }}</td>
                        <td>{{ customer.name }}</td>
                        <td>
                            <Link :href="route('customers.show', customer.id)">
                                <Button type="button" color="primary" classes="btn-sm">
                                    <EyeIcon size="15" />
                                </Button>
                            </Link>
                        </td>
                    </tr>
                </Table>

                <Paginate :links="$page.props.customers.links" />
            </div>
        </div><!-- com-md-12 -->
    </Content>
</template>
