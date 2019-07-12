<template>
    <panel titulo="Importación de archivos">
        <div slot="content">
            <el-row>
                <el-col :span="12" :offset="6" style="text-align: center;">
                    <div class="grid-content">
                        <el-upload
                            class="upload-demo"
                            drag
                            ref="archivos"
                            :action="url_subir_excel"
                            :file-list="listado_archivos"
                            list-type="picture"
                            :auto-upload="false"
                            :on-change="personalizarArchivo"
                            :on-success="subidaExitosa">
                            <i class="el-icon-upload"></i>
                            <div class="el-upload__text">Suelta tu archivo aquí o <em>haz clic para cargar</em></div>
                            <div slot="tip" class="el-upload__tip">Solo se pueden subir archivos de excel</div>
                        </el-upload>
                        <el-button style="margin-left: 10px; margin-top: 20px;" size="small" type="success" @click="subirArchivos">Subir Archivos</el-button>
                    </div>
                </el-col>
            </el-row>
        </div>
    </panel>
</template>

<script>
    import apiArchivos from "@api/archivos";
    export default {
        name: "index",
        components: {
            ElRow: () => import("element-ui/lib/row"),
            ElCol: () => import("element-ui/lib/col"),
            ElUpload: () => import("element-ui/lib/upload"),
            Panel: () => import("@components/PanelComponent")
        },
        data(){
            return {
                listado_archivos: [],
                url_subir_excel: apiArchivos.url() + "/importar-excel-base"
            }
        },
        methods:{
            async subirArchivos(){
                // Subir el archivo de excel a procesar
                this.$refs.archivos.submit();
            },
            personalizarArchivo(file, filelist){

                // El tipo del archivo no es reconocido, preguntamos si esta dentro de la lista
                let split_file_name = file.name.split(".");
                let file_extension = split_file_name[split_file_name.length - 1];
                console.log("Split: ", file_extension);

                // Agregamos el icono de excel a la imágen
                if(this.verificarFormatosSoportados(file_extension)){
                    file.ruta = file.url;
                    file.url = "/imagenes/logo_excel.png";
                }else{
                    filelist.splice(filelist.indexOf(file), 1);
                    this.$notify.warning({
                        title: "Error al cargar archivo",
                        message: "No se puede subir archivos que no sean en formato xls ó xlsx",
                        position: "bottom-right"
                    });
                }
            },
            verificarFormatosSoportados(formato){
                return (formato === "xlsx" || formato === "xls");
            },
            subidaExitosa(){
                this.$notify.success({
                    title: "Procesado exitoso",
                    message: "El archivo fue procesado correctamente",
                    position: "bottom-right"
                });
            }
        }
    }
</script>

<style>
    .el-upload-list__item-name{
        text-align: left;
    }
</style>
