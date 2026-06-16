<template>
  <div class="min-h-screen bg-[#08110c] relative overflow-hidden">
    <!-- BACKGROUND -->

    <img
      src="/img/bg.jpg"
      class="fixed inset-0 w-full h-full object-cover opacity-99"
    />

    <!-- OVERLAY -->

    <div class="absolute inset-0 bg-black/50"></div>

    <!-- CONTENT -->

    <div class="relative z-10 flex p-6 gap-6">
      <!-- SIDEBAR -->

      <aside
        class="w-[110px] min-h-[92vh] rounded-[40px] bg-white/[0.04] border border-white/10 backdrop-blur-2xl flex flex-col items-center py-6 gap-8"
      >
        <div
          class="
            w-16
            h-16

            flex
            items-center
            justify-center

            rounded-2xl

            bg-white/5

            border
            border-white/10

            backdrop-blur-xl
          "
        >
          <SparklesIcon
            class="
              w-8
              h-8

              text-amber-400
            "
          />
        </div>

        <div class="flex flex-col gap-6 text-white/70">
          <button class="dashboard-icon active">
            <HomeIcon class="w-7 h-7" />
          </button>

          <button class="dashboard-icon" @click="router.push('/cards')">
            <CreditCardIcon class="w-7 h-7" />
          </button>

          <button class="dashboard-icon" @click="router.push('/loans')">
           <BuildingLibraryIcon class="w-7 h-7" />
          </button>

          <button class="dashboard-icon" @click="router.push('/bills')">
           <DocumentTextIcon class="w-7 h-7"/>
          </button>

          <button class="dashboard-icon">
            <Cog6ToothIcon class="w-7 h-7" />
          </button>
        </div>
      </aside>

      <!-- MAIN -->

      <main class="flex-1">
        <!-- TOPBAR -->

        <div
          class="h-[90px] rounded-[36px] bg-white/[0.04] border border-white/10 backdrop-blur-2xl flex items-center justify-between px-8 mb-6"
        >
          <div>
            <h1 class="text-white text-3xl font-bold">Financial Dashboard</h1>

            <p class="text-white/50">Welcome back, Ron 👋</p>
          </div>

          <div class="px-5 py-3 rounded-2xl bg-white/[0.05] text-white/70">
            Total Debt: ₱ 245,000
          </div>
        </div>

        <!-- GRID -->

        <div class="grid grid-cols-12 gap-6">
          <!-- STATS -->

          <div
            class="col-span-3 stat-card transition-all duration-300 hover:-translate-y-2 hover:scale-[1.02] hover:shadow-2xl hover:shadow-violet-500/20 hover:border-violet-400/30"
          >
            <p class="stat-title">Total Debt</p>

            <h2 class="stat-value">₱{{ formatMoney(dashboard?.totalDebt) }}</h2>
          </div>

          <div class="col-span-3 stat-card transition-all duration-300 hover:-translate-y-2 hover:scale-[1.02] hover:shadow-2xl hover:shadow-violet-500/20 hover:border-violet-400/30"">
            <p class="stat-title">Total Loans</p>

            <h2 class="stat-value text-blue-400">
              ₱{{ formatMoney(dashboard?.totalLoans) }}
            </h2>
          </div>

          <div class="col-span-3 stat-card transition-all duration-300 hover:-translate-y-2 hover:scale-[1.02] hover:shadow-2xl hover:shadow-violet-500/20 hover:border-violet-400/30"">
            <p class="stat-title">Total Bills</p>

            <h2 class="stat-value text-violet-400">
              ₱{{ formatMoney(dashboard?.totalBills) }}
            </h2>
          </div>

          <div class="col-span-3 stat-card transition-all duration-300 hover:-translate-y-2 hover:scale-[1.02] hover:shadow-2xl hover:shadow-violet-500/20 hover:border-violet-400/30">
            <p class="stat-title">Available Credit</p>

            <h2 class="stat-value">
              ₱{{ formatMoney(dashboard?.totalLimit) }}
            </h2>
          </div>

          <!-- <div class="col-span-3 stat-card">
            <p class="stat-title">Available Credits</p>

            <h2 class="stat-value">
              ₱{{ formatMoney(dashboard?.totalAvailable) }}
            </h2>
          </div> -->

          <!-- MAIN CHART -->

          <!-- LOWER SECTION -->

          <div class="col-span-8 space-y-6">
            <!-- DEBT TREND -->

            <div class="glass-panel h-[420px]">
              <div class="flex justify-between mb-6">
                <div>
                  <h2 class="panel-title">Debt Trend</h2>

                  <p class="panel-subtitle">Overall monthly debt</p>
                </div>
              </div>

              <div class="h-[300px]">
                <Line
                  :data="debtTrendData"
                  :options="{
                    responsive: true,

                    maintainAspectRatio: false,

                    plugins: {
                      legend: {
                        display: false,
                      },
                    },

                    scales: {
                      x: {
                        ticks: {
                          color: 'rgba(255,255,255,0.5)',
                        },

                        grid: {
                          color: 'rgba(255,255,255,0.05)',
                        },
                      },

                      y: {
                        ticks: {
                          color: 'rgba(255,255,255,0.5)',
                        },

                        grid: {
                          color: 'rgba(255,255,255,0.05)',
                        },
                      },
                    },
                  }"
                />
              </div>
            </div>

            <!-- MONTHLY BALANCES + UTILIZATION -->

            <div class="grid grid-cols-12 gap-6">
              <!-- MONTHLY BALANCES -->

              <div class="col-span-8 glass-panel h-[420px]">
                <h2 class="panel-title mb-4">Monthly Balances</h2>

                <div class="h-[300px] mt-4">
                  <Bar
                    :data="monthlyBalanceChartData"
                    :options="{
                      responsive: true,

                      maintainAspectRatio: false,

                      plugins: {
                        legend: {
                          display: false,
                        },
                      },

                      scales: {
                        x: {
                          ticks: {
                            color: 'rgba(255,255,255,0.5)',
                          },

                          grid: {
                            display: false,
                          },
                        },

                        y: {
                          ticks: {
                            color: 'rgba(255,255,255,0.5)',
                          },

                          grid: {
                            color: 'rgba(255,255,255,0.05)',
                          },
                        },
                      },
                    }"
                  />
                </div>
              </div>

              <!-- UTILIZATION -->

              <div class="col-span-4 glass-panel">
                <h2 class="panel-title mb-4">Overall Utilization</h2>

                <div class="h-[280px] relative">
                  <Doughnut
                    :data="utilizationChartData"
                    :options="{
                      responsive: true,

                      maintainAspectRatio: false,

                      cutout: '72%',

                      plugins: {
                        legend: {
                          display: false,
                        },
                      },
                    }"
                  />

                  <div
                    class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none"
                  >
                    <p class="text-white/50 text-sm">Utilization</p>

                    <h2 class="text-white text-4xl font-bold">
                      {{ formatPercentage(dashboard?.utilization) }}%
                    </h2>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- RIGHT SIDEBAR -->

          <div class="col-span-4 space-y-6">
            <!-- CALENDAR PANEL -->

            <div class="glass-panel h-[420px]">
              <h2 class="panel-title mb-6">Payment Calendar</h2>
              <div class="flex justify-end gap-4 mb-4">
                <div class="flex items-center gap-2 text-xs text-white/60">
                  <div class="w-3 h-3 rounded-full bg-green-400"></div>
                  <span> Statement Date </span>
                </div>
                <div class="flex items-center gap-2 text-xs text-white/60">
                  <div class="w-3 h-3 rounded-full bg-orange-500"></div>
                  <span> Credit Card Due Date </span>
                </div>
                <div class="flex items-center gap-2 text-xs text-white/60">
                  <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                  <span> Loan Due Date </span>
                </div>
                 <div class="flex items-center gap-2 text-xs text-white/60">
                  <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                  <span> Bill Due Date </span>
                </div>
              </div>
              <VDatePicker
                expanded
                transparent
                borderless
                :attributes="calendarAttributes"
                @dayclick="onCalendarClick"
              />
            </div>

            <!-- UPCOMING DUES -->

            <div

              @click="
                openDue(due)
              "

              class="
                glass-panel

                cursor-pointer

                transition-all

                duration-300

                hover:-translate-y-1

                hover:scale-[1.02]

                hover:shadow-xl

                hover:shadow-violet-500/20
              "
            >
              <h2 class="panel-title mb-6">Upcoming Due Dates</h2>

              <div class="space-y-4 max-h-[420px] overflow-y-auto pretty-scrollbar pr-2">
                <div
                  v-for="due in dashboard?.upcomingDueDates?.filter(Boolean)"
                  :key="due.card_name"
                  @click="openDue(due)"
                  class="due-card"
                >
                  <div>
                    <p class="text-white font-semibold">
                      {{ due.card_name || due.loan_name || due.bill_name }}
                    </p>
                    <p
                      class="text-xs mt-1 font-semibold"
                      :class="
                        due.type === 'loan'
                          ? 'text-blue-400'
                          : due.type === 'bill'
                            ? 'text-violet-400'
                            : 'text-red-400'
                      "
                    >
                      {{
                        due.type === "loan"
                          ? "Loan"
                          : due.type === "bill"
                            ? "Bill"
                            : "Credit Card"
                      }}
                    </p>

                    <p
                      class="text-sm font-medium mt-1"
                      :class="
                        due.is_overdue || due.due_in_days < 0
                          ? 'text-red-400'
                          : 'text-white/50'
                      "
                    >
                      {{
                        due.is_overdue
                          ? 'Overdue'
                          : due.due_in_days < 0
                            ? `${Math.abs(due.due_in_days)} days overdue`
                            : `Due in ${due.due_in_days} days`
                      }}
                    </p>
                  </div>

                  <div class="text-right">
                    <p class="text-white/40 text-sm">Amount Due</p>

                    <h2 class="text-red-400 text-2xl font-bold">
                      ₱{{ formatMoney(due.amount_due) }}
                    </h2>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted, computed } from "vue";
