<script setup>

import SecurityIcon from '@/Icons/SecurityIcon';
import ProjectIcon from '@/Icons/ProjectIcon';
import SettingIcon from '@/Icons/SettingIcon';
import ErrorIcon from '@/Icons/ErrorIcon';
import CallIcon from '@/Icons/CallIcon';
import UsersIcon from '@/Icons/UsersIcon';
import MenuIcon from '@/Icons/MenuIcon';
import ExitIcon from '@/Icons/ExitIcon';
import DashboardIcon from "@/Icons/DashboardIcon";
import { Link } from '@inertiajs/inertia-vue3'
import { onMounted, onUpdated } from 'vue';

onMounted(() => {
    const currentMenu = route().current().split('.')[0];
    $(`#${currentMenu}`).addClass('active');
})

onUpdated(() => {
    const currentMenu = route().current().split('.')[0];
    $('#menu .active').removeClass('active');
    $(`#${currentMenu}`).addClass('active');
})

</script>

<script>
export default {
    methods: {
        menuToggle() {
            if (this.$store.state.menuOpen) {
                $('#menu nav').css('opacity', '0');
                $('#menu').css('left', '-180px');
            } else {
                $('#menu nav').css('opacity', '1');
                $('#menu').css('left', '0');
            }
            this.$store.dispatch('switchMenuState')
        }
    }
}
</script>

<template>
    <aside id="menu">
        <header class="top">
            <h1>Consulting</h1>
            <MenuIcon size="35" classes="menu-icon" @click="menuToggle" />
        </header>
        <nav>
            <ul>
                <Link :href="route('dashboard')">
                    <li id="dashboard">
                        <span></span>
                        <DashboardIcon size="16" />
                        Dashboard
                    </li>
                </Link>

                <Link :href="route('attacks.index')">
                    <li id="attacks">
                        <span></span>
                        <SecurityIcon size="16" />
                        Ataques
                    </li>
                </Link>

                <Link :href="route('errors.index')">
                    <li id="errors">
                        <span></span>
                        <ErrorIcon size="16" />
                        Erros
                    </li>
                </Link>
                <Link :href="route('calls.index')">
                    <li id="calls">
                        <span></span>
                        <CallIcon size="16" />
                        Chamados
                    </li>
                </Link>
                <Link :href="route('projects.index')">
                    <li id="projects">
                        <span></span>
                        <ProjectIcon size="16" />
                        Projetos
                    </li>
                </Link>
                <Link :href="route('customers.index')">
                    <li id="customers">
                        <span></span>
                        <UsersIcon size="16" />
                        Clientes
                    </li>
                </Link>
            </ul>
        </nav>

        <footer>
            <div class="user">
                <div class="img">
                    <div>

                    </div>
                </div>
                <div class="info">
                    <h4>{{ $page.props.auth.user.name }}</h4>
                    <h5>Administrador</h5>
                </div>
            </div>
            <div class="icon">
                <Link :href="route('logout')"  method="post" class="text-light">
                    <ExitIcon size="23" />
                </Link>
            </div>
        </footer>
    </aside>
    <main>
        <slot></slot>
    </main>
</template>
