<template>
    <div :class="estilo" role="alert">
        {{ title }}
        <hr>
        {{ message.message }}
        <br>
        <ul v-if="message.dados">
            <li v-for="e, key in message.dados" :key="key">{{ e[0] }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "Alert",
    props: ['tipo', 'message', 'title'],
    computed: {
        estilo() {
            return 'alert alert-' + this.tipo
        }
    }
}
</script>

<style scoped>

</style>