import DashboardService from "../services/DashboardService";
import { formatMoney, formatPercentage } from "../utils/formatters";
import { Line, Doughnut, Bar } from "vue-chartjs";
import { useRouter } from "vue-router";
import {
  HomeIcon,
  CreditCardIcon,
  BuildingLibraryIcon,
  DocumentTextIcon,
  Cog6ToothIcon,
  SparklesIcon,
} from "@heroicons/vue/24/outline";

import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Tooltip,
  Legend,
  Filler,
  ArcElement,
  BarElement,
} from "chart.js";

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Tooltip,
  Legend,
  Filler,
  ArcElement,
  BarElement,
);

const dashboard = ref(null);
const router = useRouter();

onMounted(async () => {
  dashboard.value = await DashboardService.getDashboardData();
});

const debtTrendData = computed(() => {
  if (!dashboard.value) {
    return {
      labels: [],

      datasets: [],
    };
  }

  return {
    labels: dashboard.value.monthlyDebtTrend.map((item) => item.month),

    datasets: [
      {
        label: "Total Debt",
        data: dashboard.value.monthlyDebtTrend.map(
          (item) => item.total_balance,
        ),

        borderColor: "#FFA500",
        backgroundColor: "rgba(250,204,21,0.15)",
        fill: true,
        tension: 0.4,
      },
    ],
  };
});

