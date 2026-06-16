<template>
  <div v-if="card" class="min-h-screen p-6">
    <!-- TOP BAR -->

    <div class="flex items-center justify-between mb-8">
      <div class="flex items-center gap-4">
        <button
          @click="goBack"
          class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xl text-white text-xl transition-all duration-300 hover:scale-105 hover:bg-white/10"
        >
          ←
        </button>

        <div>
          <h1 class="text-white text-4xl font-bold">
            {{ card.name }}
          </h1>

          <p class="text-white/40 mt-1">Credit Card Overview</p>
        </div>
      </div>

      <div class="flex gap-3">
        <button
          @click="showRecordModal = true"
          class="px-5 py-3 rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 text-white font-semibold transition-all duration-300 hover:scale-105"
        >
          + Add Record
        </button>

        <button
          @click="showDeleteCardModal = true"
          class="px-5 py-3 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400"
        >
          Delete
        </button>
      </div>
    </div>

    <!-- MAIN GRID -->

    <div class="grid grid-cols-12 gap-6 mb-8">
      <!-- CARD -->

      <div
        class="col-span-5 relative overflow-hidden rounded-[30px] border border-white/10 bg-white/5 backdrop-blur-2xl p-6"
      >
        <img :src="getCardImage(card.name)" class="w-full rounded-3xl" />

        <div
          class="absolute bottom-10 right-10 px-4 py-2 rounded-2xl bg-black/40 border border-white/10 text-white text-sm"
        >
          ••••
          {{ card.card_last_four }}
        </div>
      </div>

      <!-- INFO -->

      <div
        class="col-span-4 rounded-[30px] border border-white/10 bg-white/5 backdrop-blur-2xl p-6"
      >
        <div class="space-y-5">
          <div>
            <p class="info-label">Credit Limit</p>

            <h2 class="info-value">₱{{ card.credit_limit }}</h2>
          </div>

          <div>
            <p class="info-label">Current Balance</p>

            <h2 class="info-value text-red-400">₱{{ latestBalance }}</h2>
          </div>

          <div>
            <p class="info-label">Interest Rate</p>

            <h2 class="info-value">{{ card.interest_rate }}%</h2>
          </div>

          <div>
            <p class="info-label">Statement Day</p>

            <h2 class="info-value">
              {{ card.billing_day }}
            </h2>
          </div>

          <div>
            <p class="info-label">Card Age</p>

            <h2 class="info-value">
              {{ cardAge }}
            </h2>
          </div>
        </div>
      </div>

      <!-- UTILIZATION -->

      <div
        class="col-span-3 rounded-[30px] border border-white/10 bg-white/5 backdrop-blur-2xl p-6 flex flex-col items-center justify-center"
      >
        <h2 class="text-white text-2xl font-bold mb-4">Utilization</h2>

        <p
          class="text-4xl font-bold mb-6"
          :class="utilization > 70 ? 'text-red-400' : 'text-green-400'"
        >
          {{ utilization.toFixed(1) }}%
        </p>

        <Doughnut :data="utilizationData" />
      </div>
    </div>

    <!-- RECORDS -->

    <div>
      <h2 class="text-white text-3xl font-bold mb-6">Monthly Records</h2>

      <div class="grid grid-cols-3 gap-5">
        <div
          v-for="record in card.records"
          :key="record.id"
          class="rounded-[28px] border border-white/10 bg-white/5 backdrop-blur-2xl p-6 transition-all duration-300 hover:-translate-y-2 hover:bg-white/10"
        >
          <div class="flex items-start justify-between mb-6">
            <!-- LEFT -->

            <div>
              <h2 class="text-white text-2xl font-bold">
                {{ record.month }}
              </h2>

              <p class="text-white/40 text-sm mt-1">
                Due: {{ record.due_date || "No due date" }}
              </p>
              <p class="text-white/40 text-sm mt-1">
                Payment Date: {{ record.payment_date || "No payment yet" }}
              </p>
            </div>

            <!-- RIGHT -->

            <div class="flex flex-col items-end gap-3">
              <!-- STATUS -->

              <div
                class="px-4 py-2 rounded-full text-xs font-bold tracking-wide border shadow-lg backdrop-blur-xl"
                :class="getPaymentStatusClass(record)"
              >
                {{ getPaymentStatus(record) }}
              </div>

              <!-- POINTS -->

              <div
                class="px-3 py-2 rounded-2xl bg-white/10 border border-white/10 text-white/70 text-xs"
              >
                {{ record.points_earned }}
                pts
              </div>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4 mb-5">
            <div class="record-pill">
              <p class="pill-label">Balance</p>

              <h2 class="pill-value">₱{{ record.balance }}</h2>
            </div>

            <div class="record-pill">
              <p class="pill-label">MAD</p>

              <h2 class="pill-value">₱{{ record.minimum_due }}</h2>
            </div>

            <div class="record-pill">
              <p class="pill-label">Payment</p>

              <h2 class="pill-value text-green-400">
                ₱{{ record.payment_amount }}
              </h2>
            </div>

            <div class="record-pill">
              <p class="pill-label">Remaining</p>

              <h2 class="pill-value">
                ₱{{
                  Number(record.balance || 0) -
                  Number(record.payment_amount || 0)
                }}
              </h2>
            </div>
          </div>

          <div class="rounded-2xl bg-black/20 border border-white/5 p-4 mb-5">
            <p class="text-white/40 text-sm mb-2">Remarks</p>

            <p class="text-white text-sm">
              {{ record.remarks || "No remarks" }}
            </p>
          </div>

          <div class="flex gap-3">
            <button
              @click="openPaymentModal(record)"
              :disabled="getPaymentStatus(record) === 'FULLY PAID'"
              class="flex-1 py-3 rounded-2xl text-sm font-semibold transition-all duration-300"
              :class="
                getPaymentStatus(record) === 'FULLY PAID'
                  ? `
        bg-green-500/10
        border
        border-green-500/20
        text-green-300
        cursor-not-allowed
        opacity-70
      `
                  : `
        bg-gradient-to-r
        from-violet-500
        to-fuchsia-500

        text-white

        hover:scale-[1.02]

        hover:shadow-xl

        hover:shadow-violet-500/20
      `
              "
            >
              {{ getPaymentStatus(record) === "FULLY PAID" ? "✓ Paid" : "Pay" }}
            </button>

            <button
              @click="confirmDeleteRecord(record)"
              class="px-5 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm"
            >
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- MODALS -->

    <MonthlyRecordForm
      v-if="showRecordModal"
      :cardId="card.id"
      @cancel="showRecordModal = false"
      @saved="refreshCard"
    />

    <PaymentModal
      v-if="showPaymentModal"
      :recordId="selectedRecord.id"
      @cancel="showPaymentModal = false"
      @saved="handlePaymentSaved"
    />

    <ConfirmModal
      v-if="showDeleteCardModal"
      title="Delete Card"
      message="Are you sure you want to delete this card?"
      @confirm="deleteCard"
      @cancel="showDeleteCardModal = false"
    />

    <ConfirmModal
      v-if="showDeleteRecordModal"
      title="Delete Record"
      message="Are you sure you want to delete this record?"
      @confirm="deleteRecord"
      @cancel="showDeleteRecordModal = false"
    />
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";

