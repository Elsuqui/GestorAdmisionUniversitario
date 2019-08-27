<template>
    <div>
        <h1>Sistema de Gestión para la Admisión Universitaria</h1>
        <el-row>
            <el-col :span="6">
                <el-card shadow="always" header="Interesados según su estado">
                    <pie-chart :chart-data="datos_pie" :options="opciones_pie"></pie-chart>
                </el-card>
            </el-col>
            <el-col :span="16" :offset="2">
                <el-card shadow="always" header="Ingresados los últimos 4 semestres">
                    <bar-chart :chart-data="datos_bar"></bar-chart>
                </el-card>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    import PieChart from "../componentes/PieChart";
    import BarChart from "../componentes/BarChart";
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
                datos_bar: {
                    labels:["Mayo - 2018", "Octubre - 2018", "Mayo - 2019", "Octubre - 2019"],
                    datasets:[
                      {
                          data: [20, 8, 10, 30]
                      }
                  ]
                },

                datos_pie: {
                    labels: [
                        'Interesados',
                        'No interesados',
                        'En Carrera'
                    ],
                    fullWidth: false,
                    datasets: [
                        {
                            backgroundColor: [
                                "#82E0AA",
                                "#2C3E50",
                                "#85C1E9"
                            ],
                            data: [10, 20, 30],
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
                }
            }
        }
    }
</script>

<style scoped>

</style>
