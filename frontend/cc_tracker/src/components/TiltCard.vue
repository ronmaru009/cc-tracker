<template>
  <div ref="card" class="tilt-card transition-all duration-500">
    <slot />
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";

import VanillaTilt from "vanilla-tilt";

const card = ref(null);

onMounted(() => {
  VanillaTilt.init(
    card.value,

    {
      max: 18,

      speed: 500,

      glare: true,

      "max-glare": 0.35,

      scale: 1.05,

      perspective: 1400,
    },
  );
});

onBeforeUnmount(() => {
  card.value?.vanillaTilt?.destroy();
});
</script>

<style scoped>
.tilt-card {
  transform-style: preserve-3d;
}
</style>
