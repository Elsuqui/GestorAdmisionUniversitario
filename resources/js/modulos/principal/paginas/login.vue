<template>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-t-190 p-b-30">
                <form class="login100-form validate-form">

                    <div class="login100-form-avatar">
                        <img src="/imagenes/ucsg_logo.png" alt="AVATAR">
                    </div>

                    <span class="login100-form-title p-t-20 p-b-45">
						USUARIO
					</span>

                    <div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
                        <input v-model="username" class="input100" type="text" name="username" placeholder="Usuario">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
                        <input v-model="password" class="input100" type="password" name="password" placeholder="Contraseña">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
                    </div>

                    <el-alert
                        v-if="error_message !== ''"
                        title="Usuario o clave incorrecta!"
                        type="error"
                        :description="error_message"
                        show-icon
                        @close="error_message = ''">
                    </el-alert>

                    <div class="container-login100-form-btn p-t-10">
                        <button class="login100-form-btn"
                                @click="login"
                                type="button">
                            Ingresar
                        </button>
                    </div>

                    <div class="text-center w-full p-t-25 p-b-230">
                        <a href="#" class="txt1">
                            Olvidó su usuario / contraseña?
                        </a>
                    </div>

                    <div class="text-center w-full">
                        <a class="txt1" href="#">
                            Registrarse
                            <i class="fa fa-long-arrow-right"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import apiLogin from "../../../api/usuario";

    export default {

        components: {
          ElAlert: () => import("element-ui/lib/alert")
        },

        data(){
            return {
                username: "",
                password: "",
                remember: false,
                error_message: "",
            }
        },

        methods: {
            async login(){
               let response = await apiLogin.iniciar_sesion({
                   username: this.username,
                   password: this.password,
                   remember: this.remember
               });

               if(response.success){
                   window.location.href = response.redirect;
               }else{
                   this.error_message = "Error al ingresar al sistema";
               }
            }
        }
    }
</script>

<style scoped>

</style>
