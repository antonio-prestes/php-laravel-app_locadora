<template>
    <div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col" v-for="titulo, key in titulos" :key="key">{{ titulo.titulo }}</th>
                <th v-if="excluir || editar || visualizar.visivel"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                <td v-for="valor, chaveValor in obj" :key="chaveValor">
                    <span v-if="titulos[chaveValor].tipo === 'text'">{{ valor }}</span>
                    <span v-if="titulos[chaveValor].tipo === 'data'">{{ valor | formatDate }}</span>
                    <span v-if="titulos[chaveValor].tipo === 'img'">
                        <img :src="'/app/public/'+valor" alt="imagemlogo" width="30px">
                    </span>
                </td>
                <td v-if="excluir || editar || visualizar">
                    <button v-if="visualizar.visivel" class="btn btn-outline-primary btn-sm" :data-bs-toggle="visualizar.dataToggle" :data-bs-target="visualizar.dataTarget">Visualizar</button>
                    <button v-if="editar" class="btn btn-outline-info btn-sm">Editar</button>
                    <button v-if="excluir" class="btn btn-outline-danger btn-sm float-end">Excluir</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "Table",
    props: ['dados', 'titulos', 'visualizar', 'editar', 'excluir'],
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
