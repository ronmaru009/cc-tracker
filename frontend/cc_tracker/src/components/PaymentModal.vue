<template>
  <BaseModal @close="$emit('cancel')">
    <div
      class="relative overflow-hidden w-[500px] rounded-[36px] border border-white/10 bg-black/40 backdrop-blur-3xl shadow-2xl shadow-violet-500/10"
    >
      <!-- GLOW -->

      <div
        class="absolute top-[-100px] right-[-100px] w-[220px] h-[220px] rounded-full bg-violet-500/10 blur-3xl"
      ></div>

      <!-- CONTENT -->

      <div class="relative z-10 p-8">
        <!-- HEADER -->

        <div class="mb-8">
          <h2 class="text-white text-4xl font-bold">Make Payment</h2>

          <p class="text-white/40 mt-2">Record a payment for this statement</p>
        </div>

        <!-- AMOUNT -->

        <div class="mb-8">
          <label class="form-label"> Payment Amount </label>

          <div class="relative">
            <span
              class="absolute left-6 top-1/2 -translate-y-1/2 text-white/40 text-2xl font-semibold"
            >
              ₱
            </span>

            <input
              v-model="amount"
              type="text"
              inputmode="numeric"
              placeholder="
                0.00
              "
              class="glass-input pl-14 text-3xl font-bold"
            />
          </div>
        </div>

        <!-- ACTIONS -->

        <div class="flex justify-end gap-4">
          <button
            @click="$emit('cancel')"
            class="px-6 py-4 rounded-2xl bg-white/10 border border-white/10 text-white font-semibold transition-all duration-300 hover:bg-white/20"
          >
            Cancel
          </button>

          <button
            @click="submit"
            class="px-8 py-4 rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 text-white font-semibold transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:shadow-violet-500/20"
          >
            Confirm Payment
          </button>
        </div>
      </div>
    </div>
  </BaseModal>
</template>

<script setup>
import { ref } from "vue";

import BaseModal from "./BaseModal.vue";

import CreditCardRecordService from "../services/CreditCardRecordService";

const props = defineProps({
  recordId: Number,
});

const emit = defineEmits(["saved", "cancel"]);

const amount = ref("");

async function submit() {
  if (!amount.value) {
    alert("Please enter payment amount.");

    return;
  }

  await CreditCardRecordService.makePayment(
    props.recordId,

    amount.value,
  );

  emit("saved");
}
</script>

<style scoped>
.form-label {
  display: block;

  color: rgba(255, 255, 255, 0.65);

  margin-bottom: 12px;

  font-size: 14px;

  font-weight: 600;
}

.glass-input {
  width: 100%;

  padding: 20px 22px;

  border-radius: 24px;

  background: rgba(255, 255, 255, 0.05);

  border: 1px solid rgba(255, 255, 255, 0.08);

  backdrop-filter: blur(20px);

  color: white;

  outline: none;

  transition: 0.3s;
}

.glass-input:focus {
  border-color: rgba(139, 92, 246, 0.6);

  box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.12);
}

.glass-input::placeholder {
  color: rgba(255, 255, 255, 0.3);
}
</style>
