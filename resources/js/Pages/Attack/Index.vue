<script setup>

import Table from '@/Components/Table';
import EyeIcon from '@/Icons/EyeIcon';
import Breadcrumb from '@/Components/Breadcrumb';
import Button from '@/Components/Button';
import MainTitle from '@/Components/MainTitle';
import Paginate from '@/Components/Paginate'
import { Link, usePage } from '@inertiajs/inertia-vue3';

const breadcrumb = [
    {
        text: 'Ataques',
    }
];

</script>

<template>
    <Breadcrumb :items="breadcrumb" />

    <section class="content">
        <MainTitle title="Ataques" />

        <div class="row">
            <div class="col-12">
                <Table :headers="['ID', 'Controller', 'Action', 'URI', 'Ultima Ocorrência', '']">
                    <tr v-for="(attack, index) in $page.props.attacks.data" :key="index">
                        <td>{{ attack.id }}</td>
                        <td>{{ attack.controller }}</td>
                        <td>{{ attack.action }}</td>
                        <td>{{ attack.url }}</td>
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
                <Paginate :links="$page.props.attacks.links" />
            </div>
        </div><!-- com-md-12 -->
    </section>
</template>
