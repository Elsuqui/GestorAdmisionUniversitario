<template>
    <panel titulo="Envío manual de correo electrónico">
        <div slot="content">
            <el-row>
                <el-col :span="4">
                    <el-input
                        @input="buscarFiltrado"
                        style="margin-top: 20px"
                        size="mini"
                        placeholder="Búsqueda..."
                        suffix-icon="el-icon-search"
                        v-model="filtros_report_mail.q">
                    </el-input>
                </el-col>
                <el-col :offset="5" :span="10">
                    <el-date-picker
                        style="margin-top: 20px;"
                        size="mini"
                        v-model="rango_fecha"
                        type="daterange"
                        range-separator="Hasta"
                        start-placeholder="Fecha inicial"
                        end-placeholder="Fecha final"
                        format="yyyy-MM-dd"
                        value-format="yyyy-MM-dd"
                        @change="escogerRangoFecha"
                        :clearable="false">
                        <div slot="range-separator" style="padding: 0 18px;">
                            <label>Hasta</label>
                        </div>
                    </el-date-picker>
                </el-col>
                <el-col :span="5">

                </el-col>
            </el-row>
            <br/>
            <el-table :data="listado"
                      border
                      size="medium"
                      :cell-style="obtenerColor">
                <el-table-column prop="" label="Interesado">
                        <template slot-scope="scope">
                            {{ scope.row.nombres }}<br/>
                            <el-tag size="mini">{{ scope.row.cedula }}</el-tag>
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
                    <div slot-scope="scope" style="color: white;">
                        <div v-for="interes in scope.row.intereses">
                            {{ obtenerEnum(interes.estado_interes) }}
                        </div>
                    </div>
                </el-table-column>
                <el-table-column
                    fixed="right"
                    label="Operaciones">
                    <template slot-scope="scope">
                        <div v-for="interes in scope.row.intereses">
                            <el-button size="small" @click="enviarMailInformativo(scope.row)" icon="el-icon-message">Enviar correo</el-button>
                        </div>
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
                listado: [],
                colores: [],
                filtros_report_mail: {
                    q: '',
                    fecha_desde: null,
                    fecha_hasta: null,
                },
                rango_fecha: null
            }
        },
        async mounted(){
            this.rango_fecha = [
                this.formatDate(new Date()),
                this.formatDate(new Date(new Date().setDate(new Date().getDate() + 1)))
            ];
            this.escogerRangoFecha(this.rango_fecha);
            // Se manda a buscar el listado de las personas que están pendientes de enviar notifificacion de mail
        },
        components: {
            ElTable: () => import("element-ui/lib/table"),
            ElTableColumn: () => import("element-ui/lib/table-column"),
            ElTag: () => import("element-ui/lib/tag"),
            Panel: () => import("@components/PanelComponent"),
            ElRow: () => import("element-ui/lib/row"),
            ElCol: () => import("element-ui/lib/col"),
            ElDatePicker: () => import("element-ui/lib/date-picker"),
            Elnput: () => import("element-ui/lib/input")
        },
        methods: {
            obtenerEnum(key){
                return enums.obtenerEstado(key);
            },
            obtenerColor({row, column, columnIndex}){
                if(columnIndex === 4){
                    if(row.intereses.length > 0){
                        return 'background-color: ' + enums.obtenerColor(row.intereses[0].estado_interes);
                    }
                }
            },
            async enviarMailInformativo(interes){
                let { data } = await apiMail.enviarMailInformativo(interes);
                this.actualizarTabla();
            },
            async actualizarTabla(){
                let { data } = await apiMail.listadoPersonasInteresadas(this.filtros_report_mail);
                this.listado = data;
            },
            async escogerRangoFecha(valor){
                this.filtros_report_mail.fecha_desde = valor[0];
                this.filtros_report_mail.fecha_hasta = valor[1];
                this.actualizarTabla();
            },
            buscarFiltrado: _.debounce(function (){
                this.actualizarTabla();
            }, 500),

            formatDate(date){
                var dd = date.getDate();
                var mm = date.getMonth() + 1;

                var yyyy = date.getFullYear();

                if (dd < 10) {
                    dd = '0' + dd;
                }
                if (mm < 10) {
                    mm = '0' + mm;
                }
                return  yyyy + '-' + mm + '-' + dd;
            },
        }
    }
</script>

<style scoped>

</style>
