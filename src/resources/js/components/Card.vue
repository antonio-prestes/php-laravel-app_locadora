<template>
    <div class="card mb-3">
        <div class="card-header">{{titulo}}</div>
        <div class="card-body">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "Card",
    props: ['titulo']
}
</script>

<style scoped>

</style>
