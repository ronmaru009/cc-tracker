<template>
  <div class="min-h-screen p-8">
    <div class="flex justify-between items-center mb-10">
      <div class="flex items-center gap-4">
        <button
          @click="goBack"
          class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xl text-white text-xl transition-all duration-300 hover:scale-105 hover:bg-white/10"
        >
          ←
        </button>

        <div>
          <h1 class="text-white text-4xl font-bold">Loans</h1>

          <p class="text-white/40 mt-1">Track your active loans</p>
        </div>
      </div>

      <button
        @click="showModal = true"
        class="px-5 py-3 rounded-2xl bg-orange-500 text-white font-semibold transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-orange-500/20"
      >
        Add Loan
      </button>
    </div>

    <!-- LOAN CARDS -->

    <div class="grid grid-cols-3 gap-6">
      <div v-for="loan in loans || []" :key="loan.id" class="glass-panel p-6">
        <!-- LOAN HEADER -->

        <h2 class="text-white text-2xl font-bold">
          {{ loan.loan_name }}
        </h2>

        <p class="text-white/50 mt-2">Total: ₱{{ loan.total_amount }}</p>

        <p class="text-white/50">Monthly: ₱{{ loan.monthly_amortization }}</p>
        <div class="mt-4 space-y-2">
          <div class="flex justify-between">
            <p class="text-white/40">Paid</p>

            <p class="text-green-400 font-semibold">
              ₱{{ formatMoney(loan.paid_amount) }}
            </p>
          </div>

          <div class="flex justify-between">
            <p class="text-white/40">Remaining</p>

            <p class="text-orange-400 font-semibold">
              ₱{{ formatMoney(loan.remaining_balance) }}
            </p>
          </div>
          <div class="mt-5">
            <!-- LABEL -->

            <div class="flex justify-between mb-2">
              <p class="text-white/40 text-sm">Loan Progress</p>

              <p class="text-white/60 text-sm">
                {{ loan.progress_percentage }}%
              </p>
            </div>

            <!-- BAR -->

            <div class="w-full h-3 rounded-full bg-white/10 overflow-hidden">
              <div
                class="h-full rounded-full bg-gradient-to-r from-orange-500 to-orange-300 transition-all duration-700"
                :style="{
                  width: `${loan.progress_percentage}%`,
                }"
              ></div>
            </div>
          </div>
        </div>
        <button
          @click="toggleLoan(loan.id)"
          class="mt-6 w-full py-3 rounded-xl bg-white/5 hover:bg-white/10 transition-all text-white/70"
        >
          {{
            expandedLoans?.includes(loan.id)
              ? "Hide Payment Schedule"
              : "View Payment Schedule"
          }}
        </button>
        <!-- PAYMENTS -->

        <div
          v-if="expandedLoans?.includes(loan.id)"
          class="mt-6 space-y-3 max-h-[400px] overflow-y-auto pr-2"
        >
          <div
            v-for="payment in loan?.payments || []"
            :key="payment.id"
            class="group flex items-center justify-between bg-white/5 rounded-xl px-4 py-3 transition-all duration-300 hover:bg-white/10 hover:scale-[1.02] hover:shadow-lg hover:shadow-orange-500/10"
          >
            <!-- LEFT -->

            <div>
              <p
                class="text-white transition-all duration-300"
                :class="
                  payment.is_paid
                    ? 'line-through text-green-400 opacity-60'
                    : ''
                "
              >
                {{
                  payment?.payment_month
                    ? new Date(payment.payment_month).toLocaleDateString(
                        "en-US",
                        {
                          month: "long",
                          year: "numeric",
                        },
                      )
                    : "No Month"
                }}
              </p>

              <!-- DUE DATE -->

              <input
                :value="payment?.due_date || ''"
                type="date"
                class="bg-white/5 border border-white/10 rounded-lg px-2 py-1 text-white text-sm mt-2"
                @change="
                  updatePayment(
                    payment,

                    payment.amount,

                    $event.target.value,
                  )
                "
              />
            </div>

            <!-- RIGHT -->

            <div class="flex items-center gap-4">
              <!-- AMOUNT -->

              <input
                :value="payment?.amount || 0"
                type="number"
                class="w-[120px] bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-white"
                @change="
                  updatePayment(
                    payment,

                    $event.target.value,

                    payment.due_date,
                  )
                "
              />

              <!-- CHECKBOX -->

              <input
                type="checkbox"
                :checked="payment?.is_paid"
                @change="togglePayment(payment.id)"
                class="w-5 h-5 accent-orange-500 transition-all duration-300 hover:scale-125 checked:scale-110"
              />
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL -->
    <!-- TOP GLOW -->

    <div
      class="absolute top-[-120px] left-[-120px] w-[260px] h-[260px] rounded-full bg-orange-500/20 blur-3xl pointer-events-none"
    ></div>

    <!-- BOTTOM GLOW -->

    <div
      class="absolute bottom-[-120px] right-[-120px] w-[240px] h-[240px] rounded-full bg-green-500/20 blur-3xl pointer-events-none"
    ></div>
    <div
      v-if="showModal"
      class="fixed inset-0 bg-black/60 flex items-center justify-center z-50"
    >
      <div
        class="relative overflow-hidden p-8 w-[520px] rounded-[32px] border border-white/10 bg-white/5 backdrop-blur-2xl shadow-2xl shadow-black/40"
      >
        <h2 class="text-white text-2xl font-bold mb-6">Add Loan</h2>

        <div class="space-y-4">
          <input
            v-model="form.loan_name"
            placeholder="Loan Name"
            class="input-modern"
          />

          <input
            v-model="form.total_amount"
            type="number"
            placeholder="Total Amount"
            class="input-modern"
          />

          <input v-model="form.start_date" type="date" class="input-modern" />

          <input v-model="form.end_date" type="date" class="input-modern" />

          <input
            v-model="form.due_day"
            type="number"
            placeholder="Due Day"
            class="input-modern"
          />
        </div>

        <div class="flex justify-end gap-4 mt-8">
          <button
            @click="showModal = false"
            class="px-4 py-2 rounded-xl bg-white/10 text-white"
          >
            Cancel
          </button>

          <button
            @click="createLoan"
            class="px-4 py-2 rounded-xl bg-orange-500 text-white"
          >
            Save Loan
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import LoanService from "../services/LoanService";
import { formatMoney } from "../utils/formatters";
import { useRouter } from "vue-router";

