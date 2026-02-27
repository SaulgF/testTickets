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

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 px-4">
<div class="absolute top-8 text-white text-2xl font-bold tracking-wide">
    TEST
</div>
        <Card class="w-full max-w-md shadow-2xl rounded-2xl border-0">

            <CardHeader class="space-y-2 text-center">
                <CardTitle class="text-2xl font-bold">
                    Sistema de Tickets
                </CardTitle>
                <p class="text-sm text-muted-foreground">
                    Inicia sesión para continuar
                </p>
            </CardHeader>

            <CardContent>
                <form @submit.prevent="submit" class="space-y-5">

                    <div class="space-y-2">
                        <Label for="email">Email</Label>
                        <Input
                            id="email"
                            type="email"
                            v-model="form.email"
                            required
                        />
                        <p v-if="form.errors.email" class="text-sm text-red-500">
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <div class="space-y-2">
                        <Label for="password">Password</Label>
                        <Input
                            id="password"
                            type="password"
                            v-model="form.password"
                            required
                        />
                        <p v-if="form.errors.password" class="text-sm text-red-500">
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center space-x-2">
                            <Checkbox
                                id="remember"
                                v-model:checked="form.remember"
                            />
                            <Label for="remember">Recordarme</Label>
                        </div>

                        <Link
                            v-if="$page.props.canResetPassword"
                            :href="route('password.request')"
                            class="text-indigo-500 hover:underline"
                        >
                            ¿Olvidaste tu contraseña?
                        </Link>
                    </div>

                    <Button
                        type="submit"
                        class="w-full"
                        :disabled="form.processing"
                    >
                        Iniciar sesión
                    </Button>

                </form>
            </CardContent>

            <CardFooter class="justify-center text-xs text-muted-foreground">
                © 2026 Sistema de Tickets
            </CardFooter>

        </Card>

    </div>
</template>