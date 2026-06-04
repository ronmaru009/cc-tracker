<template>

  <div class="form-container">

    <input v-model="form.name" placeholder="Debt Name" />

    <input
      v-model="form.balance"
      type="number"
      placeholder="Balance"
    />

    <input
      v-model="form.minimum_payment"
      type="number"
      placeholder="Minimum Payment"
    />

    <input
      v-model="form.interest_rate"
      type="number"
      placeholder="Interest Rate"
    />

    <button @click="submitForm">
      {{ editingId ? 'Update Debt' : 'Add Debt' }}
    </button>

  </div>

</template>

<script setup>
import { ref, watch } from 'vue'
import { useDebtStore } from '../stores/debtStore'

const props = defineProps({
  editingDebt: Object
})

const debtStore = useDebtStore()

const editingId = ref(null)

const form = ref({
  name: '',
  balance: '',
  minimum_payment: '',
  interest_rate: ''
})

const emit = defineEmits(['saved'])

watch(
  () => props.editingDebt,
  (debt) => {

    if (debt) {

      editingId.value = debt.id

      form.value = {
        name: debt.name,
        balance: debt.balance,
        minimum_payment: debt.minimum_payment,
        interest_rate: debt.interest_rate
      }

    }

  },
  { immediate: true }
)

async function submitForm() {

  if (editingId.value) {

    await debtStore.updateDebt(editingId.value, form.value)

  } else {

    await debtStore.createDebt(form.value)

  }

  form.value = {
    name: '',
    balance: '',
    minimum_payment: '',
    interest_rate: ''
  }

  editingId.value = null
  emit('saved')
}
</script>

<style scoped>
.form-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 20px;
}
</style>