const router = useRouter();
const loans = ref([]);
const expandedLoans = ref([]);
const showModal = ref(false);

function goBack() {
  router.push("/dashboard");
}

const form = ref({
  loan_name: "",

  total_amount: "",

  start_date: "",

  end_date: "",

  due_day: "",
});

const fetchLoans = async () => {
  loans.value = await LoanService.getLoans();
};

const createLoan = async () => {
  await LoanService.createLoan(form.value);

  showModal.value = false;

  fetchLoans();
};

const editingPayment = ref(null);

const togglePayment = async (id) => {
  await LoanService.toggleLoanPayment(id);
  fetchLoans();
};

const updatePayment = async (
  payment,

  amount,

  dueDate,
) => {
  await LoanService.updateLoanPayment(
    payment.id,

    {
      amount,
      due_date: dueDate,
    },
  );

  fetchLoans();
};

const toggleLoan = (id) => {
  if (expandedLoans?.value.includes(id)) {
    expandedLoans.value = expandedLoans.value.filter((loanId) => loanId !== id);
  } else {
    expandedLoans.value.push(id);
  }
};

onMounted(fetchLoans);
</script>
<style scoped>
.input-modern {
  width: 100%;

  padding: 14px 18px;

  border-radius: 18px;

  background: rgba(255, 255, 255, 0.06);

  border: 1px solid rgba(255, 255, 255, 0.08);

  backdrop-filter: blur(20px);

  color: white;

  transition: all 0.3s ease;
}

.input-modern:focus {
  outline: none;

  border: 1px solid rgba(249, 115, 22, 0.5);

  box-shadow: 0 0 20px rgba(249, 115, 22, 0.15);

  background: rgba(255, 255, 255, 0.08);
}
</style>
