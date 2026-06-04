import { createRouter, createWebHistory } from "vue-router";

import DashboardPage from "../pages/DashboardPage.vue";
import CardDetailsPage from "../pages/CardDetailsPage.vue";
import Homepage from "../pages/Homepage.vue";
import CreditCardList from "../components/CreditCardList.vue";
import LoansPage from "../pages/LoansPage.vue";

const routes = [
  {
    path: "/",
    component: Homepage,
  },
  {
    path: "/cards/:id",
    component: CardDetailsPage,
  },
  {
    path: "/dashboard",
    component: DashboardPage,
  },
  {
    path: "/cards",
    component: CreditCardList,
  },
  {
    path: "/loans",
    name: "loans",
    component: LoansPage,
  },
  {
    path: "/bills",
    name: "bills",
    component: () => import("../pages/BillsPage.vue"),
  },
];

export default createRouter({
  history: createWebHistory(),
  routes,
});
