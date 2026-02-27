<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'

import { Card, CardHeader, CardTitle, CardContent, CardFooter } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Checkbox } from '@/components/ui/checkbox'

const form = useForm({
    email: '',
    password: '',
    remember: false,
})

const submit = () => {
    form.post(route('login'))
}
</script>

<template>
    <Head title="Login" />

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 via-white to-slate-100 px-4">

        <!-- Background glow effect -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-indigo-200 rounded-full blur-3xl opacity-30"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-200 rounded-full blur-3xl opacity-30"></div>

        <Card class="relative w-full max-w-md rounded-2xl shadow-xl border border-slate-200 bg-white">

            <CardHeader class="space-y-3 text-center">

                <!-- Logo -->
                <div class="flex justify-center">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
                        T
                    </div>
                </div>

                <CardTitle class="text-2xl font-semibold tracking-tight">
                    Sistema de Tickets
                </CardTitle>

                <p class="text-sm text-slate-500">
                    Inicia sesión para acceder al panel
                </p>
            </CardHeader>

            <CardContent>
                <form @submit.prevent="submit" class="space-y-5">

                    <!-- Email -->
                    <div class="space-y-2">
                        <Label for="email">Email</Label>
                        <Input
                            id="email"
                            type="email"
                            v-model="form.email"
                            placeholder="admin@test.com"
                            class="h-11"
                            required
                        />
                        <p v-if="form.errors.email" class="text-sm text-red-500">
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <Label for="password">Password</Label>
                        <Input
                            id="password"
                            type="password"
                            v-model="form.password"
                            placeholder="••••••••"
                            class="h-11"
                            required
                        />
                        <p v-if="form.errors.password" class="text-sm text-red-500">
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <!-- Remember -->
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center space-x-2">
                            <Checkbox
                                id="remember"
                                v-model:checked="form.remember"
                            />
                            <Label for="remember">Recordarme</Label>
                        </div>
                    </div>

                    <!-- Button -->
                    <Button
                        type="submit"
                        class="w-full h-11 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white shadow-md transition-all duration-200"
                        :disabled="form.processing"
                    >
                        Iniciar sesión
                    </Button>

                </form>
            </CardContent>

            <CardFooter class="justify-center text-xs text-slate-400">
                © 2026 Sistema de Tickets.
            </CardFooter>

        </Card>
    </div>
</template>