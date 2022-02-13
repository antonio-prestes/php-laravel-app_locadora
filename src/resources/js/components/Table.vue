<template>
    <div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col" v-for="titulo, key in titulos" :key="key">{{ titulo.titulo }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                <td v-for="valor, chaveValor in obj" :key="chaveValor">
                    <span v-if="titulos[chaveValor].tipo === 'text'">{{ valor }}</span>
                    <span v-if="titulos[chaveValor].tipo === 'data'">{{ valor | formatDate }}</span>
                    <span v-if="titulos[chaveValor].tipo === 'img'">
                        <img :src="'/app/public/'+valor" alt="imagemlogo" width="50px"></span>
                </td>
            </tr>

            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "Table",
    props: ['dados', 'titulos'],
    computed: {
        dadosFiltrados() {
            let campos = Object.keys(this.titulos)
            let dadosFiltrados = []
            this.dados.map((item, chave) => {

                let itemFiltrado = {}
                campos.forEach(campo => {
                    itemFiltrado[campo] = item[campo]
                })
                dadosFiltrados.push(itemFiltrado)
            })
            return dadosFiltrados
        }
    }
}
</script>

<style scoped>

</style>
