const cardImages = {

    'BPI Amore':
        '/img/Cards/bpi-amore.png',

    'RCBC JCB Gold':
        '/img/Cards/rcbc-jcb-gold.png',

    'BDO Classic':
        '/img/bdo-classic.png',

    'UB Platinum':
        '/img/ub-platinum.png'
}

export function getCardImage(cardName) {

    return cardImages[cardName]
        || '/img/default-card.png'
}