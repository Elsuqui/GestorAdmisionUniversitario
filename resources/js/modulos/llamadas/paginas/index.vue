<template>
    <div>
        <panel titulo="Gestión y control de llamadas" id="control_llamadas">
            <template slot="content">
                <el-divider><i class="el-icon-s-grid"></i> INTERESADOS </el-divider>
                <el-row>
                    <el-col :span="10">
                        <div style="margin-top: 20px">
                            <el-radio-group v-model="filtros_interesados_report.estado" size="mini" @change="cambiarFiltroInteresado">
                                <el-radio-button label="1">No contactado</el-radio-button>
                                <el-radio-button label="2">Devolver llamada</el-radio-button>
                            </el-radio-group>
                        </div>
                    </el-col>
                    <el-col :span="10">
                        <el-date-picker
                            style="margin-top: 20px;"
                            size="mini"
                            v-model="rango_fecha_interesados"
                            type="daterange"
                            range-separator="Hasta"
                            start-placeholder="Fecha inicial"
                            end-placeholder="Fecha final"
                            format="yyyy-MM-dd"
                            value-format="yyyy-MM-dd"
                            @change="escogerRangoFechaInteresados"
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
                            v-model="filtros_interesados_report.q">
                        </el-input>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="24">
                            <el-table :data="interesados" v-loading="cargando_interesados" element-loading-text="Cargando interesados..." style="max-height: calc(100vh - 40vh);" height="60vh" @cell-dblclick="procesarNuevaLlamada" row-class-name="fila_reporte_llamada">
                                <el-table-column label="Interesado">
                                    <template slot-scope="{ row }">
                                        {{ row.persona.nombres }}<br/>
                                        <el-tag size="mini">{{ row.persona.cedula }}</el-tag>
                                    </template>
                                </el-table-column>
                                <el-table-column label="Telefonos">
                                    <template slot-scope="{ row }">
                                        <div v-for="contacto in row.persona.contactos">
                                            {{ contacto.tipo_contacto.descripcion + ': ' }} <el-tag size="mini">{{ contacto.valor }}</el-tag>
                                        </div>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="" label="Facultad">
                                    <template slot-scope="{ row }">
                                            {{ row.carrera.facultad.nombre }}
                                    </template>
                                </el-table-column>
                                <el-table-column prop="" label="Carrera">
                                    <template slot-scope="{ row }">
                                            {{ row.carrera.nombre }}
                                    </template>
                                </el-table-column>
                                <el-table-column label="Última llamada">
                                    <template slot-scope="{ row }">
                                        {{ (row.ultima_llamada) ? row.ultima_llamada.created_at : '----' }}
                                    </template>
                                </el-table-column>
                                <el-table-column label="Observación">
                                    <template slot-scope="{ row }">
                                        {{ (row.ultima_llamada) ? row.ultima_llamada.observacion : '----' }}
                                    </template>
                                </el-table-column>
                            </el-table>
                    </el-col>
                </el-row>
                <br/>
            </template>
        </panel>

        <el-dialog :visible.sync="nueva_llamada_modal_table_visible"
                   :close-on-click-modal="false"
                   title="Registrar llamada"
                   width="30%"
                   center>
            <el-divider content-position="left">Llenar información</el-divider>
            <el-row style="text-align: center; padding-bottom: 20px;">
                <el-col :span="10">
                    <label style="font-size: 18px;">Interesado: </label>
                </el-col>
                <el-col :offset="2" :span="10">
                    <el-tag v-if="info_interesado_table_selected">
                        {{ info_interesado_table_selected.persona.cedula  + " - " + info_interesado_table_selected.persona.nombres }}
                    </el-tag>
                </el-col>
            </el-row>
            <el-row style="text-align: center; padding-bottom: 20px;">
                <el-col :span="10">
                    <label style="font-size: 18px;">Estado Interes: </label>
                </el-col>
                <el-col :offset="2" :span="10">
                    <el-select v-model="interes_selected_table_selected"
                               filterable
                               value-key="key"
                               size="mini"
                               placeholder="Seleccionar estado...">
                        <el-option
                            v-for="(item, key) in intereses_table"
                            :key="key"
                            :label="item.value"
                            :value="item">
                        </el-option>
                    </el-select>
                </el-col>
            </el-row>
            <el-row style="text-align: center; padding-bottom: 20px;" v-if="interes_selected_table_selected.key === 3">
                <el-col :span="10">
                    <label style="font-size: 18px;">¿Devolver llamada? </label>
                </el-col>
                <el-col :offset="2" :span="10">
                    <el-checkbox v-model="devolver_llamada_checked"> devolver</el-checkbox>
                </el-col>
            </el-row>
            <el-row style="text-align: center; padding-bottom: 20px;">
                <el-col :span="10">
                    <label style="font-size: 18px;">Observación: </label>
                </el-col>
                <el-col :offset="2" :span="10">
                    <el-input
                        type="textarea"
                        :rows="3"
                        placeholder="Escriba una observación..."
                        v-model="nueva_llamada_observacion_table">
                    </el-input>
                </el-col>
            </el-row>
            <el-row style="text-align: center; padding-bottom: 20px;">
                <el-button type="primary" size="mini" icon="el-icon-plus" @click="agregarLlamadaTabla">Registrar información</el-button>
            </el-row>
        </el-dialog>
    </div>
