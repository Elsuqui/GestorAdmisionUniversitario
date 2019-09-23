<template>
    <el-container>
        <el-header class="header"></el-header>
        <el-main>
            <el-row>
                <el-col :span="12" :offset="6">
                    <el-card>
                        <div slot="header">
                            Llenar formulario para el cambio de contraseña
                        </div>
                        <div>
                            <el-form ref="form_reset" status-icon :rules="reglas" :model="form" label-width="160px" size="mini">
                                <el-form-item label="Correo electrónico" prop="email">
                                    <el-input placeholder="example@mail.com" v-model="form.email"></el-input>
                                </el-form-item>
                                <el-form-item label="Contraseña" prop="password">
                                    <el-input type="password" v-model="form.password"></el-input>
                                </el-form-item>
                                <el-form-item label="Confirmar contraseña" prop="password_confirmation">
                                    <el-input type="password" v-model="form.password_confirmation"></el-input>
                                </el-form-item>
                            </el-form>
                            <el-button type="primary" size="mini" :loading="cambiando_pass" @click="onSubmit">{{ etiqueta_accion }}</el-button>
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
        name: "confirmPassword",
        data(){
          return {
              form: {
                  email: "",
                  password: "",
                  password_confirmation: "",
                  token: null
              },
              reglas: {
                  email: [
                      { required: true, message: 'Debe ingresar un correo electrónico', trigger: 'blur' },
                      { pattern: '^[^\\s@]+@[^\\s@]+\\.[^\\s@]', message: 'El correo debe ser válido', trigger: 'change'}
                  ]
              },
              etiqueta_accion: "Cambiar contraseña",
              cambiando_pass: false,
          }
        },
        props:{
            token: {required: true}
        },
        mounted() {
            if(this.token === null){
                window.location.href = "/not-found";
            }else{
                this.$set(this.form, "token", this.token);
            }
        },
        methods:{
            async onSubmit(){
                this.$refs.form_reset.validate(async (valid) => {
                    if(valid){
                        this.cambiando_pass = true;
                        this.etiqueta_accion = "Cambiando contraseña";
                        const data = await api_usuario.cambiar_password_confirm(this.form);
                        console.log("Respuesta: ", data);
                        if(data.exito){
                            this.$notify.success(data.mensaje);
                            window.location.href = "/home";
                        }else if(data.hasOwnProperty("errors")){
                            console.log("Error: ", data.errors.first());
                            this.$notify.error(data.errors.first()[0]);
                        }else{
                            this.$notify.error(data.mensaje);
                        }
                        this.cambiando_pass = false;
                        this.etiqueta_accion = "Cambiar contraseña";
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
