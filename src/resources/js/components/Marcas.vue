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
                                       placeholder="ID"/>
                            </input-container-component>
                        </div>
                        <div class="col">
                            <input-container-component titulo="" id="inputNome" id-help="nomeHelp"
                                                       texto-ajuda="Nome da marca">
                                <input type="number" class="form-control" id="inputNome" aria-describedby="nomeHelp"
                                       placeholder="Nome"/>
                            </input-container-component>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary float-end">Pesquisar</button>
                        </div>
                    </div>
                </card-component>

                <card-component titulo="Marcas">
                    <table-component></table-component>
                    <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modalMarca">
                        Adicionar
                    </button>
                </card-component>

            </div>
        </div>

        <modal-component titulo="Adicionar marca" id="modalMarca">
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
            nomeMarca: '',
            logoMarca: '',
        }
    },
    methods: {
        carregarImagem(e) {
            this.logoMarca = e.target.files
        },
        salvar() {
            console.log(this.nomeMarca, this.logoMarca[0])

            let formData = new FormData()
            formData.append('nome', this.nomeMarca)
            formData.append('imagem', this.logoMarca[0])

            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Accept': 'application/json'
                }
            }

            axios.post(this.urlBase, formData, config).then(response => {
                console.log(response)
            })
        }
    }
}
</script>

<style scoped>

</style>
