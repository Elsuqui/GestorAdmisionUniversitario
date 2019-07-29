<template>
    <div>
        <panel titulo="Gestión y control de llamadas" id="control_llamadas">
            <template slot="content">
                <el-row>
                    <el-col :span="8">
                        <el-card>
                            <template slot="header" class="clearfix">
                                <span>Interesado</span>
                                <el-button type="primary"
                                           v-show="info_interesado_selected"
                                           style="float: right; margin-top: -8px;"
                                           icon="el-icon-plus"
                                           size="mini" @click="abrirModalNuevaLlamada">Nueva llamada</el-button>
                            </template>
                            <el-select v-model="info_interesado_selected"
                                       style="width: 100%;"
                                       filterable
                                       remote
                                       value-key="id"
                                       clearable
                                       size="mini"
                                       @change="historial_llamadas"
                                       @clear="llamadas = []"
                                       :remote-method="buscarPersona"
                                       reserve-keyword
                                       :loading="info_interesado_loading"
                                       placeholder="Buscar persona...">
                                <el-option
                                    v-for="(item, key) in info_list_interesados"
                                    :key="key"
                                    :label="item.cedula + '-' + item.nombres"
                                    :value="item">
                                </el-option>
                            </el-select>
                            <br/>
                            <div v-if="info_interesado_selected" style="margin-top: 20px;">
                                <h4>Listado de intereses</h4>
                            </div>
                            <div v-if="info_interesado_selected" v-for="interes in intereses">
                                <el-row style="margin-top: 20px;">
                                    <el-col :span="16">{{ interes.carrera.facultad.nombre + ' - ' + interes.carrera.nombre }}</el-col>
                                    <el-col :span="4"><el-button type="primary" size="mini" icon="el-icon-right" @click="cargarLlamadas(interes)"></el-button></el-col>
                                    <el-col :span="4">
                                        <el-popover
                                            placement="right"
                                            title="Cambiar estado interés"
                                            width="400"
                                            trigger="click">
                                            <estados-interes :estado="interes.estado_interes" :interes="interes.id"></estados-interes>
                                            <el-button slot="reference"
                                                       :type="color_estado_interes(interes.estado_interes)"
                                                       size="mini">
                                                {{ label_estado_interes(interes.estado_interes) }}
                                            </el-button>
                                        </el-popover>
                                    </el-col>
                                </el-row>
                            </div>
                        </el-card>
                    </el-col>
                    <el-col :offset="2" :span="14">
                        <el-card header="Historial de llamadas">
                            <el-table :data="llamadas">
                                <el-table-column prop="created_at"
                                                 label="Fecha llamada">
                                </el-table-column>
                                <el-table-column label="Llamado por">
                                    <template slot-scope="{ row }">
                                        {{ row.usuario_llamada.name }}
                                    </template>
                                </el-table-column>
                                <el-table-column prop="respuesta" label="Respuesta">
                                </el-table-column>
                            </el-table>
                        </el-card>
                    </el-col>
                </el-row>
            </template>
        </panel>

        <el-dialog :visible.sync="nueva_llamada_modal_visible"
                   :close-on-click-modal="false"
                   title="Ingreso de nueva llamada"
                   @opened="modalLlamadaAbierto"
                   width="30%"
                   center>
            <el-divider content-position="left">Llenar información de nueva llamada</el-divider>
            <el-row style="text-align: center; padding-bottom: 20px;">
                <el-col :span="10">
                    <label style="font-size: 18px;">Interesado: </label>
                </el-col>
                <el-col :offset="2" :span="10">
                    <el-tag v-if="info_interesado_selected">
                        {{ info_interesado_selected.cedula  + " - " + info_interesado_selected.nombres }}
                    </el-tag>
                    <!--<el-select v-model="info_interesado_busqueda_selected"
                               filterable
                               size="mini"
                               placeholder="Buscar interesado...">
                        <el-option
                            v-for="item in info_list_interesados"
                            :key="item.value"
                            :label="item.label"
                            :value="item">
                        </el-option>
                    </el-select>-->
                </el-col>
            </el-row>
            <el-row style="text-align: center; padding-bottom: 20px;">
                <el-col :span="10">
                    <label style="font-size: 18px;">Intereses: </label>
                </el-col>
                <el-col :offset="2" :span="10">
                    <el-select v-model="interes_selected"
                               filterable
                               value-key="id"
                               size="mini"
                               placeholder="Seleccionar interés...">
                        <el-option
                            v-for="item in intereses"
                            :key="item.id"
                            :label="item.carrera.facultad.nombre + ' - ' + item.carrera.nombre"
                            :value="item">
                        </el-option>
                    </el-select>
                </el-col>
            </el-row>
            <el-row style="text-align: center; padding-bottom: 20px;">
                <el-col :span="10">
                    <label style="font-size: 18px;">Respuesta: </label>
                </el-col>
                <el-col :offset="2" :span="10">
                    <el-select v-model="respuesta_selected"
                               filterable
                               size="mini"
                               placeholder="Seleccionar respuesta...">
                        <el-option
                            v-for="item in info_list_respuestas"
                            :key="item.value"
                            :label="item.label"
                            :value="item">
                        </el-option>
                    </el-select>
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
                        v-model="nueva_llamada_observacion">
                    </el-input>
                </el-col>
            </el-row>
            <el-row style="text-align: center; padding-bottom: 20px;">
                <el-button type="primary" size="mini" icon="el-icon-plus" @click="agregarLlamada">Agregar Llamada</el-button>
            </el-row>
        </el-dialog>
    </div>
</template>

<script>
    import apiPersonas from "@api/personas";
    import apiLlamadas from "@api/llamadas";
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
            EstadosInteres: () => import("../componentes/estados_interes")
        },
        data(){
            return {
                info_interesado_selected: null,
                info_interesado_loading: false,
                interes_selected: null,
                intereses: [],
                llamadas: [],
                respuesta_selected: "SI",
                info_list_interesados: [],
                info_list_respuestas: ["SI", "NO", "TALVEZ"],
                nueva_llamada_modal_visible: false,
                nueva_llamada_observacion: ""
            }
        },
        methods:{
            async modalLlamadaAbierto(){
                //this.intereses = this.info_interesado_selected.intereses;
            },
            async buscarPersona(valor){
               let { data } = await apiPersonas.buscarPersona(valor);
               this.info_list_interesados = data;
            },
            abrirModalNuevaLlamada(){
                this.nueva_llamada_modal_visible = true;
            },
            historial_llamadas(valor){
                this.intereses = valor.intereses;
                //console.log("Datos: ", valor);
            },
            async agregarLlamada(){
                console.log("Interes: ", this.interes_selected.id);
                console.log("Respuesta: ", this.respuesta_selected);
                let { data } = await apiLlamadas.agregarLlamada({
                    id_interesado: this.interes_selected.id,
                    respuesta: this.respuesta_selected,
                    observacion: this.nueva_llamada_observacion
                });
                this.nueva_llamada_modal_visible = false;
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
            }
        }
    }
</script>

<style>
    #control_llamadas .el-row{
        margin-bottom: 20px;
    }
</style>