import { useRoute, useRouter } from "vue-router";

import CreditCardService from "../services/CreditCardService";

import CreditCardRecordService from "../services/CreditCardRecordService";

import { getCardImage } from "../helpers/cardImages";

import ConfirmModal from "../components/ConfirmModal.vue";

import MonthlyRecordForm from "../components/MonthlyRecordForm.vue";

import PaymentModal from "../components/PaymentModal.vue";

import { Doughnut } from "vue-chartjs";

import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js";

ChartJS.register(ArcElement, Tooltip, Legend);

const route = useRoute();

const router = useRouter();

const card = ref(null);

const showDeleteCardModal = ref(false);

const showDeleteRecordModal = ref(false);

const showRecordModal = ref(false);

const selectedRecord = ref(null);

const showPaymentModal = ref(false);

const selectedRecordToDelete = ref(null);

const latestBalance = ref(0);

onMounted(async () => {
  await fetchCard();
});

async function fetchCard() {
  const response = await CreditCardService.getCard(route.params.id);

  card.value = response.card;

  calculateLatestBalance();
}

function calculateLatestBalance() {
  if (!card.value?.records?.length) {
    latestBalance.value = 0;

    return;
  }

  let totalDebt = 0;

  card.value.records.forEach((record) => {
    totalDebt +=
      Number(record.balance || 0) - Number(record.payment_amount || 0);
  });

  latestBalance.value = totalDebt;
}

