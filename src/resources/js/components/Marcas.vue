<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <card-component titulo="buscar marcas">
                    <div class="row">
                        <div class="col-3">
                            <input-container-component titulo="" id="inputId" id-help="idHelp" texto-ajuda="ID da Marca">
                                <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID"></input>
                            </input-container-component>
                        </div>
                        <div class="col">
                            <input-container-component titulo="" id="inputNome" id-help="nomeHelp" texto-ajuda="Nome da marca">
                                <input type="number" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome"></input>
                            </input-container-component>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary float-end">Pesquisar</button>
                        </div>
                    </div>
                </card-component>

                <card-component titulo="Marcas">
                        <table-component></table-component>
                        <button class="btn btn-primary float-end">Adicionar</button>
                </card-component>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Marcas"
}
</script>

<style scoped>

</style>
