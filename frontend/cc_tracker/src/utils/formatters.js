export function formatMoney(value) {
  return Number(value || 0).toLocaleString(
    "en-PH",

    {
      minimumFractionDigits: 2,

      maximumFractionDigits: 2,
    },
  );
}

export function formatPercentage(value) {
  return Number(value || 0).toFixed(2);
}

export function formatCompactNumber(value) {
  return Intl.NumberFormat(
    "en",

    {
      notation: "compact",

      maximumFractionDigits: 1,
    },
  ).format(value || 0);
}

export function formatDate(date) {
  return new Date(date).toLocaleDateString(
    "en-PH",

    {
      month: "2-digit",

      day: "2-digit",

      year: "numeric",
    },
  );
}
