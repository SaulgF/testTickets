<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'

const user = computed(() => usePage().props.auth.user)
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold">
                Dashboard
            </h2>
        </template>

        <div class="py-10 max-w-7xl mx-auto space-y-6">

            <!-- Welcome Card -->
            <Card>
                <CardHeader>
                    <CardTitle>
                        Bienvenido, {{ user.name }}
                    </CardTitle>
                </CardHeader>

                <CardContent class="space-y-4">
                    <p class="text-muted-foreground">
                        Aquí puedes gestionar tus tickets y revisar su estado.
                    </p>

                    <Badge variant="secondary">
                        Rol: Usuario
                    </Badge>

                    <div>
                        <Button>
                            Crear Nuevo Ticket
                        </Button>
                    </div>
                </CardContent>
            </Card>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <Card>
                    <CardHeader>
                        <CardTitle>Tickets Abiertos</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-3xl font-bold">0</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>Tickets Cerrados</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-3xl font-bold">0</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle>Alta Prioridad</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-3xl font-bold">0</p>
                    </CardContent>
                </Card>

            </div>

        </div>
    </AuthenticatedLayout>
</template>