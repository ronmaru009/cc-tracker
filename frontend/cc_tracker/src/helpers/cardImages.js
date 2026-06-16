const cardImages = {
  "BPI Amore": "/img/Cards/bpi-amore.png",
  "RCBC JCB Gold": "/img/Cards/rcbc-jcb-gold.png",
  "RCBC Flex Visa": "/img/Cards/rcbc-flex.png",
  "UB Rewards Platinum Visa": "/img/Cards/UB Rewards.png",
  "UB U Visa Platinum": "/img/Cards/UBU.png",
  "BOC Mastercard": "/img/Cards/BOC.png",
  "CBC Mastercard": "/img/Cards/CBC Freedom.png",
  "EastWest JCB Gold": "/img/Cards/EW JCB.jpeg",
  "Atome Mastercard": "/img/Cards/atome.jpg",
  "BDO Classic": "/img/bdo-classic.png",
  "UB Platinum": "/img/ub-platinum.png",
};

export function getCardImage(cardNameOrPath) {
  if (!cardNameOrPath) {
    return "/img/default-card.png";
  }

  const normalized = String(cardNameOrPath).trim();

  if (normalized.startsWith("/")) {
    return normalized;
  }

  if (normalized.startsWith("../") || normalized.startsWith("./")) {
    return normalized.replace(/^\.{1,2}\//, "/");
  }

  if (normalized.startsWith("img/")) {
    return `/${normalized}`;
  }

  return cardImages[normalized] || "/img/default-card.png";
}
