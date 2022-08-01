<script setup>

import Table from '@/Components/Table';
import EyeIcon from '@/Icons/EyeIcon';
import Breadcrumb from '@/Components/Breadcrumb';
import Button from '@/Components/Button';
import MainTitle from '@/Components/MainTitle';
import Paginate from '@/Components/Paginate'
import UserIcon from '@/Icons/UserIcon'
import { Link, usePage } from '@inertiajs/inertia-vue3';

const breadcrumb = [
    {
        text: 'Usuarios',
    }
];

</script>

<template>
    <Breadcrumb :items="breadcrumb" />

    <section class="content">
        <MainTitle title="Ataques" />

        <div class="row">
            <div class="col-12 mb-3">
                <Link :href="route('users.create')" class="btn btn-primary">Novo Usuario</Link>
            </div><!-- col-12 -->
            <div class="col-12">
                <Table :headers="['Usuario', 'Email']">
                    <tr v-for="(user, index) in $page.props.users.data" :key="index">
                        <td class="d-flex flex-wrap align-items-center">
                            <div class="overflow-hidden border border-dark rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 40px; height: 40px;">
                                <UserIcon v-if="user.image === null" size="20" />
                                <img v-if="user.image !== null" class="w-100" :src="route('storage', { filePath: user.image })">
                            </div>
                            {{ user.name }}
                        </td>
                        <td>{{ user.email }}</td>
                    </tr>
                </Table>
                <Paginate :links="$page.props.users.links" />
            </div>
        </div><!-- com-md-12 -->
    </section>
</template>
