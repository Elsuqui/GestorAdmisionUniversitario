<template>
    <el-container>
        <el-aside width="200px" id="barra_lateral">
            <!--Aquí se agrega el menú de la página-->
            <el-menu default-active="1"
                     class="el-menu-vertical-demo"
                     @open="abrirMenu"
                     @close="acortarMenu"
                     :collapse="acortar"
                     background-color="#545c64"
                     text-color="#fff"
                     active-text-color="#ffd04b">
                <el-image
                    style="width: 100%; height: 100px;"
                    :src="'/imagenes/logo.png'"
                    :fit="'scale-down'">
                </el-image>
                <el-menu-item index="1">
                    <i class="el-icon-document"></i>
                    <span>Subir archivo excel</span>
                </el-menu-item>
                <el-menu-item index="2">
                    <i class="el-icon-s-claim"></i>
                    <span>Reporte de Admisión</span>
                </el-menu-item>
                <el-menu-item index="3">
                    <i class="el-icon-message"></i>
                    <span>Envío de mail</span>
                </el-menu-item>
                <el-menu-item index="4">
                    <i class="el-icon-phone"></i>
                    <span>Control de llamadas</span>
                </el-menu-item>
            </el-menu>
        </el-aside>
        <el-container>
            <el-header>
                <el-row type="flex" class="row-bg" justify="space-between">
                    <el-col :span="9">
                        <div class="grid-content bg-purple" style="font-size: 20px;">
                            SISTEMA GESTOR DE ADMISIÓN UNIVERSITARIO
                        </div>
                    </el-col>
                    <el-col :span="9"><div class="grid-content bg-purple-light"></div></el-col>
                </el-row>
            </el-header>
            <el-main>Principal</el-main>
        </el-container>
    </el-container>
</template>

<script>
    export default {
        //name: "_index",
        data(){
            return {
                acortar: false
            }
        },
        methods:{
            abrirMenu(){

            },
            acortarMenu(){

            }
        }
    }
</script>

<style scoped>
    .el-menu-vertical-demo:not(.el-menu--collapse) {
        min-height: 100vh;
    }
</style>