const utilizationChartData = computed(() => {
  if (!dashboard.value) {
    return {
      labels: [],

      datasets: [],
    };
  }

  return {
    labels: ["Used Credit", "Available Credit"],

    datasets: [
      {
        data: [visualUtilization.value, 100 - visualUtilization.value],

        backgroundColor: [
          utilizationColor.value.primary,
          ,
          "rgba(255,255,255,0.12)",
        ],

        borderWidth: 0,

        hoverOffset: 12,
      },
    ],
  };
});

const visualUtilization = computed(() => {
  return Math.min(
    Number(dashboard.value?.utilization || 0),

    100,
  );
});

const monthlyBalanceChartData = computed(() => {
  if (!dashboard.value) {
    return {
      labels: [],

      datasets: [],
    };
  }

  return {
    labels: dashboard.value.monthlyDebtTrend.map((item) => item.month),

    datasets: [
      {
        label: "Monthly Balance",

        data: dashboard.value.monthlyDebtTrend.map((item) =>
          Number(item.total_balance),
        ),

        backgroundColor: "rgba(250,204,21,0.6)",

        borderRadius: 14,

        borderSkipped: false,
      },
    ],
  };
});

const utilizationColor = computed(() => {
  const utilization = Number(dashboard.value?.utilization || 0);

  if (utilization < 50) {
    return {
      primary: "#22c55e",
      secondary: "rgba(34,197,94,0.18)",
    };
  }

  if (utilization < 75) {
    return {
      primary: "#f97316",
      secondary: "rgba(249,115,22,0.18)",
    };
  }

  return {
    primary: "#ef4444",
    secondary: "rgba(239,68,68,0.18)",
  };
});

