<template>
  <BaseModal @close="$emit('cancel')">
    <div
      class="relative overflow-hidden w-[900px] max-h-[75vh] rounded-[36px] border border-white/10 bg-black/40 backdrop-blur-3xl shadow-2xl shadow-violet-500/10"
    >
      <!-- GLOW -->

      <div
        class="absolute top-[-100px] right-[-100px] w-[240px] h-[240px] rounded-full bg-violet-500/10 blur-3xl"
      ></div>

      <!-- CONTENT -->

      <div class="relative z-10 flex flex-col max-h-[75vh]">
        <!-- HEADER -->

        <div class="px-6 pt-6 mb-4">
          <div>
            <h2 class="text-white text-3xl font-bold">Add Monthly Record</h2>

            <p class="text-white/40 mt-2">Add your monthly statement</p>
          </div>
        </div>

        <!-- FORM -->

        <div
          class="grid grid-cols-2 gap-4 overflow-y-auto px-6 pb-6 pt-2 flex-1 min-h-0"
        >
          <!-- MONTH -->

          <div>
            <label class="form-label"> Month </label>

            <select v-model="selectedMonth" class="glass-input">
              <option disabled value="">Select Month</option>

              <option v-for="month in months" :key="month" :value="month">
                {{ month }}
              </option>
            </select>
          </div>

          <!-- YEAR -->

          <div>
            <label class="form-label"> Year </label>

            <select v-model="selectedYear" class="glass-input">
              <option disabled value="">Select Year</option>

              <option v-for="year in years" :key="year" :value="year">
                {{ year }}
              </option>
            </select>
          </div>

          <!-- BALANCE -->

          <div>
            <label class="form-label"> Balance </label>

            <input
              v-model="form.balance"
              type="number"
              placeholder="
              ₱ 0.00
            "
              class="glass-input"
            />
          </div>

          <!-- MAD -->

          <div>
            <label class="form-label"> Minimum Due </label>

            <input
              v-model="form.minimum_due"
              type="number"
              placeholder="
              ₱ 0.00
            "
              class="glass-input"
            />
          </div>

          <!-- PAYMENT -->

          <div>
            <label class="form-label"> Payment Amount </label>

            <input
              v-model="form.payment_amount"
              type="number"
              placeholder="
              ₱ 0.00
            "
              class="glass-input"
            />
          </div>

          <!-- DATE -->

          <div>
            <label class="form-label"> Payment Date </label>

            <input
              v-model="form.payment_date"
              type="date"
              class="glass-input"
            />
          </div>

          <!-- POINTS -->

          <div class="col-span-2">
            <label class="form-label"> Points Earned </label>

            <input
              v-model="form.points_earned"
              type="text"
              inputmode="numeric"
              placeholder="
              0
            "
              class="glass-input"
            />
          </div>

          <!-- REMARKS -->

          <div class="col-span-2">
            <label class="form-label"> Remarks </label>

            <textarea
              v-model="form.remarks"
              rows="2"
              placeholder="
    Optional remarks...
  "
              class="glass-input resize-none h-[80px]"
            />
          </div>
        </div>

        <!-- ACTIONS -->
        <div
          class="px-6 py-5 border-t border-white/10 bg-black/20 backdrop-blur-xl"
        >
          <div class="flex justify-end gap-4">
            <button
              @click="$emit('cancel')"
              class="px-6 py-3 rounded-2xl bg-white/10 border border-white/10 text-white transition-all duration-300 hover:bg-white/20"
            >
              Cancel
            </button>

            <button
              @click="submit"
              class="px-7 py-3 rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 text-white font-semibold transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-violet-500/20"
            >
              Save Record
            </button>
          </div>
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
  cardId: Number,
});

const emit = defineEmits(["saved", "cancel"]);

const form = ref({
  month: "",

  balance: "",

  minimum_due: "",

  payment_amount: "",

  payment_date: "",

  points_earned: "",

  remarks: "",
});

const selectedMonth = ref("");
const selectedYear = ref("");

const months = [
  "January",
  "February",
  "March",
  "April",
  "May",
  "June",
  "July",
  "August",
  "September",
  "October",
  "November",
  "December",
];

const currentYear = new Date().getFullYear();

const years = Array.from({ length: 10 }, (_, i) => currentYear - i);

async function submit() {
  // REQUIRED FIELDS ONLY

  if (
    !selectedMonth.value ||
    !selectedYear.value ||
    !form.value.balance ||
    !form.value.minimum_due
  ) {
    alert("Please complete required fields.");

    return;
  }

  form.value.month = `${selectedMonth.value} ${selectedYear.value}`;

  try {
    await CreditCardRecordService.createRecord({
      ...form.value,

      // OPTIONAL PAYMENT FIELDS

      payment_amount: form.value.payment_amount || 0,

      payment_date: form.value.payment_date || null,

      credit_card_id: props.cardId,
    });

    emit("saved");
  } catch (error) {
    console.error(error.response?.data);

    alert("Failed to save record.");
  }
}
</script>

<style scoped>
.form-label {
  display: block;

  color: rgba(255, 255, 255, 0.65);

  margin-bottom: 8px;

  font-size: 13px;

  font-weight: 600;
}

.glass-input {
  width: 100%;

  padding: 14px 16px;

  border-radius: 18px;

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

select option {
  background: #111827;

  color: white;
}

::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.12);

  border-radius: 999px;
}
</style>
