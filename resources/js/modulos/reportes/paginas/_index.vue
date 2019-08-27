<template>
    <panel titulo="Página principal de reportería">
        <div slot="content">
            <el-row>
                <el-col :span="10">
                    <div style="margin-top: 20px">
                        <el-radio-group v-model="filtros_report.tipo_consulta" size="mini" @change="escogerFiltroEstado">
                            <el-radio-button label="1">Estudiante</el-radio-button>
                            <el-radio-button label="2">Operador</el-radio-button>
                        </el-radio-group>
                    </div>
                </el-col>
                <el-col :span="10">
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
                <el-col :span="4">
                    <el-input
                        @input="buscarFiltrado"
                        style="margin-top: 20px"
                        size="mini"
                        placeholder="Búsqueda..."
                        suffix-icon="el-icon-search"
                        v-model="filtros_report.q">
                    </el-input>
                </el-col>
            </el-row>
            <br/>
            <el-row>
                <el-col>
                    <el-button type="primary" @click="exportPdf">Exportar PDF</el-button>
                </el-col>
            </el-row>

            <el-table style="max-height: calc(100vh - 25vh);" height="75vh" :data="llamadas_report" v-if="llamadas_report"
                      :cell-class-name="obtenerColor">
                <el-table-column prop="" label="Interesado">
                    <template slot-scope="{ row }">
                        {{ row.interesado.persona.nombres }}
                    </template>
                </el-table-column>
                <el-table-column label="Contactos">
                    <template slot-scope="{ row }">
                        <div v-for="contacto in row.interesado.persona.contactos">
                            {{ contacto.tipo_contacto.descripcion + ': ' }} <el-tag size="mini">{{ contacto.valor }}</el-tag>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column prop="" label="Facultad">
                    <template slot-scope="{ row }">
                        {{ row.interesado.carrera.facultad.nombre}}
                    </template>
                </el-table-column>
                <el-table-column prop="" label="Carrera">
                    <template slot-scope="{ row }">
                        {{ row.interesado.carrera.nombre}}
                    </template>
                </el-table-column>
                <el-table-column label="Estado">
                    <template slot-scope="{ row }">
                        {{ obtenerEnumRespuestaLlamada(row.respuesta) }}
                    </template>
                </el-table-column>
                <el-table-column label="Observación">
                    <template slot-scope="{ row }">
                        {{ row.observacion }}
                    </template>
                </el-table-column>
                <el-table-column label="Operador">
                    <template slot-scope="{ row }">
                        {{ row.usuario_llamada.name }}
                    </template>
                </el-table-column>
                <el-table-column label="Fecha">
                    <template slot-scope="{ row }">
                        {{ row.created_at }}
                    </template>
                </el-table-column>
            </el-table>

        </div>
    </panel>
</template>

<script>
    import apiLlamadas from "@api/llamadas";
    import enumsRespuestasLlamadas from "../../../enums/respuestasLlamadas";
    import jsPDF from "jspdf";
    import "jspdf-autotable";

    export default {
        name: "index",
        components: {
            Panel: () => import("@components/PanelComponent"),
            ElRow: () => import("element-ui/lib/row"),
            ElCol: () => import("element-ui/lib/col"),
            ElRadioGroup: () => import("element-ui/lib/radio-group"),
            ElRadioButton: () => import("element-ui/lib/radio-button"),
            ElDatePicker: () => import("element-ui/lib/date-picker"),
            ElTable: () => import("element-ui/lib/table"),
            ElTableColumn: () => import("element-ui/lib/table-column"),
            Elnput: () => import("element-ui/lib/input")
        },
        mounted(){
            this.rango_fecha = [
                this.formatDate(new Date()),
                this.formatDate(new Date(new Date().setDate(new Date().getDate() + 1)))
            ];

            this.escogerRangoFecha(this.rango_fecha);
            console.log("Reporte: ", this.llamadas_report);
        },
        data(){
            return {
                filtros_report:{
                    tipo_consulta: 1,
                    fecha_desde: null,
                    fecha_hasta: null,
                    q: ''
                },
                rango_fecha: null,
                llamadas_report: [],
            }
        },
        methods:{
            escogerFiltroEstado(valor){
                this.filtros_report.estado = valor;
                this.recargarTabla();
            },
            async escogerRangoFecha(valor){
                this.filtros_report.fecha_desde = valor[0];
                this.filtros_report.fecha_hasta = valor[1];
                this.recargarTabla();
            },
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
            async recargarTabla(){
                let { data } = await apiLlamadas.listadoLlamadas(this.filtros_report);
                this.llamadas_report = data;
            },
            obtenerEnumRespuestaLlamada(key){
                return enumsRespuestasLlamadas.obtenerEstado(key);
            },
            buscarFiltrado: _.debounce(function (){
                this.recargarTabla();
            }, 500),
            obtenerColor({row, column, rowIndex, columnIndex}){
                if(Number.parseInt(this.filtros_report.tipo_consulta) === 1){
                    if(columnIndex === 0){
                        return 'colorear';
                    }
                }else{
                    if(columnIndex === 6){
                        return 'colorear';
                    }
                }
            },
            exportPdf(){
                //let cabecera_reporte = ['Interesado', ''];
                var doc = new jsPDF({
                    orientation: 'landscape',
                    unit: 'px',
                });

                //doc.text('Hello world!', 10, 10)
                console.log("Datos: ", this.llamadas_report);
                var datos = [{
                   valor: "esto es lo primero",
                   texto: "segundo campo"
                }];

                var header = this.createHeaders([
                    "Interesado",
                    "Facultad",
                    "Carrera",
                    "Estado",
                    "Observacion",
                    "Operador",
                    "Fecha"]);

                var cabecera = [
                    "Interesado",
                    "Facultad",
                    "Carrera",
                    "Estado",
                    "Observacion",
                    "Operador",
                    "Fecha"];

                //var data = this.mapReport(this.llamadas_report);
                //doc.setFontSize(5);
                //doc.table(1, 1, data, header);
                doc.autoTable({
                    body: this.mapReport(this.llamadas_report),
                    columns: this.crearCabecera(cabecera)
                });
                doc.save('reporte.pdf');
            },

            createHeaders(keys) {
                return keys.map(key => ({
                    'name': key,
                    'prompt': key,
                    'width':70,
                    'height': 10,
                    'align':'center',
                    'padding':0,
                    'fontSize': 5,
                    'margins': 0
                }));
            },

            crearCabecera(keys){
                return keys.map(key => ({
                    header: key,
                    dataKey: key
                }));
            },

            mapReport(datos){
                console.log("Data", datos);
                let dati = datos.map(data => ({
                    Interesado: data.interesado.persona.nombres,
                    Facultad: data.interesado.carrera.facultad.nombre,
                    Carrera: data.interesado.carrera.nombre,
                    Estado: this.obtenerEnumRespuestaLlamada(data.respuesta),
                    Observacion: data.observacion,
                    Operador: data.usuario_llamada.name,
                    Fecha: data.created_at
                }));
                console.log("Data transformada: ", dati);
                return dati;
            }
        }
    }
</script>

<style>
    .colorear{
        background-color: #ffcc80;
    }
</style>
