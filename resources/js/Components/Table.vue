<script setup>

import EyeIcon from '../Icons/EyeIcon';
import Button from './Button';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    // Array with name of headers of table
    table: Object,
    // Route Buttons
    buttons: {
        type: Object,
        default: {},
    }
})

</script>

<template>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th v-for="(header, index) in table.headers" :key="index" scope="col">{{ header }}</th>
                    <th></th>
                </tr>
            </thead><!-- table-dark -->
            <tbody>
                <tr v-for="(row, index) in table.rows" :key="index">
                    <td v-for="(col, index) in row" :key="index">{{ col }}</td>
                    <td>
                        <Link :href="route('errors.show', row.id)">
                            <Button type="button" color="primary" classes="btn-sm">
                                <EyeIcon size="15" />
                            </Button>
                        </Link>
                    </td>
                </tr>
            </tbody>
        </table><!-- table table-hover table-bordered -->
    </div><!-- table-responsive -->
</template>
