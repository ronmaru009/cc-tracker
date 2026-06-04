<template>
  <div
    class="fixed inset-0 bg-black/40 backdrop-blur-md flex items-center justify-center z-50"
  >
    <!-- MODAL -->

    <div
      class="relative overflow-hidden w-[1200px] h-[90vh] rounded-[40px] border border-white/10 bg-black/40 backdrop-blur-3xl shadow-2xl shadow-violet-500/10"
    >
      <!-- GLOW -->

      <div
        class="absolute top-[-140px] left-[-140px] w-[320px] h-[320px] rounded-full bg-violet-500/20 blur-3xl"
      ></div>

      <div
        class="absolute bottom-[-120px] right-[-120px] w-[280px] h-[280px] rounded-full bg-fuchsia-500/20 blur-3xl"
      ></div>

      <!-- CONTENT -->

      <div class="relative z-10 p-10 h-full overflow-y-auto">
        <!-- HEADER -->

        <div class="flex items-center justify-between mb-10">
          <div>
            <h1 class="text-white text-5xl font-bold">Add Credit Card</h1>

            <p class="text-white/40 mt-2">Setup your card portfolio</p>
          </div>

          <button
            @click="emit('close')"
            class="w-12 h-12 rounded-full bg-white/10 text-white text-2xl transition-all duration-300 hover:bg-white/20"
          >
            ×
          </button>
        </div>

        <!-- STEP INDICATOR -->

        <div class="flex items-center gap-4 mb-12">
          <div class="flex items-center gap-3">
            <button
              @click="goToStep(1)"
              class="flex items-center gap-3 transition-all duration-300 hover:scale-105"
            >
              <div
                class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all duration-300"
                :class="
                  step >= 1
                    ? 'bg-violet-500 text-white'
                    : 'bg-white/10 text-white/40'
                "
              >
                1
              </div>

              <p class="text-white">Bank</p>
            </button>
          </div>

          <div class="w-20 h-[2px] bg-white/10"></div>

          <div class="flex items-center gap-3">
            <button
              @click="goToStep(2)"
              class="flex items-center gap-3 transition-all duration-300 hover:scale-105"
            >
              <div
                class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all duration-300"
                :class="
                  step >= 2
                    ? 'bg-violet-500 text-white'
                    : 'bg-white/10 text-white/40'
                "
              >
                2
              </div>

              <p class="text-white">Card</p>
            </button>
          </div>

          <div class="w-20 h-[2px] bg-white/10"></div>

          <div class="flex items-center gap-3">
            <button
              @click="goToStep(3)"
              class="flex items-center gap-3 transition-all duration-300 hover:scale-105"
            >
              <div
                class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all duration-300"
                :class="
                  step >= 3
                    ? 'bg-violet-500 text-white'
                    : 'bg-white/10 text-white/40'
                "
              >
                3
              </div>

              <p class="text-white">Details</p>
            </button>
          </div>
        </div>

        <!-- STEP CONTENT -->

        <transition mode="out-in" name="fade-slide">
          <div :key="step">
            <!-- STEP 1 -->

            <BankCarousel v-if="step === 1" @selected="selectBank" />

            <!-- STEP 2 -->

            <CardSelectionModal
              v-if="step === 2"
              :bank="selectedBank"
              @selected="selectCard"
              @close="step = 1"
            />

            <!-- STEP 3 -->

            <CreditCardForm
              v-if="step === 3"
              :card="selectedCard"
              @back="step = 2"
              @saved="finish"
            />
          </div>
        </transition>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";

import BankCarousel from "./BankCarousel.vue";
import CardSelector from "./CardSelector.vue";
import CreditCardForm from "./CreditCardForm.vue";
import CardSelectionModal from "./CardSelectionModal.vue";
const emit = defineEmits(["close"]);

const step = ref(1);

const selectedBank = ref(null);
const selectedCard = ref(null);

function selectBank(bank) {
  selectedBank.value = bank;
  step.value = 2;
}

function selectCard(card) {
  selectedCard.value = card;
  step.value = 3;
}

function finish() {
  step.value = 1;
  selectedBank.value = null;
  selectedCard.value = null;
}

function goToStep(targetStep) {
  // STEP 1 ALWAYS ALLOWED

  if (targetStep === 1) {
    step.value = 1;

    return;
  }

  // STEP 2 REQUIRES BANK

  if (targetStep === 2 && selectedBank.value) {
    step.value = 2;

    return;
  }

  // STEP 3 REQUIRES CARD

  if (targetStep === 3 && selectedCard.value) {
    step.value = 3;
  }
}
</script>

<style scoped>
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.35s ease;
}

.fade-slide-enter-from {
  opacity: 0;

  transform: translateY(20px);
}

.fade-slide-leave-to {
  opacity: 0;

  transform: translateY(-20px);
}

::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.15);

  border-radius: 999px;
}
</style>
