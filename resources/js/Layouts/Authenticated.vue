<script setup>

import UserBadgeIcon from '@/Icons/UserBadgeIcon';
import SecurityIcon from '@/Icons/SecurityIcon';
import ProjectIcon from '@/Icons/ProjectIcon';
import SettingIcon from '@/Icons/SettingIcon';
import ErrorIcon from '@/Icons/ErrorIcon';
import UsersIcon from '@/Icons/UsersIcon';
import FilesIcon from '@/Icons/FilesIcon';
import CallIcon from '@/Icons/CallIcon';
import UserIcon from '@/Icons/UserIcon';
import MenuIcon from '@/Icons/MenuIcon';
import ExitIcon from '@/Icons/ExitIcon';
import DashboardIcon from "@/Icons/DashboardIcon";
import { Link, usePage } from '@inertiajs/inertia-vue3'
import { onMounted, onUpdated } from 'vue';

onMounted(() => {
    if (window.innerWidth) {
        $('menu').addClass('close');
    }

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
            $('#menu').toggleClass("close");
        }
    }
}

</script>

<template>
    <div class="toast-container position-fixed top-0 end-0 p-3 z-index-3" style="z-index: 10000" id="toast-container">
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

                <Link :href="route('logs.index')">
                    <li id="logs">
                        <span></span>
                        <FilesIcon size="16" />
                        Logs
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
                <Link :href="route('users.index')">
                    <li id="users">
                        <span></span>
                        <UserBadgeIcon size="16" />
                        Usuarios
                    </li>
                </Link>
            </ul>
        </nav>
        <footer>
            <div class="user">
                <div class="img border border-light text-light">
                    <UserIcon v-if="$page.props.auth.user.image === null" size="20" />
                    <img v-if="$page.props.auth.user.image !== null" class="w-100" :src="route('storage', { filePath: $page.props.auth.user.image })">
                </div>
                <Link class="info text-light" :href="route('users.profile')">
                    <h4>{{ $page.props.auth.user.name }}</h4>
                    <h5 v-if="$page.props.auth.user.isAdmin == 1">Administrador</h5>
                </Link>
                <!-- <div class="btn-group dropup">
                    <div class="d-flex flex-wrap pt-2" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="img">
                            <div>

                            </div>
                        </div>
                        <div class="info">
                            <h4>{{ $page.props.auth.user.name }}</h4>
                            <h5>Administrador</h5>
                        </div>
                    </div>
                    <ul class="dropdown-menu p-0 overflow-hidden">
                        <li>
                            <a class="dropdown-item" href="#">Perfil</a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="#">No Idea</a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <a class="dropdown-item text-danger" href="#">Sair</a>
                        </li>
                    </ul>
                </div> -->
            </div>
            <div class="icon">
                <Link :href="route('logout')"  method="post" class="text-light border-0 bg-transparent" as="button">
                    <ExitIcon size="23" />
                </Link>
            </div>
        </footer>
    </aside>
    <main>
        <slot></slot>
    </main>
</template>
