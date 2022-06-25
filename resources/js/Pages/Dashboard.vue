<script setup>

import DashboardIcon from '../Icons/DashboardIcon';
import MetricBox from '../Components/MetricBox';

</script>

<template>
    <div class="d-flex justify-content-around flex-wrap">
        <MetricBox bg="#4778B5" value="100" title="Texto de Titulo">
            <DashboardIcon />
        </MetricBox>

        <MetricBox bg="#000" value="100" title="Texto de Titulo">
            <DashboardIcon />
        </MetricBox>

        <MetricBox bg="#4778B5" value="100" title="Texto de Titulo">
            <DashboardIcon />
        </MetricBox>

        <MetricBox bg="#4778B5" value="100" title="Texto de Titulo">
            <DashboardIcon />
        </MetricBox>
    </div><!-- row -->
</template>
