<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm, usePage, router } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'

import { Button } from '@/components/ui/button'
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card'
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogFooter } from '@/components/ui/dialog'
import { Badge } from '@/components/ui/badge'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Textarea } from '@/components/ui/textarea'
import { Separator } from '@/components/ui/separator'
import { useToast } from '@/composables/useToast'



const showConfirmDialog = ref(false)
const selectedTicketId = ref(null)

const page = usePage()

const props = defineProps({
  tickets: {
    type: Array,
    default: () => [],
  },
})

const statusFilter = ref(page.props.filters?.status || 'all')

const { toast } = useToast()
const showToast = ref(false)

const triggerToast = () => {
  showToast.value = true

  setTimeout(() => {
    showToast.value = false
  }, 3000)
}

const applyFilter = (status) => {
  statusFilter.value = status

  router.get(
    route('dashboard'),
    { status },
    {
      preserveState: true,
      replace: true,
    }
  )
}

const totalCount = computed(() => props.tickets.length)

const openCount = computed(() =>
  props.tickets.filter(t => t.status === 'open').length
)

const closedCount = computed(() =>
  props.tickets.filter(t => t.status === 'closed').length
)

const highPriorityCount = computed(() =>
  props.tickets.filter(t => t.priority === 'high').length
)

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

const confirmClose = (id) => {
  selectedTicketId.value = id
  showConfirmDialog.value = true
}

const executeClose = () => {
  router.patch(route('tickets.close', selectedTicketId.value), {}, {
    preserveScroll: true,
    onSuccess: () => {
      showConfirmDialog.value = false
      selectedTicketId.value = null

      toast({
        type: 'success',
        title: 'Ticket cerrado',
        message: 'El ticket fue cerrado correctamente.',
      })
    }
  })
}

const showImagePreview = ref(false)
const selectedImage = ref(null)

