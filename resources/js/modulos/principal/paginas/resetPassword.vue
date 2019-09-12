<template>
    <el-container>
        <el-header class="header"></el-header>
        <el-main>
            <el-row>
                <el-col :span="12" :offset="6">
                    <el-card>
                        <div slot="header">
                            Solicitud para cambio de contraseña
                        </div>
                        <div>
                            <el-form ref="form_reset" status-icon :rules="reglas" :model="form" label-width="160px" size="mini">
                                <el-form-item label="Correo electrónico" prop="email">
                                    <el-input placeholder="example@mail.com" v-model="form.email"></el-input>
                                </el-form-item>
                            </el-form>
                            <el-button type="primary" size="mini" :loading="enviando_correo" @click="onSubmit">{{ etiqueta_accion }}</el-button>
                        </div>
                    </el-card>
                </el-col>
            </el-row>
        </el-main>
    </el-container>
</template>

<script>
    import api_usuario from "@api/usuario";
    export default {
        name: "resetPassword",
        components: {

        },
        data(){
            return {
                form: {
                    email: ""
                },
                etiqueta_accion: "Enviar solicitud",
                enviando_correo: false,
                reglas: {
                    email: [
                        { required: true, message: 'Debe ingresar un correo electrónico', trigger: 'blur' },
                        { pattern: '^[^\\s@]+@[^\\s@]+\\.[^\\s@]', message: 'El correo debe ser válido', trigger: 'change'}
                    ]
                }
            }
        },
        methods:{
            async onSubmit(){
                this.$refs.form_reset.validate(async (valid) => {
                    if(valid){
                        this.enviando_correo = true;
                        this.etiqueta_accion = "Enviando Correo";
                        const data = await api_usuario.cambiar_password(this.form);
                        console.log("Respuesta: ", data);
                        if(data.exito){
                            this.$notify.success(data.mensaje);
                        }else{
                            this.$notify.error(data.mensaje);
                        }
                        this.enviando_correo = false;
                        this.etiqueta_accion = "Enviar solicitud";
                    }
                });
            }
        }
    }
</script>

<style scoped>
    .header{
        vertical-align: middle;
        font-size: 20px;
        background-color: darkred;
        color: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, .12), 0 0 6px rgba(0, 0, 0, .04);
    }
</style>
