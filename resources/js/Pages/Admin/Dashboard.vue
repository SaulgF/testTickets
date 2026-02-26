<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const user = computed(() => usePage().props.auth.user);
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Welcome Card -->
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"
                >
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">
                        Panel Administrativo de Tickets y Reportes Técnicos
                    </h3>

                    <p class="text-gray-600">
                        Aquí puedes visualizar y administrar todos los tickets
                        del sistema.
                    </p>
                </div>

                <!-- Stats Section (Placeholder) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <p class="text-sm text-gray-500">Tickets Abiertos</p>
                        <p class="text-2xl font-bold text-blue-600">0</p>
                    </div>

                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <p class="text-sm text-gray-500">Tickets Cerrados</p>
                        <p class="text-2xl font-bold text-green-600">0</p>
                    </div>

                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <p class="text-sm text-gray-500">Prioridad Alta</p>
                        <p class="text-2xl font-bold text-red-600">0</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
