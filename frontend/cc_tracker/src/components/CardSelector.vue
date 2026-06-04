<template>

  <div>

    <button @click="$emit('back')">Back</button>

    <h3>{{ bank.name }} Cards</h3>

    <div class="cards">

      <div
        v-for="card in cards"
        :key="card.name"
        class="card"
        @click="$emit('selected', card)"
      >

        <p>{{ card.name }}</p>

      </div>

    </div>

  </div>

</template>

<script setup>
defineProps(['bank'])
defineEmits(['selected', 'back'])

const cards = [
    { name: 'BPI Amore' },
    { name: 'BPI Amore Platinum' },
    { name: 'BPI Visa Signature' }
]
</script>

<style scoped>
.cards {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
}

.card {
    padding: 15px;
    background: #e5e7eb;
    border-radius: 10px;
    cursor: pointer;
}
</style>