const calendarAttributes = computed(() => {
  const dues =
    dashboard.value?.upcomingDueDates

      ?.filter(Boolean)

      .flatMap((due) => [
        // CREDIT CARD DUE DATE

        ...(due.type === "card"
          ? [
              {
                key: `${due.card_name}-due`,

                dates: new Date(due.due_date),

                highlight: {
                  fillMode: "solid",

                  color: "red",
                },

                popover: {
                  label: `${due.card_name} Due Date`,
                  customData: {
                  route: '/cards'
                },
                },
              },
            ]
          : []),

        // CREDIT CARD STATEMENT DATE

        ...(due.type === "card"
          ? [
              {
                key: `${due.card_name}-statement`,

                dates: new Date(due.statement_date),

                highlight: {
                  fillMode: "solid",

                  color: "green",
                },

                popover: {
                  label: `${due.card_name} Statement Date`,
                  customData: {
                    route: '/cards'
                  },
                },
              },
            ]
          : []),

        // LOAN DUE DATE

        ...(due.type === "loan"
          ? [
              {
                key: `${due.loan_name}-loan`,

                dates: new Date(due.due_date),

                highlight: {
                  fillMode: "solid",

                  color: "blue",
                },

                popover: {
                  label: `${due.loan_name} Loan Due`,
                  customData: {
                  route: '/loans'
                },
                },
              },
            ]
          : []),

        ...(due.type === "bill"
          ? [
              {
                key: `${due.bill_name}-bill`,

                dates: new Date(due.due_date),

                highlight: {
                  fillMode: "solid",

                  color: "purple",
                },

                popover: {
                  label: `${due.bill_name} Bill Due`,
                  customData: {
                    route: '/bills'
                  },
                },
              },
            ]
          : []),
      ]) ?? [];

  return dues;
});

const openDue =
    (due) => {
        if (
            due.type === 'loan'
        ) {

            router.push(
                '/loans'
            )

            return
        }

        if (
            due.type === 'bill'
        ) {

            router.push(
                '/bills'
            )

            return
        }

        router.push(
            '/cards'
        )
}

const onCalendarClick =
    (day) => {

        const attribute =

            day.attributes?.[0]

        const route =

            attribute
            ?.popover
            ?.customData
            ?.route

        if (route) {

            router.push(
                route
            )
        }
}
</script>
<style scoped>
.dashboard-icon {
  width: 56px;
  height: 56px;

  display: flex;
  align-items: center;
  justify-content: center;

  border-radius: 18px;

  background: rgba(255,255,255,0.05);

  border: 1px solid rgba(255,255,255,0.08);

  backdrop-filter: blur(20px);

  transition: all 0.3s ease;
}

.dashboard-icon:hover {
  background: rgba(255,255,255,0.10);

  transform: translateY(-2px);
}

.dashboard-icon.active {
  background: rgba(255, 220, 120, 0.2);
}

.glass-panel {
  border-radius: 36px;

  background: rgba(255, 255, 255, 0.04);

  border: 1px solid rgba(255, 255, 255, 0.08);

  backdrop-filter: blur(24px);

  padding: 24px;
}

.stat-card {
  border-radius: 28px;

  background: rgba(255, 255, 255, 0.04);

  border: 1px solid rgba(255, 255, 255, 0.08);

  backdrop-filter: blur(24px);

  padding: 24px;
}

.stat-title {
  color: rgba(255, 255, 255, 0.5);

  margin-bottom: 12px;
}

.stat-value {
  color: white;

  font-size: 36px;

  font-weight: 700;
}

.panel-title {
  color: white;

  font-size: 24px;

  font-weight: 700;
}

.panel-subtitle {
  color: rgba(255, 255, 255, 0.5);
}

.due-card {
  display: flex;
  min-width: 100%;
  justify-content: space-between;

  align-items: center;

  width: 100%;

  padding: 22px;

  border-radius: 24px;

  background: rgba(255, 255, 255, 0.04);

  border: 1px solid rgba(255, 255, 255, 0.05);

  transition: all 0.3s ease;
}

.due-card:hover {
  transform: translateY(-2px);

  background: rgba(255, 255, 255, 0.09);
}

:deep(.vc-weekday) {
  color: #ff9142 !important;

  font-weight: 600;
}

:deep(.vc-arrow) {
  color: white !important;
}

:deep(.vc-arrow:hover) {
  color: #f97316 !important;
}

:deep(.vc-title) {
  color: white !important;

  font-weight: 600;
}

.stat-card {
  position: relative;
  overflow: hidden;
}

.stat-card::before {
  content: "";
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(255, 255, 255, 0.08), transparent);
  opacity: 0;
  transition: 0.3s;
}

.pretty-scrollbar::-webkit-scrollbar {

  width: 6px;
}

.pretty-scrollbar::-webkit-scrollbar-track {

  background:
    transparent;
}

.pretty-scrollbar::-webkit-scrollbar-thumb {

  background:
    rgba(255,255,255,0.12);

  border-radius:
    999px;

  backdrop-filter:
    blur(10px);

  transition:
    0.3s;
}

.pretty-scrollbar::-webkit-scrollbar-thumb:hover {

  background:
    rgba(139,92,246,0.45);
}

.pretty-scrollbar {

  scroll-behavior:
    smooth;
}
</style>
