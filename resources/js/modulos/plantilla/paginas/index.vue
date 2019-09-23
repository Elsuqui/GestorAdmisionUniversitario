<template>
    <div>
        <panel titulo="Configuración de plantilla" id="plantilla">
            <div slot="content" style="max-height: calc(100vh - 40vh); height: 60vh;" v-loading="enviando_correo" element-loading-text="Enviando correos a interesados...">
                <el-row>
                    <el-col :span="12">
                        <el-row>
                            <el-col :span="6">Asunto</el-col>
                            <el-col :span="18"><el-input v-model="plantilla.asunto"></el-input></el-col>
                        </el-row>
                        <!--<el-row style="margin-top: 25px;">
                            <el-col :span="6">Cuerpo</el-col>
                            <el-col :offset="1" :span="7">
                                <el-select v-model="tipo_adjunto_selected">
                                    <el-option v-for="(item, key) in tipos_adjuntos"
                                               :key="key"
                                               :label="item"
                                               :value="key">
                                    </el-option>
                                </el-select>
                            </el-col>
                            <el-col :offset="1" :span="7">
                                <el-select v-model="orden_selected">
                                    <el-option v-for="(contenido, key) in elementosCuerpo"
                                               :key="key"
                                               :label="contenido"
                                               :value="contenido"></el-option>
                                </el-select>
                            </el-col>
                            <el-col :offset="1" :span="1">
                                <el-button type="success" circle size="mini" icon="el-icon-plus" @click="agregarContenido"></el-button>
                            </el-col>
                        </el-row>-->
                        <el-row style="margin-top: 25px;">
                            <el-col :span="6">Contenido del mensaje</el-col>
                            <el-col :span="18">
                                <el-input :autosize="{ minRows: 5, maxRows: 10}" type="textarea" v-model="plantilla.cuerpo"></el-input>
                            </el-col>
                            <!--<el-col v-else>
                                <el-upload
                                    action=""
                                    list-type="picture-card"
                                    :on-preview="handlePictureCardPreview"
                                    :on-remove="handleRemove"
                                    :on-success="cargaExitosa"
                                    :on-change="agregarImagen"
                                    :limit="1"
                                    :auto-upload="false"
                                    :multiple="false">
                                    <i class="el-icon-plus"></i>
                                </el-upload>
                                <el-dialog :visible.sync="dialogVisible">
                                    <img width="100%" :src="imagen_seleccionada" alt="">
                                </el-dialog>
                            </el-col>-->
                        </el-row>
                        <el-row style="margin-top: 25px;">
                            <el-col :span="6">Pie de página</el-col>
                            <el-col :span="18"><el-input :autosize="{ minRows: 5, maxRows: 10}" type="textarea" v-model="plantilla.pie"></el-input></el-col>
                        </el-row>
                        <el-row style="margin-top: 25px;">
                            <el-col>
                                <el-button :loading="enviando_correo" type="success" size="mini" icon="el-icon-plus" @click="agregarContenido">{{ estado_envio }}</el-button>
                            </el-col>
                        </el-row>
                    </el-col>
                    <!--<el-col :offset="2" :span="10">

                    </el-col>-->
                </el-row>
            </div>
        </panel>
    </div>
</template>

<script>
    import apiMail from "@api/mail";
    export default {
        name: "index",
        components: {
            ElTable: () => import("element-ui/lib/table"),
            ElTableColumn: () => import("element-ui/lib/table-column"),
            ElInput: () => import("element-ui/lib/input"),
            Panel: () => import("@components/PanelComponent"),
            ElDialog: () => import("element-ui/lib/dialog"),
            ElForm: () => import("element-ui/lib/form"),
            ElFormItem: () => import("element-ui/lib/form-item"),
            ElRow: () => import("element-ui/lib/row"),
            ElCol: () => import("element-ui/lib/col"),
            ElSelect: () => import("element-ui/lib/select"),
            ElOption: () => import("element-ui/lib/option"),
            ElButton: () => import("element-ui/lib/button"),
            ElSwitch: () => import("element-ui/lib/switch"),
            ElUpload: () => import("element-ui/lib/upload")
        },
        data(){
            return {
                plantilla: {
                    asunto: '',
                    cuerpo: '',
                    pie: ''
                },
                enviando_correo: false,
                estado_envio: "Enviar correo masivo a interesados",
                tipo_adjunto_selected: 0,
                valor_area_texto: '',
                imagen_seleccionada: null,
                dialogVisible: false,
                tipos_adjuntos: ["Texto", "Imagen"],
                orden_selected: null,
                contenidos_plantilla: []
            }
        },
        computed:{
            elementosCuerpo(){
                let ordenes = [];
                for(let i = 0; i <= this.plantilla.cuerpo.length; i++){
                    ordenes.push(i)
                }
                return ordenes;
            }
        },
        mounted(){
            if(this.plantilla.cuerpo.length > 0){
                this.plantilla.cuerpo.forEach((value, key) => {
                    this.contenidos_plantilla.push(key);
                });
            }else{
                this.contenidos_plantilla.push(0);
            }
        },
        methods:{
            handlePictureCardPreview(file){
                this.imagen_seleccionada = file.url;
                this.dialogVisible = true;
            },

            handleRemove(){

            },

            beforeAvatarUpload(file) {
                const isJPG = file.type === 'image/jpeg';
                const isLt2M = file.size / 1024 / 1024 < 2;
                console.log("Archivo: ", file);
                if (!isJPG) {
                    this.$message.error('La imagen debe estar en formato JPG!');
                }
                if (!isLt2M) {
                    this.$message.error('La imagen excede los 2MB!');
                }
                //return isJPG && isLt2M;
                return isLt2M;
            },

            cargaExitosa(res, file){
                console.log("Archivo: ", file);
                console.log("Res: ", res);
            },

            async agregarContenido(){
                if(this.plantilla.cuerpo !== "" || this.plantilla.asunto !== ""){
                    this.enviando_correo = true;
                    let { data } = await apiMail.enviarMailPersonalizado(this.plantilla);
                    if(data){
                        this.enviando_correo = false;
                        this.$notify({
                            title: "Los correos fueron enviados correctamente",
                            type: "success"
                        });
                    }else{
                        this.enviando_correo = false;
                        this.$notify({
                            title: "Error al enviar los correos!!",
                            type: "error"
                        });
                    }
                }else{
                    this.enviando_correo = false;
                    this.$notify({
                        title: "Los campos de Asunto y cuerpo del correo son obligatorios",
                        type: "error"
                    });
                }

                /*if(this.tipo_adjunto_selected === 0){
                    // Es texto
                    if(this.valor_area_texto !== ""){
                        this.plantilla.cuerpo.push({
                            tipo: 0,
                            orden: this.orden_selected,
                            valor: this.valor_area_texto
                        });
                    }else{
                        this.$notify({
                           title: "El valor de configuración es obligatorio",
                            type: "error"
                        });
                    }
                }else{
                    //Es imágen
                    this.plantilla.cuerpo.push({
                       tipo: 1,
                       orden: this.orden_selected,
                       valor: this.imagen_seleccionada
                    });
                }*/
            },

            agregarImagen(file, fileList){
                console.log("Archivo", file);
                this.imagen_seleccionada = file;
            }
        }
    }
</script>

<style>
    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }
    .avatar {
        width: 178px;
        height: 178px;
        display: block;
    }
</style>
