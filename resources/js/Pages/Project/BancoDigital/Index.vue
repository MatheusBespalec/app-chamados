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
    const breadcrumb = [
        {
            text: 'Projetos',
            route: 'projects.index'
        },
        {
            text: 'Banco Digital'
        }
    ];

    </script>

    <template>
        <Breadcrumb :items="breadcrumb" />

        <Content>
            <div class="row">

                <div class="col-12">
                    <MainTitle :title="project.name" />
                </div><!-- col-12 -->

                <div class="col-12">
                    <Link :href="route('banco-digital.disableVans')" class="btn btn-danger btn-sm m-2" method="post" as="button">
                        Desabilitar Vans
                    </Link>

                    <Link :href="route('banco-digital.disableDebugs')" class="btn btn-danger btn-sm m-2" method="post" as="button">
                        Desabilitar Debugs
                    </Link>

                    <Link :href="route('banco-digital.enableIpDebugs')" class="btn btn-success btn-sm m-2" method="post" as="button">
                        Habilitar IP para Debugs
                    </Link>
                </div>


                <div class="col-12">
                    <h2>Clientes Associados</h2>
                    <Table :headers="['ID', 'Nome', 'UUID', '']">
                        <tr v-for="(customer, index) in $page.props.customers.data" :key="index">
                            <td>{{ customer.id }}</td>
                            <td>
                                <Link :href="route('customers.show', { customer: customer.id })">
                                    {{ customer.name }}
                                </Link>
                            </td>
                            <td>{{ customer.pivot.uuid }}</td>
                            <td>
                                <Link :href="route('banco-digital.show', { customer: customer.id })">
                                    <Button type="button" color="primary" classes="btn-sm">
                                        <EyeIcon size="15" />
                                    </Button>
                                </Link>
                            </td>
                        </tr>
                    </Table>
                    <Paginate :links="$page.props.customers.links" />
                </div><!-- col-12 -->
            </div><!-- row -->
        </Content>
    </template>
