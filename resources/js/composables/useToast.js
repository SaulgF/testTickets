import { ref } from 'vue'

const show = ref(false)
const type = ref('success')
const title = ref('')
const message = ref('')

export function useToast() {
  const toast = (options) => {
    type.value = options.type || 'success'
    title.value = options.title || ''
    message.value = options.message || ''

    show.value = true

    setTimeout(() => {
      show.value = false
    }, 3500)
  }

  return {
    show,
    type,
    title,
    message,
    toast,
  }
}