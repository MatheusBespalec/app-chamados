<script setup>

import NameValueTable from '@/Components/NameValueTable';
import FormGroup from '@/Components/Form/FormGroup';
import Input from '@/Components/Form/Input';
import Label from '@/Components/Form/Label';
import SimpleCard from '@/Components/SimpleCard';
import Breadcrumb from '@/Components/Breadcrumb';
import MainTitle from '@/Components/MainTitle';
import Paginate from '@/Components/Paginate';
import Content from '@/Components/Content';
import Button from '@/Components/Button';
import Table from '@/Components/Table';
import Modal from '@/Components/Modal';
import UserIcon from '@/Icons/UserIcon';
import { Modal as BoostrapModal } from 'bootstrap';
import { onMounted } from 'vue';
import { usePage, useForm, Link } from '@inertiajs/inertia-vue3';

const user = usePage().props.value.auth.user;
const breadcrumb = [
    {
        text: 'Usuários',
        route: 'users.index'
    },
    {
        text: 'Meu Perfil',
    }
];

const profileForm = useForm({
    name: user.name,
    email: user.email,
    image: user.image ?? undefined
});

const updateProfile = () => {
    profileForm.post(route('users.update', { user: user.id }))
};
const upImage = (image) => {
    document.getElementById('user-image').src = URL.createObjectURL(profileForm.image)
}

onMounted(() => {
    $('#image-overlay').hover(() => {
        $('#image-overlay').animate({
            opacity: 0.75,
        }, 200)
    }, () => {
        $('#image-overlay').animate({
            opacity: 0,
        }, 200)
    });
})

</script>

<template>
    <Breadcrumb :items="breadcrumb" />

    <Content>
        <MainTitle title="Perfil" />

        <div class="mx-auto" style="max-width: 600px">
            <div role="button" :class="`position-relative overflow-hidden border border-4 border-dark rounded-circle d-flex justify-content-center align-items-center m-auto`" style="width: 150px; height: 150px">
                <label id="image-overlay" role="button" style="opacity: 0" class="h-100 w-100 bg-dark position-absolute d-flex justify-content-center align-items-center" for="image">
                    <span class="text-light">Alterar Imagem</span>
                </label>
                <UserIcon v-if="profileForm.image === undefined" size="100" />
                <img v-if="profileForm.image !== undefined" :style="profileForm.image !== undefined ? 'none' : 'block'" id="user-image" class="w-100" :src="route('storage', { filePath: user.image })">
            </div><!-- avatar-img me-2 -->
            <p v-if="profileForm.errors.image" class="text-danger">{{ profileForm.errors.image }}</p>
            <input class="d-none" type="file" id="image" @change="upImage" @input="profileForm.image = $event.target.files[0]">

            <FormGroup>
                <Label value="Nome" id="name" />
                <Input v-model="profileForm.name" id="name" :class="profileForm.errors.name ? 'is-invalid' : ''" />
                <div class="invalid-feedback">{{ profileForm.errors.name }}</div>
            </FormGroup>

            <FormGroup>
                <Label value="Email" id="email" />
                <Input v-model="profileForm.email" id="email" :class="profileForm.errors.email ? 'is-invalid' : ''" />
                <div class="invalid-feedback">{{ profileForm.errors.email }}</div>
            </FormGroup>

            <Button color="primary" @click="updateProfile">Salvar</Button>
        </div>
    </Content>
</template>
