<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { initFlowbite } from 'flowbite'
import { onMounted } from 'vue'

onMounted(() => {
    initFlowbite()
})

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>

        <Head :title="title" />

        <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <div class="px-3 py-3 lg:px-5 lg:pl-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-start">
                        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                            aria-controls="logo-sidebar" type="button"
                            class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                            <span class="sr-only">Open sidebar</span>
                            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                                </path>
                            </svg>
                        </button>
                        <Link href="/dashboard" class="flex ml-2 md:mr-24"> 
                            <!-- <img src="images/RSAC-logos_black.png" class="h-8 mr-3" alt="Logo Reportes SAC" /> -->
                            <span class="text-xl font-bold text-gray-800 dark:text-white">Reportes SAC</span>
                        </Link>
                    </div>
                    <div class="flex items-center">
                        <div class="flex items-center ml-3">
                            <div>
                                <button type="button"
                                    class=""
                                    aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                    <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                                <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                            </div>
                                </button>
                            </div>
                            <div class="z-50 hidden  text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                                id="dropdown-user">
                                <div class="px-4 py-3" role="none">
                                    <p class="text-sm text-gray-900 dark:text-white" role="none">
                                        {{$page.props.auth.user.name}}
                                    </p>
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                        {{$page.props.auth.user.email}}
                                    </p>
                                </div>
                                <ul class="py-1" role="none">
                                    <li>
                                        <Link :href="route('profile.show')"
                                            class="w-full block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                            role="menuitem">Perfil</Link>
                                    </li>
                                    <li>
                                        <form @submit.prevent="logout">
                                            <button type="submit"
                                                class="w-full text-start block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                                role="menuitem">
                                                Cerrar Sesión
                                            </button>
                                    </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <aside id="logo-sidebar"
            class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
            aria-label="Sidebar">
            <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
                <ul class="space-y-2 font-medium">

                    <li>
                        <Link :href="route('dashboard')"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="currentColor" d="M6 21q-.825 0-1.413-.588T4 19v-9q0-.475.213-.9t.587-.7l6-4.5q.275-.2.575-.3T12 3.5q.325 0 .625.1t.575.3l6 4.5q.375.275.588.7T20 10v9q0 .825-.588 1.413T18 21h-4v-7h-4v7H6Z"/></svg>
                            <span class="ml-3">Inicio</span>
                        </Link>
                    </li>

                    <li v-if="is('Resumen | Administrador | Rector | SecretarioAcademico')">
                        <Link :href="route('resumen')"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10s10-4.5 10-10S17.5 2 12 2zm-1 17.94c-3.93-.5-7-3.88-7-7.94s3.07-7.44 7-7.93v15.87zm2-.01V13h6.93A8.002 8.002 0 0 1 13 19.93zM13 11V4.07c3.61.45 6.48 3.33 6.93 6.93H13z"/></svg>
                            <span class="ml-3">Resumen</span>
                        </Link>
                    </li>

                    <li v-if="is('Automotriz | Administrador | Rector | SecretarioAcademico')">
                        <Link :href="route('view.autromotriz')"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="currentColor" d="M3 17V8l2.45-7h13.1L21 8v9h-3v-2H6v2H3ZM5.8 6h12.4l-1.05-3H6.85L5.8 6ZM5 8v5v-5Zm2.5 4q.625 0 1.063-.438T9 10.5q0-.625-.438-1.063T7.5 9q-.625 0-1.063.438T6 10.5q0 .625.438 1.063T7.5 12Zm9 0q.625 0 1.063-.438T18 10.5q0-.625-.438-1.063T16.5 9q-.625 0-1.063.438T15 10.5q0 .625.438 1.063T16.5 12ZM13 23l-6-3h4v-2l6 3h-4v2ZM5 13h14V8H5v5Z"/></svg>
                            <span class="flex-1 ml-3 whitespace-nowrap">Automotriz</span>
                        </Link>
                    </li>
                    
                    <li v-if="is('Manufactura | Administrador | Rector | SecretarioAcademico')">
                        <Link :href="route('view.manufactura')"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="currentColor" d="M19.43 12.98c.04-.32.07-.64.07-.98c0-.34-.03-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46a.5.5 0 0 0-.61-.22l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65A.488.488 0 0 0 14 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61.25-1.17.59-1.69.98l-2.49-1a.566.566 0 0 0-.18-.03c-.17 0-.34.09-.43.25l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.07.65-.07.98c0 .33.03.66.07.98l-2.11 1.65c-.19.15-.24.42-.12.64l2 3.46a.5.5 0 0 0 .61.22l2.49-1c.52.4 1.08.73 1.69.98l.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.59 1.69-.98l2.49 1c.06.02.12.03.18.03c.17 0 .34-.09.43-.25l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.65zm-1.98-1.71c.04.31.05.52.05.73c0 .21-.02.43-.05.73l-.14 1.13l.89.7l1.08.84l-.7 1.21l-1.27-.51l-1.04-.42l-.9.68c-.43.32-.84.56-1.25.73l-1.06.43l-.16 1.13l-.2 1.35h-1.4l-.19-1.35l-.16-1.13l-1.06-.43c-.43-.18-.83-.41-1.23-.71l-.91-.7l-1.06.43l-1.27.51l-.7-1.21l1.08-.84l.89-.7l-.14-1.13c-.03-.31-.05-.54-.05-.74s.02-.43.05-.73l.14-1.13l-.89-.7l-1.08-.84l.7-1.21l1.27.51l1.04.42l.9-.68c.43-.32.84-.56 1.25-.73l1.06-.43l.16-1.13l.2-1.35h1.39l.19 1.35l.16 1.13l1.06.43c.43.18.83.41 1.23.71l.91.7l1.06-.43l1.27-.51l.7 1.21l-1.07.85l-.89.7l.14 1.13zM12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4s4-1.79 4-4s-1.79-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2s2 .9 2 2s-.9 2-2 2z"/></svg>
                            <span class="flex-1 ml-3 whitespace-nowrap">Manufactura</span>
                            <!-- <span
                                class="inline-flex items-center justify-center w-3 h-3 p-3 ml-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">3</span> -->
                        </Link>
                    </li>

                    <li v-if="is('Redes |Administrador | Rector | SecretarioAcademico')">
                        <Link :href="route('view.redes')"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><rect width="7" height="5" rx=".6" transform="matrix(1 0 0 -1 3 22)"/><rect width="7" height="5" rx=".6" transform="matrix(1 0 0 -1 8.5 7)"/><rect width="7" height="5" rx=".6" transform="matrix(1 0 0 -1 14 22)"/><path d="M6.5 17v-3.5a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2V17M12 11.5V7"/></g></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Redes</span>
                    </Link>
                </li>

                <li v-if="is('LAGE |Administrador | Rector | SecretarioAcademico')">
                    <Link :href="route('view.lage')"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="currentColor" d="M20 6c.58 0 1.05.2 1.42.59c.38.41.58.86.58 1.41v11c0 .55-.2 1-.58 1.41c-.37.39-.84.59-1.42.59H4c-.58 0-1.05-.2-1.42-.59C2.2 20 2 19.55 2 19V8c0-.55.2-1 .58-1.41C2.95 6.2 3.42 6 4 6h4V4c0-.58.2-1.05.58-1.42C8.95 2.2 9.42 2 10 2h4c.58 0 1.05.2 1.42.58c.38.37.58.84.58 1.42v2h4M4 8v11h16V8H4m10-2V4h-4v2h4m-3.54 11.5l6.59-6.59l-1.41-1.41l-5.18 5.17l-2.09-2.08L6.96 14l3.5 3.5Z"/></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">LAGE</span>
                    </Link>
                </li>

                <li v-if="is('Mecatronica |Administrador | Rector | SecretarioAcademico')">
                    <Link :href="route('view.mecatronica')"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                      <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 512 512"><path fill="currentColor" d="M324.563 39.156a17.073 17.073 0 0 0-3.438.407c-9.223 2.097-15.004 11.275-12.906 20.5c.006.032.022.06.03.093l-22.813 28.188l-3.25 4l1.688 4.906l13.906 40.563l-142.655 24.03c12.343 10.045 19.98 25.555 19.28 42.595a51.943 51.943 0 0 1-1.5 10.437l130.532-53.438l-.125-.968c5.93 7.795 15.912 12.005 26.375 10.124c14.91-2.68 24.684-16.683 22.063-31.5c-2.294-12.967-13.248-22.02-25.938-22.28c-1.812-.04-3.636.1-5.5.436c-3.173.57-6.11 1.66-8.75 3.156l-8.343-24.344l18.592-22.968c2.22.41 4.566.407 6.907-.125c9.223-2.1 15.003-11.277 12.905-20.5c-1.835-8.07-9.098-13.487-17.063-13.314zm115 29.032c-1.277.04-2.56.218-3.844.562a17.05 17.05 0 0 0-9.814 7.063l-38.687-6.126l-3.97-.624l-3.188 2.437l-38.656 29.688a46.243 46.243 0 0 1 16.53 10.874l30.314-23.28l37.656 5.968c3.954 5.975 11.386 9.05 18.688 7.094c9.138-2.45 14.542-11.83 12.094-20.97c-1.99-7.422-8.55-12.396-15.844-12.686c-.42-.017-.856-.014-1.28 0zm-39.188 57.906l-1.875.125l-30.375 2.093a45.086 45.086 0 0 1 2.625 18.562L397.938 145l28.03 9.5c.094.592.186 1.19.344 1.78c2.45 9.14 11.863 14.575 21 12.126c9.138-2.448 14.543-11.862 12.094-21c-2.448-9.136-11.832-14.54-20.97-12.094a17.134 17.134 0 0 0-4.717 2.063l-31.564-10.688l-1.78-.593zm-34.563 38.5a46.513 46.513 0 0 1-11.937 14.78l42.594 23.564a17.133 17.133 0 0 0 .56 5.53c2.45 9.14 11.832 14.574 20.97 12.126c9.138-2.45 14.542-11.862 12.094-21c-2.448-9.136-11.833-14.542-20.97-12.094c-.408.11-.793.238-1.187.375l-42.125-23.28zm-244.125 4.187c-15.272.178-28.172 10.388-32.156 24.532l63.626-4.125c-4.89-11.59-16.144-19.853-29.72-20.375a35.305 35.305 0 0 0-1.75-.03zm33.626 39l-65.688 4.282c3.957 13.412 16.086 23.334 31 23.907c17.34.664 31.975-11.602 34.688-28.19zm8.53 26c-10.032 13.228-26.167 21.558-43.937 20.876a51.663 51.663 0 0 1-3.312-.22l53.47 84.19c8.282-19.396 26.015-33.782 47.155-37.532l-53.376-67.313zm63.813 85.064c-23.575.275-42.9 18.79-43.875 42.5a44.1 44.1 0 0 0 3.5 19.187l71.907-49.217c-7.55-7.335-17.78-11.998-29.25-12.438c-.768-.03-1.52-.04-2.28-.03zm41.844 28.03l-71.375 48.876c7.424 6.734 17.208 10.987 28.125 11.406c24.605.945 45.182-17.993 46.188-42.47c.258-6.297-.803-12.316-2.938-17.81zm-86.406 60.188l-7.47 43.438H280l-9.03-41.563c-11.892 11.045-27.98 17.576-45.408 16.907c-16.657-.64-31.6-7.736-42.468-18.78zm-38.53 62.125v24.75h169.374v-24.75H144.563z"/></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Mecatrónica</span>
                    </Link>
                </li>

                <li v-if="is('Negocios |Administrador | Rector | SecretarioAcademico')">
                    <Link :href="route('view.negocios')"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 32 32"><path fill="currentColor" d="M16 28a5.326 5.326 0 0 1-.671-.044A21.785 21.785 0 0 1 12.033 17H29.95c.024-.332.05-.663.05-1a14 14 0 1 0-14 14Zm11.95-13h-5.987A24.325 24.325 0 0 0 19.21 4.45A12.012 12.012 0 0 1 27.95 15ZM16.67 4.044A21.785 21.785 0 0 1 19.967 15h-7.934A21.785 21.785 0 0 1 15.33 4.044a5.159 5.159 0 0 1 1.342 0Zm-3.881.405A24.328 24.328 0 0 0 10.037 15H4.05a12.013 12.013 0 0 1 8.74-10.55ZM4.05 17h5.987a24.328 24.328 0 0 0 2.753 10.55A12.013 12.013 0 0 1 4.05 17Z"/><path fill="currentColor" fill-rule="evenodd" d="m25 25l5 2v-2l-5-2.5V20a1 1 0 0 0-2 0v2.5L18 25v2l5-2v3.5L21 30v1l3-1l3 1v-1l-2-1.5Z"/></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Negocios I.</span>
                    </Link>
                </li>

                <li v-if="is('Posgrado |Administrador | Rector | SecretarioAcademico')">
                    <Link :href="route('view.posgrado')"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 256 256"><path fill="currentColor" d="M248 128a56 56 0 1 0-96 39.14V224a8 8 0 0 0 11.58 7.16L192 216.94l28.42 14.22A8 8 0 0 0 232 224v-56.86A55.81 55.81 0 0 0 248 128Zm-56-40a40 40 0 1 1-40 40a40 40 0 0 1 40-40Zm3.58 112.84a8 8 0 0 0-7.16 0L168 211.06v-32.47a55.94 55.94 0 0 0 48 0v32.47ZM136 192a8 8 0 0 1-8 8H40a16 16 0 0 1-16-16V56a16 16 0 0 1 16-16h176a16 16 0 0 1 16 16a8 8 0 0 1-16 0H40v128h88a8 8 0 0 1 8 8Zm-16-56a8 8 0 0 1-8 8H72a8 8 0 0 1 0-16h40a8 8 0 0 1 8 8Zm0-32a8 8 0 0 1-8 8H72a8 8 0 0 1 0-16h40a8 8 0 0 1 8 8Z"/></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Posgrado</span>
                    </Link>
                </li>

                <li v-if="is('Sistemas |Administrador | Rector | SecretarioAcademico')">
                    <Link :href="route('view.sistemas')"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="currentColor" d="m20 18l2-2V4H2v12l2 2H0v2h24v-2h-4zM4 6h16v10H4V6z"/></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Sistemas C.</span>
                    </Link>
                </li>

                <li v-if="is('Coordinacion |Administrador | Rector | SecretarioAcademico')">
                    <Link :href="route('view.coordinacion')"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 256 256"><g fill="currentColor"><path d="M192 80v96h-88a32 32 0 1 0-32-32h-8V80Z" opacity=".2"/><path d="M216 40H40a16 16 0 0 0-16 16v144a16 16 0 0 0 16 16h13.39a8 8 0 0 0 7.23-4.57a48 48 0 0 1 86.76 0a8 8 0 0 0 7.23 4.57H216a16 16 0 0 0 16-16V56a16 16 0 0 0-16-16ZM80 144a24 24 0 1 1 24 24a24 24 0 0 1-24-24Zm136 56h-56.57a64.39 64.39 0 0 0-28.83-26.16a40 40 0 1 0-53.2 0A64.39 64.39 0 0 0 48.57 200H40V56h176ZM56 96V80a8 8 0 0 1 8-8h128a8 8 0 0 1 8 8v96a8 8 0 0 1-8 8h-16a8 8 0 0 1 0-16h8V88H72v8a8 8 0 0 1-16 0Z"/></g></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Coor. Académica</span>
                    </Link>
                </li>

                <li v-if="is('Administrador | SecretarioAcademico')">
                    <Link :href="route('view.administracion')"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path id="eosIconsAdmin0" fill="currentColor" d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12c5.16-1.26 9-6.45 9-12V5Zm0 3.9a3 3 0 1 1-3 3a3 3 0 0 1 3-3Zm0 7.9c2 0 6 1.09 6 3.08a7.2 7.2 0 0 1-12 0c0-1.99 4-3.08 6-3.08Z"/></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Administración</span>
                    </Link>
                </li>
            </ul>
        </div>
    </aside>

    <div class="sm:ml-64">
        <!-- Page Heading -->
        <header v-if="$slots.header" class="bg-white shadow">
            <div class="mx-auto mt-[70px]  p-4 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>
        <!-- Page Content -->
        <main>
            <slot />
        </main>
    </div>






</div></template>
