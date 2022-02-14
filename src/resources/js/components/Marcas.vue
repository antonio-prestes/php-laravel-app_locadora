<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <card-component titulo="buscar marcas">
                    <div class="row">
                        <div class="col-3">
                            <input-container-component titulo="" id="inputId" id-help="idHelp"
                                                       texto-ajuda="ID da Marca">
                                <input type="number" class="form-control" id="inputId" aria-describedby="idHelp"
                                       placeholder="ID" v-model="busca.id"/>
                            </input-container-component>
                        </div>
                        <div class="col">
                            <input-container-component titulo="" id="inputNome" id-help="nomeHelp"
                                                       texto-ajuda="Nome da marca">
                                <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp"
                                       placeholder="Nome" v-model="busca.nome"/>
                            </input-container-component>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary float-end" @click="pesquisar()">Pesquisar
                            </button>
                        </div>
                    </div>
                </card-component>

                <card-component titulo="Marcas">
                    <table-component :dados="marcas.data"
                                     :visualizar = true
                                     :editar = true
                                     :excluir = true
                                     :titulos="{
                                                id: {titulo: 'ID', tipo: 'text'},
                                                nome: {titulo: 'Nome', tipo: 'text'},
                                                imagem: {titulo: 'Imagem', tipo: 'img'},
                                                created_at: {titulo: 'Data de criação', tipo: 'data'},
                                     }"
                    ></table-component>
                    <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modalMarca">
                        Adicionar
                    </button>
                    <paginate-component>
                        <li :class="l.active ? 'page-item active' : 'page-item'" v-for="l, key in marcas.links"
                            :key="key" @click="paginacao(l)">
                            <a class="page-link" v-html="l.label"></a>
                        </li>
                    </paginate-component>
                </card-component>


            </div>
        </div>

        <modal-component titulo="Adicionar marca" id="modalMarca">

            <template v-slot:alertas>
                <alert-component tipo="danger" :message="transacaoMessage" v-if="transacaoStatus === 'error'"
                                 title="Erro ao cadastrar Marca"></alert-component>
                <alert-component tipo="success" :message="transacaoMessage" v-if="transacaoStatus === 'success'"
                                 title="Marca cadastrada com sucesso"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="" id="inputNovaMarca" id-help="inputNovaMarcaHelp"
                                               texto-ajuda="Nome da marca">
                        <input type="text" class="form-control" id="inputNovaMarca"
                               aria-describedby="inputNovaMarcaHelp"
                               placeholder="Nome" v-model="nomeMarca"/>
                    </input-container-component>
                    <input-container-component titulo="" id="inputLogo" id-help="inputLogoHelp"
                                               texto-ajuda="Logo da marca">
                        <input type="file" class="form-control" id="inputLogo" aria-describedby="inputLogoHelp"
                               @change="carregarImagem($event)"/>
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>

        </modal-component>

    </div>
</template>

<script>
export default {
    name: "Marcas",
    data() {
        return {
            urlBase: 'http://localhost:80/api/v1/marca',
            urlFiltro: '',
            urlPaginacao: '',
            nomeMarca: '',
            logoMarca: [],
            transacaoStatus: '',
            transacaoMessage: {},
            marcas: {data: []},
            busca: {id: '', nome: ''}
        }
    },
    methods: {
        pesquisar() {
            let filtro = ''

            for (let chave in this.busca) {
                if (this.busca[chave]) {
                    if (filtro != '') {
                        filtro += ";"
                    }
                    filtro += chave + ':like:' + '%'+this.busca[chave]+'%'
                }
            }
            if (filtro != '') {
                this.urlPaginacao = 'page=1'
                this.urlFiltro = '&filtro=' + filtro
            } else {
                this.urlFiltro = ''
            }
            this.carregarLista()
        },
        paginacao(l) {
            if (l.url) {
                this.urlPaginacao = l.url.split('?')[1]
                this.carregarLista()
            }
        },
        carregarLista() {

            let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro

            axios.get(url)
                .then(response => {
                    this.marcas = response.data
                })
                .catch(errors => {
                    console.log(errors)
                })
        },

        carregarImagem(e) {
            this.logoMarca = e.target.files
        },
        salvar() {

            let formData = new FormData()
            formData.append('nome', this.nomeMarca)
            formData.append('imagem', this.logoMarca[0])

            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Accept': 'application/json'
                }
            }

            axios.post(this.urlBase, formData, config)
                .then(response => {
                    this.transacaoStatus = 'success'
                    this.transacaoMessage = {
                        message: 'ID da narca: ' + response.data.id
                    }
                })
                .catch(errors => {
                    this.transacaoStatus = 'error'
                    this.transacaoMessage = {
                        message: errors.response.data.message,
                        dados: errors.response.data.errors
                    }
                })
        }
    },
    mounted() {
        this.carregarLista()
    }
}
</script>

<style scoped>

</style>
