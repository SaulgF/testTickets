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
import { useToast } from '@/composables/useToast'

const page = usePage()
const { toast } = useToast()
const showToast = ref(false)

const triggerToast = () => {
  showToast.value = true

  setTimeout(() => {
    showToast.value = false
  }, 3000)
}

const props = defineProps({
  tickets: {
    type: Array,
    default: () => [],
  },
})

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

      toast({
        type: 'success',
        title: 'Ticket creado',
        message: 'La incidencia fue registrada correctamente.',
      })
    },
    onError: () => {
      toast({
        type: 'error',
        title: 'Error',
        message: 'Revisa los campos del formulario.',
      })
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
        <CardContent class="pt-6">
            <div v-if="!props.tickets.length" class="text-slate-500">
                No tienes tickets aún.
            </div>

            <div v-else class="grid gap-4">
                <div
                v-for="ticket in props.tickets"
                :key="ticket.id"
                class="border rounded-lg p-4 bg-white shadow-sm"
                >
                <div class="flex justify-between items-start">
                    <div>
                    <h3 class="font-semibold text-lg">
                        {{ ticket.title }}
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        {{ ticket.description }}
                    </p>
                    </div>

                    <div class="flex flex-col items-end gap-2">
                    <span
                        class="px-2 py-1 text-xs rounded-full"
                        :class="{
                        'bg-green-100 text-green-700': ticket.priority === 'low',
                        'bg-yellow-100 text-yellow-700': ticket.priority === 'medium',
                        'bg-red-100 text-red-700': ticket.priority === 'high',
                        }">
                        {{ ticket.priority }}
                    </span>

                    <span
                        class="px-2 py-1 text-xs rounded-full"
                        :class="{
                        'bg-blue-100 text-blue-700': ticket.status === 'open',
                        'bg-gray-200 text-gray-700': ticket.status === 'closed',
                        }">
                        {{ ticket.status }}
                    </span>
                    </div>
                </div>

                <div v-if="ticket.image_path" class="mt-3">
                    <img
                    :src="`/storage/${ticket.image_path}`"
                    class="w-32 h-20 object-cover rounded-md border"/>
                </div>
                </div>
            </div>
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