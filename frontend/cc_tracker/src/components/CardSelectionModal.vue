<template>
  <!-- MODAL -->

  <div class="relative overflow-hidden w-full p-10">
    <!-- GLOW -->

    <div
      class="absolute top-[-120px] right-[-120px] w-[260px] h-[260px] rounded-full bg-violet-500/20 blur-3xl"
    ></div>

    <!-- HEADER -->

    <div class="relative z-10 flex items-center justify-between mb-10">
      <div>
        <h2 class="text-white text-5xl font-bold">
          {{ bank.name }}

          Cards
        </h2>

        <p class="text-white/40 mt-2">Choose your credit card</p>
      </div>

      <button
        @click="$emit('close')"
        class="px-5 py-3 rounded-2xl bg-white/10 border border-white/10 text-white transition-all duration-300 hover:bg-white/20"
      >
        ← Back
      </button>
    </div>

    <!-- CARD GRID -->

    <div class="relative z-10 flex justify-center gap-10 flex-wrap pt-6">
      <button
        v-for="card in filteredCards"
        :key="card.name"
        @click="$emit('selected', card)"
        class="group relative overflow-hidden w-[300px] rounded-[32px] border border-white/10 bg-white/5 backdrop-blur-2xl transition-all duration-500 hover:-translate-y-3 hover:scale-[1.02] hover:bg-white/10 hover:shadow-2xl hover:shadow-violet-500/20 p-5"
      >
        <!-- IMAGE -->

        <div class="relative overflow-hidden rounded-3xl mb-5">
          <img
            :src="card.image"
            class="w-full object-contain transition-all duration-500 group-hover:scale-105"
          />

          <!-- OVERLAY -->

          <div
            class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"
          ></div>
        </div>

        <!-- NAME -->

        <div class="text-left">
          <h2 class="text-white text-2xl font-bold">
            {{ card.name }}
          </h2>

          <p class="text-white/40 mt-2">
            {{ card.bank }}
          </p>
        </div>
      </button>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";
const props = defineProps({
  bank: Object,
});
defineEmits(["selected", "close"]);

// temporary mock data (we will make this dynamic later)
const cards = [
  {
    bank: "RCBC",
    name: "RCBC Flex Visa",
    image: "../img/Cards/rcbc-flex.png",
  },
  {
    bank: "RCBC",
    name: "RCBC JCB Gold",
    image: "../img/Cards/rcbc-jcb-gold.png",
  },
  {
    bank: "BPI",
    name: "BPI Amore",
    image: "../img/Cards/bpi-amore.png",
  },
  {
    bank: "UnionBank",
    name: "UB Rewards Platinum Visa",
    image: "../img/Cards/UBU.png",
  },
  {
    bank: "UnionBank",
    name: "UB U Visa Platinum",
    image: "../img/Cards/UB Rewards.png",
  },
  {
    bank: "Bank Of Commerce",
    name: "BOC Mastercard",
    image: "../img/Cards/BOC.png",
  },
  {
    bank: "Chinabank",
    name: "CBC Mastercard",
    image: "../img/Cards/CBC Freedom.png",
  },
  {
    bank: "EastWest",
    name: "EastWest JCB Gold",
    image: "../img/Cards/EW JCB.jpeg",
  },
  {
    bank: "Atome",
    name: "Atome Mastercard",
    image: "../img/Cards/atome.jpg",
  },
];

const filteredCards = computed(() => {
  return cards.filter((card) => {
    return card.bank === props.bank.name;
  });
});
</script>

<!-- <style scoped>
.overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.5);

  display: flex;
  justify-content: center;
  align-items: center;

  z-index: 999;
}

.modal {
  background: white;
  width: 90%;
  max-width: 500px;
  padding: 20px;
  border-radius: 16px;
}

.back {
  margin-bottom: 10px;
}

.grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 12px;
}

.card {
  background: #f3f4f6;
  padding: 15px;
  border-radius: 14px;
  text-align: center;
  cursor: pointer;

  transition: 0.2s;

  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
}

.card-image {
  width: 60px;
  height: 60px;
  object-fit: contain;
}

.card:hover {
  transform: translateY(-4px) scale(1.03);
  background: #e5e7eb;
}

.card-box {
  font-size: 30px;
  margin-bottom: 8px;
}
</style> -->
