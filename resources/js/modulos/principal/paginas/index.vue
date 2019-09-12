<template>
    <el-container>
        <el-aside width="200px" id="barra_lateral">
            <!--Aquí se agrega el menú de la página-->
            <el-menu :default-active="$route.meta.opcion_menu"
                     class="el-menu-vertical-demo"
                     @open="abrirMenu"
                     @close="acortarMenu"
                     :collapse="acortar"
                     background-color="#545c64"
                     text-color="#fff"
                     active-text-color="#ffd04b">
                <el-menu-item :v-show="verificarPermisos('/home')" index="0" @click="$router.push({ path: '/home' })" style="height: 100px;">
                    <el-image
                        style="width: 100%; padding-top: 15%;"
                        :src="'/imagenes/logo.png'"
                        :fit="'scale-down'">
                    </el-image>
                </el-menu-item>
                <router-link :class="verificarPermisos('/admision') ? '' : 'ocultar'" index="1" tag="el-menu-item" :to="{ name: 'index-admision' }">
                    <i class="el-icon-circle-plus-outline"></i>
                    <span>Nuevo interesado</span>
                </router-link>
                <el-menu-item :class="verificarPermisos('/archivos') ? '' : 'ocultar'" index="2" @click="$router.push({ name: 'index-archivos' })">
                    <i class="el-icon-document"></i>
                    <span>Subir archivo excel</span>
                </el-menu-item>
                <el-menu-item :class="verificarPermisos('/mail') ? '' : 'ocultar'" index="3" @click="$router.push({ name: 'index-mail' })">
                    <i class="el-icon-message"></i>
                    <span>Envío de mail</span>
                </el-menu-item>
                <el-menu-item :class="verificarPermisos('/llamadas') ? '' : 'ocultar'" index="4" @click="$router.push({ name: 'index-llamadas' })">
                    <i class="el-icon-phone"></i>
                    <span>Control de llamadas</span>
                </el-menu-item>
                <el-menu-item :class="verificarPermisos('/reportes') ? '' : 'ocultar'" index="5" @click="$router.push({ name: 'index-reportes' })">
                    <i class="el-icon-s-claim"></i>
                    <span>Reporte de Admisión</span>
                </el-menu-item>
                <el-menu-item :class="verificarPermisos('/usuarios') ? '' : 'ocultar'" index="6" @click="$router.push({ name: 'index-usuarios' })">
                    <i class="el-icon-user"></i>
                    <span>Usuarios</span>
                </el-menu-item>
                <el-menu-item :class="verificarPermisos('/plantilla') ? '' : 'ocultar'" index="7" @click="$router.push({ name: 'index-plantilla' })">
                    <i class="el-icon-link"></i>
                    <span>Plantilla Correo</span>
                </el-menu-item>
                <!--<el-menu-item index="6">
                    <i class="el-icon-s-claim"></i>
                    <span>Historico de Admisiones</span>
                </el-menu-item>-->
            </el-menu>
        </el-aside>
        <el-container>
            <el-header class="header">
                <el-row>
                    <el-col :span="8" >
                        <!--<el-button
                            :icon="acortar ? 'el-icon-caret-rigth' : 'el-icon-caret-left'"
                            @click="acortar = !acortar">
                        </el-button>-->
                    </el-col>
                    <el-col :span="8">
                        <!--<div class="title">
                            SISTEMA GESTOR DE ADMISIÓN UNIVERSITARIA
                        </div>-->
                    </el-col>
                    <el-col style="text-align: right;">
                        <el-dropdown @command="eventoOpciones">
                            <el-image
                                id="imagen-perfil"
                                style="width: 50px; height: 50px;"
                                :src="imagen_perfil"
                                fit="contain"></el-image>
                            <el-dropdown-menu slot="dropdown">
                                <el-dropdown-item
                                    icon="el-icon-close"
                                    :command="1">
                                    <form style="display: none;"
                                          action="/logout"
                                          method="POST"
                                          ref="formulario">
                                        <input type="hidden" name="_token" :value="csrf">
                                    </form>
                                    Cerrar Sesión
                                </el-dropdown-item>
                            </el-dropdown-menu>
                        </el-dropdown>
                    </el-col>
                </el-row>
            </el-header>
            <!--<el-header>
                <el-row type="flex" class="row-bg" justify="space-between">
                    <el-col :span="9">
                        <div class="grid-content bg-purple" style="font-size: 20px;">
                            SISTEMA GESTOR DE ADMISIÓN UNIVERSITARIO
                        </div>
                    </el-col>
                    <el-col :span="9"><div class="grid-content bg-purple-light"></div></el-col>
                </el-row>
            </el-header>-->
            <el-main>
                <!--<seguidor-ruta :ruta="$route.path"></seguidor-ruta>-->
                <router-view></router-view>
            </el-main>
        </el-container>
    </el-container>
</template>

<script>
    export default {
        //name: "_index",
        components:{
          SeguidorRuta: () => import("../componentes/SeguidorRutaComponent")
        },
        data(){
            return {
                acortar: false,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                imagen_perfil: "https://sudamericarural.org/images/concurso/2017/concursantes/people.png"
            }
        },
        methods:{
            abrirMenu(){

            },
            acortarMenu(){

            },
            eventoOpciones(evento){
                switch(evento){
                    case 1:
                        this.$refs.formulario.submit();
                        break;
                }
            },
            verificarPermisos(ruta){
                return (window.permisos_usuario.includes("*") || window.permisos_usuario.includes("ver-" + ruta));
            }
        }
    }
</script>

<style>
    .el-menu-vertical-demo:not(.el-menu--collapse) {
        width: 200px;
        min-height: 100vh;
        max-height: 100vh;
    }

    .el-menu-vertical-demo.el-menu--collapse.el-menu{
        width: 100px;
        min-height: 100vh;
        max-height: 100vh;
    }

    .header{
        vertical-align: middle;
        font-size: 20px;
        background-color: darkred;
        color: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, .12), 0 0 6px rgba(0, 0, 0, .04);
    }

    .title{
        padding-top: 15px;
        text-align: center;
        width: 500px;
    }

    .el-image__inner{
        border-radius: 50% !important;
    }

    .ocultar{
        display: none;
    }

</style>
