<template>
    <div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col" v-for="titulo, key in titulos" :key="key" class="text-uppercase">{{ titulo }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="marca in dados" :key="dados.id">
                <td v-if="titulos.includes(chave)" v-for="valor, chave in marca" :key="chave">
                    <span v-if="chave === 'imagem'">
                        <img :src="'/app/public/'+valor" alt="imagemlogo" width="50px">
                    </span>
                    <span v-else>
                          {{ valor }}
                    </span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: " Table",
    props: ['dados', 'titulos']
}
</script>

<style scoped>

</style>
