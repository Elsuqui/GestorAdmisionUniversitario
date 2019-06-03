<template>
    <el-breadcrumb separator-class="el-icon-arrow-right">
        <el-breadcrumb-item :to="{ path: opcion.path }" :key="index" v-for="(opcion, index) in opciones">{{ opcion.label }}</el-breadcrumb-item>
    </el-breadcrumb>
</template>

<script>
    export default {
        name: "SeguidorRutaComponent",
        props: {
            ruta: { type: String, required: true }
        },
        mounted(){
            console.log("Ruta: ", this.ruta);
            this.mapearRutas();
            console.log("Opciones: ", this.opciones);
        },
        components:{
           ElBreadcrumb: () => import("element-ui/lib/breadcrumb"),
           ElBreadcrumbItem: () => import("element-ui/lib/breadcrumb-item")
        },
        data() {
            return {
                opciones: []
            }
        },
        watch: {
            ruta(){
                console.log("Ruta: ", this.ruta);
                this.opciones = [];
                this.mapearRutas();
                console.log("Opciones: ", this.opciones);
            }
        },
        methods:{
            mapearRutas(){
                let nivel_ruta = "";
                let nombres = this.ruta.split("/");
                nombres.forEach((value, index) => {
                    if(value !== ""){
                        nivel_ruta += "/" + value;
                        let objeto_ruta = {
                            label: value,
                            path: nivel_ruta
                        };
                        this.opciones.push(objeto_ruta);
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