</template>

<script>
    import apiPersonas from "@api/personas";
    import apiLlamadas from "@api/llamadas";
    import enumsRespuestasLlamadas from "../../../enums/respuestasLlamadas";
    import enumsEstadosInteres from "../../../enums/estadosInteres";

    export default {
        name: "index",
        components: {
            Panel: () => import("@components/PanelComponent"),
            ElRow: () => import("element-ui/lib/row"),
            ElCol: () => import("element-ui/lib/col"),
            ElButton: () => import("element-ui/lib/button"),
            ElCard: () => import("element-ui/lib/card"),
            ElDialog: () => import("element-ui/lib/dialog"),
            ElSelect: () => import("element-ui/lib/select"),
            ElOption: () => import("element-ui/lib/option"),
            ElTable: () => import("element-ui/lib/table"),
            ElTableColumn: () => import("element-ui/lib/table-column"),
            ElInput: () => import("element-ui/lib/input"),
            EDivider: () => import("element-ui/lib/divider"),
            ElPopover: () => import("element-ui/lib/popover"),
            ElDivider: () => import("element-ui/lib/divider"),
            EstadosInteres: () => import("../componentes/estados_interes"),
            ElDatePicker: () => import("element-ui/lib/date-picker")
        },
        async mounted(){
          //Inicializar las fechas con las de hoy
            this.rango_fecha = [
                this.formatDate(new Date()),
                this.formatDate(new Date(new Date().setDate(new Date().getDate() + 1)))
            ];

            this.rango_fecha_interesados = this.rango_fecha;

            this.escogerRangoFechaLlamadas(this.rango_fecha);
            this.escogerRangoFechaInteresados(this.rango_fecha);
            /*let { data } = await apiPersonas.listadoIntereses(this.filtros_intereses_report);
            console.log("Datos: ", data);
            this.intereses_report = data;*/
        },
        data(){
            return {
                info_interesado_selected: null,
                info_interesado_loading: false,
                interes_selected: null,
                intereses: [],
                intereses_table: [],
                llamadas: [],
                interesados: [],
                respuesta_selected: "2",
                info_list_interesados: [],
                info_list_respuestas: enumsRespuestasLlamadas.obtener_listado(),
                nueva_llamada_modal_visible: false,
                nueva_llamada_observacion: "",
                nueva_llamada_modal_table_visible: false,
                info_interesado_table_selected: null,
                interes_selected_table_selected: enumsEstadosInteres.obtenerEstadoInteresPorClave(3),
                respuesta_selected_table: "2",
                nueva_llamada_observacion_table: "",
                intereses_report: [],
                rango_fecha: null,
                rango_fecha_interesados: null,
                filtros_intereses_report: {
                    estado: 1,
                    fecha_desde: '',
                    fecha_hasta: ''
                },
                filtros_interesados_report: {
                    estado: 1,
                    q: '',
                    fecha_desde: '',
                    fecha_hasta: ''
                },
                devolver_llamada_checked: false,
                cargando_interesados: false
            }
        },
        methods:{
            async modalLlamadaAbierto(){
                //this.intereses = this.info_interesado_selected.intereses;
            },
            buscarFiltrado: _.debounce(function (){
                this.recargarTablaInteresados();
            }, 500),

            abrirModalNuevaLlamada(){
                this.nueva_llamada_modal_visible = true;
            },
            historial_llamadas(valor){
                if(valor){
                    this.intereses = valor.intereses;
                }else{
                    this.intereses = [];
                }
                //console.log("Datos: ", valor);
            },
            async agregarLlamadaTabla(){
                /*console.log("Id_interesado", this.info_interesado_table_selected.id);
                console.log("Estado Interes: ", this.interes_selected_table_selected.key);
                console.log("Respuesta: ", this.respuesta_selected_table);
                console.log("Observacion: ", this.nueva_llamada_observacion_table);*/

                let { data } = await apiLlamadas.agregarLlamada({
                    id_interesado: this.info_interesado_table_selected.id,
                    respuesta: this.interes_selected_table_selected.key,
                    observacion: this.nueva_llamada_observacion_table,
                    devolver_llamada: this.devolver_llamada_checked
                });
                this.nueva_llamada_modal_table_visible = false;
                if(data){
                    this.$notify.success({
                        title: 'Guardado exitoso!',
                        message: 'La llamada ha sido registrada al sistema'
                    });
                }else{
                    this.$notify.error({
                        title: 'Guardado fallido!',
                        message: 'Error al ingresar la llamada al sistema'
                    });
                }
                this.intereses_table = enumsEstadosInteres.obtenerEstadoInteres();
                this.nueva_llamada_observacion_table = "";
                this.recargarTablaInteresados();
            },
            cargarLlamadas(interes){
                this.llamadas = interes.llamadas;
            },
            color_estado_interes(estado){
                let status = "";
                switch (estado) {
                    case 3:
                        status  = "success";
                        break;
                    case 4:
                        status = "danger";
                        break;
                    case 5:
                        status = "info";
                        break;
                    default:
                        status = "warning";
                        break;
                }
                return status;
            },
            label_estado_interes(estado){
                let label = "";
                switch (estado) {
                    case 3:
                        label  = "I";
                        break;
                    case 4:
                        label = "N.I";
                        break;
                    case 5:
                        label = "E.C";
                        break;
                    default:
                        label = "S.I";
                        break;
                }
                return label;
            },
            async escogerRangoFechaLlamadas(valor){
                console.log("Valor rango: ", valor);
                this.filtros_intereses_report.fecha_desde = valor[0];
                this.filtros_intereses_report.fecha_hasta = valor[1];
                this.recargarTablaLlamadas();
                /*let { data } = await apiPersonas.listadoIntereses(this.filtros_intereses_report);
                console.log("Datos: ", data);
                this.intereses_report = data;*/
            },
            async escogerRangoFechaInteresados(valor){
                this.filtros_interesados_report.fecha_desde = valor[0];
                this.filtros_interesados_report.fecha_hasta = valor[1];
                this.recargarTablaInteresados()
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
            obtenerEnumRespuestaLlamada(key){
                return enumsRespuestasLlamadas.obtenerEstado(key);
            },
            async recargarTablaLlamadas(){
                let { data } = await apiPersonas.listadoIntereses(this.filtros_intereses_report);
                this.intereses_report = data;
            },
            async recargarTablaInteresados(){
                this.cargando_interesados = true;
                let { data } = await apiPersonas.interesados(this.filtros_interesados_report);
                this.interesados = data;
                this.cargando_interesados = false;
            },
            escogerFiltroEstado(valor){
                this.filtros_intereses_report.estado = valor;
                this.recargarTablaLlamadas();
            },
            procesarNuevaLlamada(row, column, cell, event){
                this.intereses_table = [];
                this.nueva_llamada_modal_table_visible = true;
                this.devolver_llamada_checked = false;
                this.info_interesado_table_selected = row;
                this.intereses_table = enumsEstadosInteres.obtenerEstadoInteres();
            },
            cambiarFiltroInteresado(valor){
                this.filtros_interesados_report.estado = valor;
                this.recargarTablaInteresados();
            },
        }
    }
</script>

<style>
    #control_llamadas .el-row{
        margin-bottom: 20px;
    }

    .fila_reporte_llamada:hover {
        cursor: pointer;
    }

    .el-dialog__header {
        padding-bottom: 2px;
        background-color: black;
    }

    .el-dialog__title{
        color: white;
    }

    .el-dialog__body{
        padding-top: 2px;
    }

    .el-dialog__headerbtn .el-dialog__close{
        color: white;
    }

</style>