function getPaymentStatus(record) {
  const remaining =
    Number(record.balance || 0) - Number(record.payment_amount || 0);

  if (remaining <= 0) {
    return "FULLY PAID";
  }

  if (Number(record.payment_amount || 0) > 0) {
    return "PARTIAL PAYMENT";
  }

  return "UNPAID";
}

function getPaymentStatusClass(record) {
  const remaining =
    Number(record.balance || 0) - Number(record.payment_amount || 0);

  if (remaining <= 0) {
    return `
      bg-green-500/15
      text-green-300
      border-green-400/20
      shadow-green-500/10
    `;
  }

  if (Number(record.payment_amount || 0) > 0) {
    return `
      bg-yellow-500/15
      text-yellow-300
      border-yellow-400/20
      shadow-yellow-500/10
    `;
  }

  return `
    bg-red-500/20
    text-red-300
    border-red-400/30
    shadow-red-500/20
    animate-pulse
  `;
}

function goBack() {
  router.push("/cards");
}

function openPaymentModal(record) {
  selectedRecord.value = record;

  showPaymentModal.value = true;
}

async function handlePaymentSaved() {
  await fetchCard();

  showPaymentModal.value = false;
}

async function refreshCard() {
  await fetchCard();

  showRecordModal.value = false;
}

async function deleteCard() {
  await CreditCardService.deleteCard(route.params.id);

  router.push("/cards");
}

function confirmDeleteRecord(record) {
  selectedRecordToDelete.value = record;

  showDeleteRecordModal.value = true;
}

async function deleteRecord() {
  await CreditCardRecordService.deleteRecord(selectedRecordToDelete.value.id);

  await refreshCard();

  showDeleteRecordModal.value = false;
}

const cardAge = computed(() => {
  if (!card.value?.start_date) {
    return "N/A";
  }

  const start = new Date(card.value.start_date);

  const now = new Date();

  let years = now.getFullYear() - start.getFullYear();

  let months = now.getMonth() - start.getMonth();

  if (months < 0) {
    years--;

    months += 12;
  }

  return `${years} years, ${months} months`;
});

const utilization = computed(() => {
  if (!card.value || !card.value.credit_limit) {
    return 0;
  }

  return (latestBalance.value / card.value.credit_limit) * 100;
});

const utilizationData = computed(() => {
  if (!card.value) {
    return {
      labels: [],

      datasets: [],
    };
  }

  const used = latestBalance.value;

  const available = card.value.credit_limit - used;

  return {
    labels: ["Used", "Available"],

    datasets: [
      {
        data: [used, available],

        backgroundColor: ["#ef4444", "#22c55e"],

        borderWidth: 0,
      },
    ],
  };
});
</script>

<style scoped>
.info-label {
  color: rgba(255, 255, 255, 0.4);

  margin-bottom: 8px;

  font-size: 13px;
}

.info-value {
  color: white;

  font-size: 26px;

  font-weight: 700;
}

.record-pill {
  padding: 16px;

  border-radius: 22px;

  background: rgba(255, 255, 255, 0.05);

  border: 1px solid rgba(255, 255, 255, 0.08);
}

.pill-label {
  color: rgba(255, 255, 255, 0.4);

  margin-bottom: 8px;

  font-size: 12px;
}

.pill-value {
  color: white;

  font-size: 20px;

  font-weight: 700;
}
</style>
