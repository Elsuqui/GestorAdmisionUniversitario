<template>
    <panel titulo="Envío manual de correo electrónico">
        <div slot="content">
            <el-table :data="listado"
                      border
                      size="medium">
                <el-table-column prop="" label="Interesado">
                        <template slot-scope="scope">
                            {{ scope.row.nombres }}
                        </template>
                </el-table-column>
                <el-table-column label="Contactos">
                    <template slot-scope="scope">
                        <div v-for="contacto in scope.row.contactos">
                            {{ contacto.tipo_contacto.descripcion + ': ' }} <el-tag size="mini">{{ contacto.valor }}</el-tag>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column prop="" label="Facultad">
                        <template slot-scope="scope">
                            <div v-for="interes in scope.row.intereses">
                                {{ interes.carrera.facultad.nombre }}
                            </div>
                        </template>
                </el-table-column>
                <el-table-column prop="" label="Carrera">
                    <template slot-scope="scope">
                        <div v-for="interes in scope.row.intereses">
                            {{ interes.carrera.nombre }}
                        </div>
                    </template>
                </el-table-column>
                <el-table-column label="Estado">
                    <template slot-scope="scope">
                        <div v-for="interes in scope.row.intereses">
                            {{ obtenerEnum(interes.estado_interes) }}
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                    fixed="right"
                    label="Operaciones">
                    <template slot-scope="scope">
                        <el-button size="small" @click="enviarMailInformativo(scope.row)" icon="el-icon-message">Enviar correo</el-button>
                    </template>
                </el-table-column>
                <template slot="empty">
                    <div style="padding: 5%; font-size: x-large;">Sin datos <i class="el-icon-search"></i></div>
                </template>
            </el-table>
        </div>
    </panel>
</template>

<script>
    import apiMail from "@api/mail";
    import enums from "../../../enums/estadosInteres";

    export default {
        name: "index",
        data() {
            return {
                listado: []
            }
        },
        async mounted(){
            // Se manda a buscar el listado de las personas que están pendientes de enviar notifificacion de mail
            let { data } = await apiMail.listadoPersonasInteresadas();
            this.listado = data;
            console.log("Listado: ", this.listado);
            console.log("Datos: ", data);
        },
        components: {
            ElTable: () => import("element-ui/lib/table"),
            ElTableColumn: () => import("element-ui/lib/table-column"),
            ElTag: () => import("element-ui/lib/tag"),
            Panel: () => import("@components/PanelComponent")
        },
        methods: {
            obtenerEnum(key){
                return enums.obtenerEstado(key);
            },
            async enviarMailInformativo(interes){
                let { data } = await apiMail.enviarMailInformativo(interes);
            }
        }
    }
</script>

<style scoped>

</style>
