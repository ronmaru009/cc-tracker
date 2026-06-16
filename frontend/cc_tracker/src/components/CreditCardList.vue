<template>
  <div class="min-h-screen p-8">
    <!-- HEADER -->

    <div class="flex items-center justify-between mb-10">
      <!-- LEFT -->

      <div class="flex items-center gap-5">
        <!-- BACK -->

        <button
          @click="router.push('/dashboard')"
          class="w-14 h-14 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xl text-white text-2xl transition-all duration-300 hover:scale-105 hover:bg-white/10 hover:shadow-lg hover:shadow-violet-500/10"
        >
          ←
        </button>

        <!-- TITLE -->

        <div>
          <h1 class="text-white text-5xl font-bold">My Cards</h1>

          <p class="text-white/40 mt-2">Manage your credit cards</p>
        </div>
      </div>

      <!-- ADD BUTTON -->

      <button
        v-if="!showWizard"
        @click="showWizard = true"
        class="px-6 py-4 rounded-2xl bg-white/10 border border-white/10 backdrop-blur-xl text-white font-semibold transition-all duration-300 hover:scale-105 hover:bg-white/20 hover:shadow-xl hover:shadow-violet-500/20"
      >
        + Add Credit Card
      </button>
    </div>

    <!-- WIZARD -->

    <CardWizard v-if="showWizard" @close="showWizard = false" />

    <!-- BANK ACCORDIONS -->

    <div class="space-y-6">
      <div
        v-for="(cards, bank) in groupedCards"
        :key="bank"
        class="relative overflow-hidden rounded-[32px] border border-white/10 bg-white/5 backdrop-blur-2xl shadow-xl shadow-black/20"
      >
        <!-- GLOW -->

        <div
          class="absolute top-[-120px] right-[-120px] w-[240px] h-[240px] rounded-full bg-violet-500/10 blur-3xl"
        ></div>

        <!-- ACCORDION HEADER -->

        <button
          @click="toggleBank(bank)"
          class="relative z-10 w-full flex items-center justify-between px-8 py-6 text-left transition-all duration-300 hover:bg-white/5"
        >
          <div>
            <h2 class="text-white text-3xl font-bold">
              {{ bank }}
            </h2>

            <p class="text-white/40 mt-1">
              {{ cards.length }}

              cards
            </p>
          </div>

          <div
            class="text-white/40 text-3xl transition-all duration-300"
            :class="openBanks.includes(bank) ? 'rotate-180' : ''"
          >
            ⌄
          </div>
        </button>

        <!-- CARD LIST -->

        <div
          v-if="openBanks.includes(bank)"
          class="relative z-10 border-t border-white/10 p-8"
        >
          <div class="grid grid-cols-4 gap-6">
            <div
              v-for="card in cards"
              :key="card.id"
              @click="goToCard(card.id)"
              class="group relative cursor-pointer transition-all duration-300 hover:-translate-y-2 hover:scale-[1.02]"
            >
              <!-- IMAGE -->

              <img
                :src="getCardImage(card.card_image || card.name)"
                class="w-full rounded-3xl shadow-2xl shadow-black/30"
              />

              <!-- OVERLAY -->

              <div
                class="absolute inset-0 rounded-3xl bg-gradient-to-t from-black/60 to-transparent opacity-0 transition-all duration-300 group-hover:opacity-100"
              ></div>

              <!-- LAST FOUR -->

              <div
                class="absolute bottom-4 left-4 px-4 py-2 rounded-2xl bg-black/40 backdrop-blur-md border border-white/10 text-white font-semibold"
              >
                ••••
                {{ card.card_last_four }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";

import { useRouter } from "vue-router";

import { useCardStore } from "../stores/cardStore";

import CardWizard from "./CardWizard.vue";

import { getCardImage } from "../helpers/cardImages";

const showWizard = ref(false);

const router = useRouter();

const cardStore = useCardStore();

const openBanks = ref([]);

onMounted(async () => {
  await cardStore.fetchCards();

  openBanks.value = Object.keys(groupedCards.value);
});

function goToCard(id) {
  router.push(`/cards/${id}`);
}

const groupedCards = computed(() => {
  const groups = {};

  cardStore.cards.forEach((card) => {
    const bank = card.bank_name || "Other Banks";

    if (!groups[bank]) {
      groups[bank] = [];
    }

    groups[bank].push(card);
  });

  return groups;
});

function toggleBank(bank) {
  if (openBanks.value.includes(bank)) {
    openBanks.value = openBanks.value.filter((b) => b !== bank);

    return;
  }

  openBanks.value.push(bank);
}
</script>

<!-- <style scoped>
.page {
  padding: 20px;
}

.card-grid {
  margin-top: 20px;

  display: grid;

  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));

  gap: 20px;
}

.card-item {
  cursor: pointer;

  transition: transform 0.2s ease;
}

.card-item:hover {
  transform: scale(1.03);
}

.card-image {
  width: 100%;
  border-radius: 18px;

  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);

  object-fit: cover;
}
</style> -->
