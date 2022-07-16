<script setup>

import Breadcrumb from '@/Components/Breadcrumb';
import MainTitle from '@/Components/MainTitle'
import Paginate from '@/Components/Paginate'
import Content from '@/Components/Content';
import Button from '@/Components/Button';
import Table from '@/Components/Table';
import EyeIcon from '@/Icons/EyeIcon';
import { Link, usePage } from '@inertiajs/inertia-vue3';

console.log(usePage().props.value.projects)

const breadcrumb = [
    {
        text: 'Projetos',
    }
];

</script>

<template>
    <Breadcrumb :items="breadcrumb" />

    <Content>
        <MainTitle title="Projetos" />

        <div class="row">
            <div class="col-12 mb-3">
                <Link :href="route('projects.create')" class="btn btn-primary">Novo Projeto</Link>
            </div><!-- col-12 -->
            <div class="col-12">
                <Table :headers="['ID', 'Nome', 'Módulos', 'Clientes', '']">
                    <tr v-for="(project, index) in $page.props.projects.data" :key="index">
                        <td>{{ project.id }}</td>
                        <td>{{ project.name }}</td>
                        <td>{{ project.modules_count }}</td>
                        <td>{{ project.customers_count }}</td>
                        <td>
                            <Link :href="route('projects.show', project.id)">
                                <Button type="button" color="primary" classes="btn-sm">
                                    <EyeIcon size="15" />
                                </Button>
                            </Link>
                        </td>
                    </tr>
                </Table>

                <Paginate :links="$page.props.projects.links" />
            </div>
        </div><!-- com-md-12 -->
    </Content>
</template>
