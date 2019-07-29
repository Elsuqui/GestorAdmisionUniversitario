<template>
    <div>
        <el-button :class="estado_actual === 3 ? 'active' : 'disabled'" @click="setState(3)" circle type="success" size="mini" style="width: 30px;">I</el-button>
        <el-button :class="estado_actual === 4 ? 'active' : 'disabled'" @click="setState(4)" circle size="mini" type="danger" style="width: 30px;">NI</el-button>
        <el-button :class="estado_actual === 5 ? 'active' : 'disabled'" @click="setState(5)" circle size="mini" type="info" style="width: 30px;">EC</el-button>
    </div>
</template>

<script>
    import apiAdmision from "@api/admision";
    export default {
        name: "estados_interes",
        components: {
            ElButton: () => import("element-ui/lib/button")
        },
        props:{
            estado: {required: true, type: Number},
            interes: {required: true, type: Number}
        },
        mounted(){
            this.estado_actual = this.estado;
        },
        data(){
            return{
                estado_actual: 0
            }
        },
        methods:{
            setState(valor){
                this.$confirm("¿Desea cambiar el estado del interés?", "Cambiar estado", {
                    confirmButtonText: 'Continuar',
                    cancelButtonText: 'Cancelar',
                    type: 'warning',
                    center: true
                }).then(async () => {
                    this.estado_actual = valor;
                    let { data } = await apiAdmision.cambiarEstadoInteres({
                        interes: this.interes,
                        estado: this.estado_actual
                    });
                    if(data){
                        this.$notify.success({
                            title: 'Guardado exitoso!',
                            message: 'El estado de interés ha sido cambiado'
                        });
                    }else{
                        this.$notify.error({
                            title: 'Guardado fallido!',
                            message: 'Error al cambiar el estado de interés'
                        });
                    }
                }).catch(() => {

                });
            }
        }
    }
</script>

<style scoped>
    .active {
        opacity: 1;
    }

    .disabled{
        opacity: 0.3;
    }

    .disabled:hover{
        opacity: 1;
    }

</style>
