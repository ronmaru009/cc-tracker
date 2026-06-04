<template>
  <div class="debt-card">

    <h3>{{ debt.name }}</h3>

    <p>Balance: ₱{{ debt.balance }}</p>
    <p>Min Payment: ₱{{ debt.minimum_payment }}</p>
    <p>Interest: {{ debt.interest_rate }}%</p>

    <p v-if="isNextToPay">
      👉 NEXT TO PAY
    </p>

    <div class="actions">

      <button @click="$emit('edit', debt)">
        Edit
      </button>

      <button @click="$emit('delete', debt.id)">
        Delete
      </button>

    </div>

  </div>
</template>

<script setup>
defineProps({
  debt: Object,
  isNextToPay: Boolean
})

defineEmits(['edit', 'delete'])
</script>

<style scoped>
.debt-card {
    background: white;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.actions {
    margin-top: 10px;
    display: flex;
    gap: 10px;
}
</style>