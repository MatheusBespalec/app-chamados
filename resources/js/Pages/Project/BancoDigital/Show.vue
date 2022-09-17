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
    import EyeIcon from '@/Icons/EyeIcon';
    import { Modal as BoostrapModal } from 'bootstrap';
    import { onMounted } from 'vue';
    import { usePage, useForm, Link } from '@inertiajs/inertia-vue3';

    const project = usePage().props.value.project;
    const customer = usePage().props.value.customer;
    const breadcrumb = [
        {
            text: 'Projetos',
            route: 'projects.index'
        },
        {
            text: 'Banco Digital',
            route: 'banco-digital.index'
        },
        {
            text: customer.name,
            route: 'customers.show',
            params: { customer: customer.id }
        }
    ];

    </script>

    <template>
        <Breadcrumb :items="breadcrumb" />

        <Content>
            <div class="row">

                <div class="col-12">
                    <MainTitle :title="`${project.name} | ${customer.name}`" />
                </div><!-- col-12 -->

                <div class="col-12">
                    <Link href="" class="btn btn-danger btn-sm me-2">
                        Desabilitar Van
                    </Link>

                    <Link href="" class="btn btn-success btn-sm me-2">
                        Habilitar IP para Debug
                    </Link>

                    <Link href="" class="btn btn-success btn-sm me-2">
                        Habilitar Debug
                    </Link>
                </div>
            </div><!-- row -->
        </Content>
    </template>
