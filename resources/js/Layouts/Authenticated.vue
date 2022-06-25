<script setup>

import MenuIcon from '../Icons/MenuIcon';
import ExitIcon from '../Icons/ExitIcon';
import SecurityIcon from '../Icons/SecurityIcon';
import SettingIcon from '../Icons/SettingIcon';
import ErrorIcon from '../Icons/ErrorIcon';
import CallIcon from '../Icons/CallIcon';
import { onMounted } from 'vue';
import DashboardIcon from "@/Icons/DashboardIcon";
import { Link } from '@inertiajs/inertia-vue3'

function switchProject(event) {
    $('.active').removeClass('active');
    event.target.classList.add('active');
}

onMounted(() => {
    const currentMenu = route().current().split('.')[0];
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
                    <li id="dashboard" @click="switchProject($event)">
                        <span></span>
                        <DashboardIcon size="16" />
                        Dashboard
                    </li>
                </Link>

                <li id="atack" @click="switchProject($event)">
                    <span></span>
                    <SecurityIcon size="16" />
                    Ataques
                </li>

                <Link :href="route('errors.index')">
                    <li id="errors" @click="switchProject($event)">
                        <span></span>
                        <ErrorIcon size="16" />
                        Erros
                    </li>
                </Link>
                <li id="call" @click="switchProject($event)">
                    <span></span>
                    <CallIcon size="16" />
                    Chamados
                </li>
                <li id="setting" @click="switchProject($event)">
                    <span></span>
                    <SettingIcon size="16" />
                    Configurações
                </li>
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
                <Link :href="route('logout')"  method="post" as="button" class="bg-none">
                    <ExitIcon size="23" />
                </Link>
            </div>
        </footer>
    </aside>
    <main>
        <slot></slot>
    </main>
</template>
