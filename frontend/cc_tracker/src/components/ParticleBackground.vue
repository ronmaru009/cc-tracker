<template>

  <Particles
    id="tsparticles"

    :options="options"
  />

</template>

<script setup>
const options = {

    fullScreen: {
        enable: false
    },

    background: {
        color: {
            value: 'transparent'
        }
    },

    fpsLimit: 120,

    particles: {

    color: {
        value: '#ffffff'
    },

    links: {
        enable: false
    },

    move: {

        direction: 'none',

        enable: true,

        outModes: {
            default: 'bounce'
        },

        random: true,

        speed: 0.5,

        straight: false
    },

    number: {

        density: {
            enable: true
        },

        value: 150
    },

    opacity: {
        value: 1
    },

    shape: {
        type: 'circle'
    },

    size: {
        value: {
            min: 12,
            max: 20
        }
    }
},

    detectRetina: true
}
</script>

<style scoped>

#tsparticles {

      position: absolute;

    inset: 0;

    width: 100%;

    height: 100%;

    z-index: 1;

    pointer-events: none;
}
</style>