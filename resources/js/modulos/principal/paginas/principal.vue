<template>
    <div>
        <h1>Sistema de Gestión para la Admisión Universitaria</h1>
        <el-row>
            <el-col :span="8" :offset="2">
                <el-card shadow="always" header="Interesados según su estado">
                    <pie-chart v-if="loaded" :chart-data="datos_pie" :options="opciones_pie"></pie-chart>
                </el-card>
            </el-col>
            <el-col :span="8" :offset="2">
                <el-card>
                    <div slot="header" style="text-align: center;"><label>Número de personas ingresadas este mes</label></div>
                    <div class="contador_personas">{{ contador_personas }}</div>
                </el-card>
            </el-col>
            <!--<el-col :span="8">
                <el-card shadow="always" header="Ingresados los últimos 4 semestres">
                    <bar-chart :chart-data="datos_bar"></bar-chart>
                </el-card>
            </el-col>-->
        </el-row>
    </div>
</template>

<script>
    import PieChart from "../componentes/PieChart";
    import BarChart from "../componentes/BarChart";
    import apiAdmision from "@api/admision";

    export default {
        name: "principal",
        components:{
            PieChart,
            BarChart,
            ElRow: () => import("element-ui/lib/row"),
            ElCol: () => import("element-ui/lib/col"),
            ElCard: () => import("element-ui/lib/card")
        },
        data(){
            return {
                /*datos_bar: {
                    labels:["Mayo - 2018", "Octubre - 2018", "Mayo - 2019", "Octubre - 2019"],
                    datasets:[
                      {
                          data: [20, 8, 10, 30]
                      }
                  ]
                },*/
                loaded: false,
                datos_pie: {
                    labels: [
                        'Interesados',
                        'No interesados',
                        'En Carrera'
                    ],
                    fullWidth: false,
                    datasets: [
                        {
                            data: [],
                            backgroundColor: [
                                "#82E0AA",
                                "#2C3E50",
                                "#85C1E9"
                            ],
                            hoverBackgroundColor:[
                                "#82E0AA",
                                "#2C3E50",
                                "#85C1E9"
                            ]
                        }
                    ],
                    weight: 1
                },
                opciones_pie:{
                    title: {
                        display: true,
                        text: 'Interesados'
                    }
                },
                contador_personas: 0
            }
        },
        async mounted() {
            this.loaded = false;
            let { data } = await apiAdmision.reporteAdmision();
            console.log("Reporte: ", data);
            this.$set(this.datos_pie.datasets[0], "data", data);
            this.loaded = true;
            this.cargarPersonasIngresadas();
        },
        methods:{
            async cargarPersonasIngresadas(){
                let { data } = await apiAdmision.reporteNumeroIngresados();
                this.contador_personas = data;
            }
        }
    }
</script>

<style scoped>
    .contador_personas{
        font-size: 100px;
        text-align: center;
    }
</style>
