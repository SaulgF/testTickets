<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm, usePage } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

import { Button } from '@/components/ui/button'
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card'
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogFooter } from '@/components/ui/dialog'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Textarea } from '@/components/ui/textarea'
import { Separator } from '@/components/ui/separator'

const page = usePage()

const showToast = ref(false)

const triggerToast = () => {
  showToast.value = true

  setTimeout(() => {
    showToast.value = false
  }, 3000)
}

const showDialog = ref(false)

const form = useForm({
  title: '',
  description: '',
  priority: 'low',
  image: null,
})

const handleFileChange = (e) => {
  form.image = e.target.files[0]
}

const submit = () => {
  form.post(route('tickets.store'), {
    forceFormData: true,
    preserveScroll: true,
    onSuccess: () => {
      showDialog.value = false
      form.reset()
      form.clearErrors()
      triggerToast()
    }
  })
}
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold">
          Dashboard
        </h2>

        <Button @click="showDialog = true">
          + Nuevo Ticket
        </Button>
      </div>
    </template>

    <div class="py-10 max-w-6xl mx-auto px-4">
      <Card>
        <CardHeader>
          <CardTitle>Mis Tickets</CardTitle>
        </CardHeader>
        <Separator />
        <CardContent class="pt-6 text-slate-500">
          Aquí aparecerán tus tickets.
        </CardContent>
      </Card>
    </div>

    <!-- DIALOG CREAR TICKET -->

    <Dialog v-model:open="showDialog">
      <DialogContent class="sm:max-w-lg">
        <DialogHeader>
          <DialogTitle>Crear Nuevo Ticket</DialogTitle>
        </DialogHeader>

        <form @submit.prevent="submit" class="space-y-5 py-4">

          <div class="space-y-2">
            <Label>Título</Label>
            <Input v-model="form.title" />
            <p v-if="form.errors.title" class="text-sm text-red-500">
              {{ form.errors.title }}
            </p>
          </div>

          <div class="space-y-2">
            <Label>Descripción</Label>
            <Textarea v-model="form.description" rows="4" />
            <p v-if="form.errors.description" class="text-sm text-red-500">
              {{ form.errors.description }}
            </p>
          </div>

          <div class="space-y-2">
            <Label>Prioridad</Label>
            <select
              v-model="form.priority"
              class="w-full h-10 rounded-md border border-slate-300 px-3
                     focus:ring-2 focus:ring-indigo-500 focus:outline-none"
            >
              <option value="low">🟢 Baja</option>
              <option value="medium">🟡 Media</option>
              <option value="high">🔴 Alta</option>
            </select>
          </div>

          <div class="space-y-2">
            <Label>Imagen (opcional)</Label>
            <Input type="file" @change="handleFileChange" />
          </div>

          <DialogFooter class="pt-4">
            <Button type="button" variant="outline" @click="showDialog = false">
              Cancelar
            </Button>

            <Button type="submit" :disabled="form.processing">
              Guardar Ticket
            </Button>
          </DialogFooter>

        </form>
      </DialogContent>
    </Dialog>
    <transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="opacity-0 translate-y-2"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 translate-y-2">
    <div v-if="showToast" class="fixed top-6 right-6 bg-white border border-slate-200 shadow-lg rounded-lg px-6 py-4 w-80">
        <div class="font-semibold text-green-600">
        Ticket creado correctamente
        </div>
        <div class="text-sm text-slate-500 mt-1">
        Tu incidencia fue registrada con éxito.
        </div>
    </div>
    </transition>
  </AuthenticatedLayout>
</template>