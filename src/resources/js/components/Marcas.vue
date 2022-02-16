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
                                     :visualizar="{visivel: true, dataTarget: '#modalMarcaVisualizar', dataToggle: 'modal'}"
                                     :editar=true
                                     :excluir="{visivel: true, dataTarget: '#modalMarcaExcluir', dataToggle: 'modal'}"
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

        <!-- inicio modal inserir marca -->
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
                <button type="button" class="btn btn-success" @click="salvar()">Salvar</button>
            </template>
        </modal-component>
        <!-- fim modal inserir marca -->

        <!-- inicio modal visualizar marca -->
        <modal-component titulo="Visualizar marca" id="modalMarcaVisualizar">
            <template v-slot:alertas></template>
            <template v-slot:conteudo>

                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>
                <input-container-component titulo="Nome da marca">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                </input-container-component>
                <input-container-component titulo="Data criação">
                    <span type="text" class="form-control" >{{ $store.state.item.created_at | formatDate }}</span>
                </input-container-component>
                <input-container-component titulo="Imagem">
                    <img :src="'/app/public/'+$store.state.item.imagem" v-if="$store.state.item.imagem" alt="imagemlogo" width="200px">
                </input-container-component>

            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </template>
        </modal-component>
        <!-- fim modal visualizar marca -->

        <!-- inicio modal excluir marca -->
        <modal-component titulo="Excluir marca" id="modalMarcaExcluir">
            <template v-slot:alertas>
                <alert-component tipo="danger" :message="$store.state.transacao" v-if="$store.state.transacao.status === 'error'"
                                 title="Erro!"></alert-component>
                <alert-component tipo="success" :message="$store.state.transacao" v-if="$store.state.transacao.status === 'success'"
                                 title="Transação realizada!"></alert-component>
            </template>
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'success'">

                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>
                <input-container-component titulo="Nome da marca">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                </input-container-component>

            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" @click="excluir()" v-if="$store.state.transacao.status != 'success'">Excluir</button>
            </template>
        </modal-component>
        <!-- fim modal excluir marca -->
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
        excluir(){
            let confirmacao = confirm('Tem certeza que deseja remover este registro?')

            if(!confirmacao) return false


            let url = this.urlBase +"/" + this.$store.state.item.id
            let formData = new FormData()
            formData.append('_method', 'delete')
            let config = {
                headers: {
                    'Authorization': this.token,
                    'Accept': 'application/json'
                }
            }

            axios.post(url, formData, config)
                .then(response => {
                    this.$store.state.transacao.status = 'success'
                    this.$store.state.transacao.message = response.data.msg
                    this.carregarLista()
                })
                .catch(errors => {
                    console.log(errors)
                    this.$store.state.transacao.status = 'error'
                    this.$store.state.transacao.message = errors.response.data.erro
                })
        },
        pesquisar() {
            let filtro = ''

            for (let chave in this.busca) {
                if (this.busca[chave]) {
                    if (filtro != '') {
                        filtro += ";"
                    }
                    filtro += chave + ':like:' + '%' + this.busca[chave] + '%'
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
                    this.carregarLista()
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
