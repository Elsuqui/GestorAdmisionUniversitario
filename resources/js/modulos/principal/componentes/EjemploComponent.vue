<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Ejemplo Componente</div>

                    <div class="card-body">
                        Yo soy un componente
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        //name: "EjemploComponent",
        mounted() {
            console.log('Componente montado.');
        }
    }
</script>

<style scoped>

</style>
