<template>
    <el-container style="box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);">
        <el-header style="background-color: black; color: white; font-size: 19px;" height="40px">
            <div style="margin-top: 0.5%;">{{ titulo }}</div>
        </el-header>
        <el-main>
            <slot name="content">

            </slot>
        </el-main>
    </el-container>
</template>

<script>
    export default {
        name: "PanelComponent",
        components:{
            ElContainer: () => import("element-ui/lib/container"),
            ElHeader: () => import("element-ui/lib/header"),
            ElMain: () => import("element-ui/lib/main")
        },
        props: {
            titulo: {type: String, default: "Titulo del panel"}
        }
    }
</script>

<style scoped>

</style>
