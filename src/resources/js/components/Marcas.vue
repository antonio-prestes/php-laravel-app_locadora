<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Buscar marcas</div>
                    <div class="card-body">
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
                    </div>
                </div>
                <div class="card mt-2">
                <div class="card-header">Marcas</div>
                    <div class="card-body">
                        <div>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">First</th>
                                    <th scope="col">Last</th>
                                    <th scope="col">Handle</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td colspan="2">Larry the Bird</td>
                                    <td>@twitter</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-primary float-end">Adicionar</button>
                    </div>
                </div>
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