const previewImage = (path) => {
  selectedImage.value = `/storage/${path}`
  showImagePreview.value = true
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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 m-6 p-4">
            <!-- Total -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
                <p class="text-xs text-slate-500 uppercase">Total</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">
                {{ totalCount }}
                </p>
            </div>

            <!-- Abiertos -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 shadow-sm">
                <p class="text-xs text-blue-600 uppercase">Abiertos</p>
                <p class="text-2xl font-bold text-blue-700 mt-1">
                {{ openCount }}
                </p>
            </div>

            <!-- Cerrados -->
            <div class="bg-gray-100 border border-gray-300 rounded-xl p-4 shadow-sm">
                <p class="text-xs text-gray-600 uppercase">Cerrados</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">
                {{ closedCount }}
                </p>
            </div>

            <!-- Alta prioridad -->
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 shadow-sm">
                <p class="text-xs text-red-600 uppercase">Alta prioridad</p>
                <p class="text-2xl font-bold text-red-700 mt-1">
                {{ highPriorityCount }}
                </p>
            </div>

        </div>
        <CardHeader>
          <CardTitle>Mis Tickets</CardTitle>
        </CardHeader>
        <Separator />
        <CardContent class="pt-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex gap-3">
                    <Button
                    size="sm"
                    :variant="statusFilter === 'all' ? 'default' : 'outline'"
                    @click="applyFilter('all')">
                    Todos ({{ props.tickets.length }})
                    </Button>

                    <Button
                    size="sm"
                    :variant="statusFilter === 'open' ? 'default' : 'outline'"
                     @click="applyFilter('open')">
                    Abiertos ({{ openCount }})
                    </Button>

                    <Button
                    size="sm"
                    :variant="statusFilter === 'closed' ? 'default' : 'outline'"
                    @click="applyFilter('closed')">
                    Cerrados ({{ closedCount }})
                    </Button>
                </div>

                </div>
            <div v-if="!props.tickets.length" class="text-slate-500">
                No tienes tickets aún.
            </div>
            <transition-group name="fade-slide" tag="div" class="grid gap-4">
                <div
                    v-for="ticket in props.tickets"
                    :key="ticket.id"
                    class="group bg-white border border-slate-200 rounded-xl p-5 transition-all duration-200 hover:shadow-md hover:border-slate-300"
                    >
                    <!-- Header -->
                    <div class="flex justify-between items-start gap-4">
                        <div>
                        <h3 class="text-lg font-semibold text-slate-800 group-hover:text-indigo-600 transition">
                            {{ ticket.title }}
                        </h3>
                        <p class="text-sm text-slate-500 mt-1 line-clamp-2">
                            {{ ticket.description }}
                        </p>
                        <small class="text-xs text-slate-400 mt-1">
                            {{ ticket.user.name }}
                        </small>
                        </div>

                        <!-- Badges -->
                        <div class="flex flex-col items-end gap-2">
                        <!-- PRIORIDAD -->
                        <span
                            class="px-3 py-1 text-xs font-medium rounded-full flex items-center gap-2"
                            :class="{
                            'bg-green-100 text-green-700': ticket.priority === 'low',
                            'bg-yellow-100 text-yellow-800': ticket.priority === 'medium',
                            'bg-red-100 text-red-700': ticket.priority === 'high',
                            }"
                        >
                            <span
                            class="w-2 h-2 rounded-full"
                            :class="{
                                'bg-green-500': ticket.priority === 'low',
                                'bg-yellow-500': ticket.priority === 'medium',
                                'bg-red-500': ticket.priority === 'high',
                            }"
                            ></span>
                            {{ ticket.priority }}
                        </span>

                        <!-- STATUS -->
                        <span
                            class="px-3 py-1 text-xs font-medium rounded-full"
                            :class="{
                            'bg-blue-100 text-blue-700': ticket.status === 'open',
                            'bg-gray-200 text-gray-700': ticket.status === 'closed',
                            }"
                        >
                            {{ ticket.status }}
                        </span>
                        </div>
                    </div>

                    <!-- Imagen -->
                    <div v-if="ticket.image_path" class="mt-4">
                        <img
                        :src="`/storage/${ticket.image_path}`"
                        class="w-full max-h-48 object-cover rounded-lg border cursor-pointer hover:opacity-90 transition"
                        @click="previewImage(ticket.image_path)"
                        />
                    </div>

                    <!-- Footer -->
                    <div class="mt-4 flex justify-between items-center text-xs text-slate-400">
                        <div>
                        {{ new Date(ticket.created_at).toLocaleDateString() }}
                        </div>

                        <div v-if="$page.props.auth.user.role === 'admin' && ticket.status === 'open'">
                        <Button
                            size="sm"
                            class="bg-red-600 hover:bg-red-700 text-white shadow-sm transition"
                            @click="confirmClose(ticket.id)">
                            Cerrar Ticket
                            </Button>
                        </div>
                    </div>
                </div>
            </transition-group>
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
    <Dialog v-model:open="showConfirmDialog">
        <DialogContent class="sm:max-w-md">
            <DialogHeader>
            <DialogTitle>
                Confirmar cierre
            </DialogTitle>
            </DialogHeader>

            <div class="py-4 text-sm text-slate-600">
            ¿Estás seguro que deseas cerrar este ticket?
            <br />
            <span class="text-red-500 font-medium">
                Esta acción no se puede deshacer.
            </span>
            </div>

            <DialogFooter class="flex justify-end gap-3">
            <Button
                variant="outline"
                @click="showConfirmDialog = false"
            >
                Cancelar
            </Button>

            <Button
                class="bg-red-600 hover:bg-red-700 text-white"
                @click="executeClose"
            >
                Confirmar cierre
            </Button>
            </DialogFooter>
        </DialogContent>
        </Dialog>
        <Dialog v-model:open="showImagePreview">
            <DialogContent class="max-w-3xl">
                <img
                :src="selectedImage"
                class="w-full rounded-lg"
                />
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
<style scoped>
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.25s ease;
}

.fade-slide-enter-from {
  opacity: 0;
  transform: translateY(8px);
}

.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(-8px);
}
</style>