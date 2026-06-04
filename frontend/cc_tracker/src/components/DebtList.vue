<template>

  <button @click="openAddModal">
    + Add Debt
  </button>

  <BaseModal
    v-if="showFormModal"
    @close="closeFormModal"
  >

    <DebtForm
      :editingDebt="editingDebt"
      @saved="closeFormModal"
    />

  </BaseModal>

<ConfirmModal
  v-if="showDeleteModal"
  @confirm="confirmDelete"
  @cancel="showDeleteModal = false"
/>

  <div class="debt-grid">

    <DebtCard
      v-for="debt in debtStore.snowballDebts"
      :key="debt.id"
      :debt="debt"
      :isNextToPay="
        debtStore.snowballDebts.length &&
        debt.id === debtStore.snowballDebts[0].id
      "
      @edit="startEdit"
      @delete="askDelete"
    />

  </div>

</template>

<script setup>
import { ref } from 'vue'
import { useDebtStore } from '../stores/debtStore'

import DebtCard from './DebtCard.vue'
import DebtForm from './DebtForm.vue'
import BaseModal from './BaseModal.vue'
import ConfirmModal from './ConfirmModal.vue'

const debtStore = useDebtStore()

const editingDebt = ref(null)

const showFormModal = ref(false)

const showDeleteModal = ref(false)

const debtToDelete = ref(null)

async function deleteDebt(id) {
    await debtStore.deleteDebt(id)
}

function openAddModal() {

    editingDebt.value = null

    showFormModal.value = true
}

function closeFormModal() {

    showFormModal.value = false
}

function startEdit(debt) {

    editingDebt.value = debt

    showFormModal.value = true
}

function askDelete(id) {

    debtToDelete.value = id

    showDeleteModal.value = true
}

async function confirmDelete() {

    await debtStore.deleteDebt(debtToDelete.value)

    showDeleteModal.value = false
}
</script>

<style scoped>
.debt-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 15px;
}
</style>