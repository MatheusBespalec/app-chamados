<script setup>

    import Button from '@/Components/Button';
    import Checkbox from '@/Components/Form/Checkbox';
    import Input from '@/Components/Form/Input';
    import Label from '@/Components/Form/Label';
    import { useForm } from '@inertiajs/inertia-vue3';

    const props = defineProps({
        errors: Object,
    });
    const form = useForm({
        email: '',
        password: '',
        remember: true
    })
    const submit = () => {
        form.post(route('signIn'), {
            onFinish: () => {
                form.reset('password')
            },
        });
    };

</script>
<style>
    body {
        background: linear-gradient(90deg, rgba(8,10,18,1) 0%, rgba(30,49,75,1) 100%);
    }
</style>
<template>

    <div class="toast-container position-fixed top-0 end-0 p-3 z-index-3" id="toast-container">
        <div  v-if="$page.props.flash.success" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header text-success">
                <strong class="me-auto">Mensagem do Sistema</strong>
                <small>Agora</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ $page.props.flash.success }}
            </div>
        </div>

        <div  v-if="$page.props.flash.error" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header text-danger">
                <strong class="me-auto">Mensagem do Sistema</strong>
                <small>Agora</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ $page.props.flash.error }}
            </div>
        </div>

        <div  v-if="$page.props.flash.warning" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header text-warning">
                <strong class="me-auto">Mensagem do Sistema</strong>
                <small>Agora</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ $page.props.flash.warning }}
            </div>
        </div>
    </div>
    <div class="container h-100 bg-light">
        <div class="row h-100 justify-content-center align-items-center mt-5">
            <div class="col-10 col-md-6 position-absolute top-50 start-50 translate-middle" style="max-width: 450px">
                <!-- Form -->
                <form @submit.prevent="submit"  class="form-example border border-secondary rounded-2 p-4 bg-light">
                    <h1 class="text-center">Login</h1>
                    <!-- Input fields -->
                    <div class="mb-3">
                        <Label for="email" value="Email:" />
                        <Input id="email" type="email" class="form-control" :class="errors.email ? 'is-invalid' : ''" v-model="form.email" required />
                        <div class="invalid-feedback">{{ form.errors.email }}</div>
                    </div>
                    <div class="mb-3">
                        <Label for="password" value="Senha:" />
                        <Input type="password" class="form-control" :class="errors.password ? 'is-invalid' : ''" id="password" v-model="form.password"  />
                        <div class="invalid-feedback">{{ form.errors.password }}</div>
                    </div>

                    <div class="mb-3 form-check">
                        <Checkbox name="remember" id="remember" v-model="form.remember" />
                        <Label for="remember" value="Lembrar-me" />
                    </div>

                    <Button type="submit" class="btn btn-primary btn-customized">Entrar</Button>
                    <!-- End input fields -->
                </form>
                <!-- Form end -->
            </div>
        </div>
    </div>
</template>
