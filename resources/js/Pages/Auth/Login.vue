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
        //import { Toast } from 'bootstrap'
        // const submit = () => {
        //     form.post(route('signIn'), {
        //         onError: () => {
        //             let toastElList = [].slice.call(document.querySelectorAll('.toast'))
        //             let toastList = toastElList.map(function(toastEl) {
        //                 return new Toast(toastEl)
        //             })
        //             toastList.forEach(toast => toast.show())
        //         },
        //         onFinish: () => form.reset('password'),
        //     });
        // };
    const submit = () => {
        form.post(route('signIn'), {
            onFinish: () => {
                form.reset('password')
            },
        });
    };

</script>

<template>
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center mt-5">
            <div class="col-10 col-md-6 position-absolute top-50 start-50 translate-middle" style="max-width: 450px">
                <!-- Form -->
                <form @submit.prevent="submit" class="form-example border border-secondary rounded-2 p-4">
                    <h1 class="text-center">Login</h1>
                    <!-- Input fields -->
                    <div class="mb-3">
                        <Label for="email" value="Email:" />
                        <Input id="email" type="email" class="form-control" :class="errors.email ? 'is-invalid' : ''" v-model="form.email" required />
                        <div class="invalid-feedback">{{ form.errors.email }}</div>
                    </div>
                    <div class="mb-3">
                        <Label for="password" value="Password:" />
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
