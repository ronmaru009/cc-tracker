<template>
  <div class="card">
    <img :src="cardImage" class="card-img" />

    <div class="card-info">
      <h3>{{ card.name }}</h3>
      <p>•••• {{ card.card_last_four }}</p>

      <div class="balance">₱{{ card.balance }} / ₱{{ card.credit_limit }}</div>

      <div class="utilization">{{ utilization }}%</div>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";
import { getCardImage } from "../helpers/cardImages";

const props = defineProps({
  card: Object,
});

const cardImage = computed(() =>
  getCardImage(props.card?.card_image || props.card?.name),
);

const utilization = computed(() => {
  if (!props.card.credit_limit) return 0;
  return ((props.card.balance / props.card.credit_limit) * 100).toFixed(1);
});
</script>

<style scoped>
.card {
  width: 300px;
  border-radius: 16px;
  padding: 16px;
  background: #1e1e2f;
  color: white;
  margin: 20px 20px;
  transition:
    transform 0.2s ease,
    box-shadow 0.2s ease;
}
.card:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 40px rgba(248, 247, 242, 0.25);
}
.card-img {
  width: 100%;
  border-radius: 12px;
}
.balance {
  margin-top: 10px;
}
</style>
