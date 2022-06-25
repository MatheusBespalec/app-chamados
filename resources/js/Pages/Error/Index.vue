<script setup>
import Table from '../../Components/Table';
import { Link, usePage } from '@inertiajs/inertia-vue3';

const table = {
    headers: ['ID', 'Código', 'Arquivo', 'Linha', 'Mensagem', 'Status', 'Ultima Ocorrência'],
    rows: usePage().props.value.errors.map(error => {
        const {
            id,
            code,
            file,
            line,
            message,
            status,
            updated_at
        } = error;
        return {
            id,
            code,
            file,
            line,
            message,
            status,
            updated_at
        }
    })
}

</script>

<template>
    <div class="content">
        <div class="row">
            <div class="col-12">
                <Table :table="table" />
            </div>
        </div><!-- com-md-12 -->
    </div>
</template>
