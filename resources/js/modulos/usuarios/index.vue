<template>
    <div>
        <panel titulo="Administrador de usuarios" id="control_usuarios">
            <template slot="content">
                <el-divider><i class="el-icon-user-solid"></i> LISTADO DE USUARIOS</el-divider>
                <el-button size="mini" type="primary" icon="el-icon-plus" @click="creacion_usuario = true"> Agregar usuario</el-button>
                <el-table :data="usuarios" v-loading="cargando_usuarios" element-loading-text="Cargando usuarios..."
                          style="max-height: calc(100vh - 40vh);" height="60vh">
                    <el-table-column label="Nombre">
                        <template slot-scope="{ row }">
                            {{ row.name }}
                        </template>
                    </el-table-column>
                    <el-table-column label="Correo">
                        <template slot-scope="{ row }">
                            {{ row.email }}
                        </template>
                    </el-table-column>
                    <el-table-column label="Origen">
                        <template slot-scope="{ row }">
                            {{ row.origen.nombre }}
                        </template>
                    </el-table-column>
                    <el-table-column label="Creación">
                        <template slot-scope="{ row }">
                            {{ row.created_at }}
                        </template>
                    </el-table-column>
                    <el-table-column
                        fixed="right"
                        label="Operaciones">
                        <template slot-scope="{ row }">
                            <el-button type="primary" size="mini" @click="editarUsuario(row)">Editar</el-button>
                            <el-button type="primary" size="mini" @click="asignarRoles(row)">Roles</el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </template>
        </panel>

        <el-dialog title="Creación de usuario"
                   :visible.sync="creacion_usuario"
                   width="50%"
                   center>
            <div>
                <el-form ref="create_form"
                         status-icon
                         :rules="reglas"
                         label-position="top"
                         :model="form_creacion_usuario"
                         label-width="120px">
                    <el-row>
                        <el-col :offset="8" :span="8">
                            <el-form-item label="Usuario">
                                <el-input v-model="form_creacion_usuario.username"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :offset="8" :span="8">
                            <el-form-item label="Nombre">
                                <el-input v-model="form_creacion_usuario.name"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :offset="8" :span="8">
                            <el-form-item label="Correo electrónico" prop="email">
                                <el-input v-model="form_creacion_usuario.email"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :offset="8" :span="8">
                            <el-form-item label="Origen">
                                <el-select v-model="form_creacion_usuario.id_origen" style="width: 100%;">
                                    <el-option v-for="(origen, key) in origenes"
                                               :value="origen.id"
                                               :key="key"
                                               :label="origen.nombre">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :offset="8" :span="8">
                            <el-button type="primary" @click="createUser">Crear <i class="el-icon-plus"></i></el-button>
                        </el-col>
                    </el-row>
                </el-form>
            </div>
        </el-dialog>

        <el-dialog title="Edicion de usuario"
                   :visible.sync="edicion_usuario"
                   width="50%"
                   center>
            <div>
                <el-form ref="form"
                         status-icon
                         :rules="reglas"
                         label-position="top"
                         :model="form_edicion_usuario"
                         label-width="120px">
                    <el-row>
                        <el-col :offset="8" :span="8">
                            <el-form-item label="Nombre de usuario">
                                <el-input v-model="form_edicion_usuario.name"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :offset="8" :span="8">
                            <el-form-item label="Correo electrónico" prop="email">
                                <el-input v-model="form_edicion_usuario.email"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :offset="8" :span="8">
                            <el-form-item label="Origen">
                                <el-select v-model="form_edicion_usuario.id_origen" style="width: 100%;">
                                    <el-option v-for="(origen, key) in origenes"
                                               :value="origen.id"
                                               :key="key"
                                               :label="origen.nombre">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :offset="8" :span="8">
                            <el-button type="primary" @click="editUser">Editar <i class="el-icon-edit"></i></el-button>
                        </el-col>
                    </el-row>
                </el-form>
            </div>
        </el-dialog>


        <el-dialog title="Asignación de roles"
                   :visible.sync="asignar_roles"
                   width="50%">
            <div style="padding-top: 10px;">
                <label style="font-weight: bold;">Listado de Roles: </label>
            </div>
            <hr/>
            <div style="height: 500px; overflow: auto;">
                <el-row style="padding-top: 20px;" v-for="(rol, key) in roles" :key="key">
                    <el-col :span="8">
                        <label>{{ rol.name }}</label>
                    </el-col>
                    <el-col :span="8">
                        <el-switch v-model="roles_asignados[rol.id]" @change="asignar(rol)"></el-switch>
                    </el-col>
                </el-row>
            </div>
        </el-dialog>

    </div>
</template>

<script>
    import apiUsuarios from "@api/usuarios";
    import apiOrigenes from "@api/origenes";

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
            ElSwitch: () => import("element-ui/lib/switch")
        },
        data() {
            return {
                usuarios: [],
                cargando_usuarios: false,
                edicion_usuario: false,
                creacion_usuario: false,
                usuario_selected: null,
                asignar_roles: false,
                roles: [],
                form_edicion_usuario: {
                    name: '',
                    email: '',
                    id_origen: null
                },
                form_creacion_usuario: {
                    username: '',
                    name: '',
                    email: '',
                    id_origen: null
                },
                origenes: [],
                roles_asignados: {},
                reglas : {
                    email: [
                        { required: true, message: 'Debe ingresar un correo electrónico', trigger: 'change' },
                        { pattern: '^[^\\s@]+@[^\\s@]+\\.[^\\s@]', message: 'El correo debe ser válido', trigger: 'change'}
                    ]
                }
            }
        },
        async mounted() {
            this.recargarTablaUsuarios();
            let {data} = await apiOrigenes.listado();
            this.origenes = data;
            await this.cargarRoles();
            console.log("Roles: ", this.roles);
            console.log("Origenes: ", this.origenes);
        },
        methods: {
            async recargarTablaUsuarios() {
                this.cargando_usuarios = true;
                let {data} = await apiUsuarios.consultarTodos();
                this.usuarios = data;
                this.cargando_usuarios = false;
            },
            editarUsuario(usuario) {
                this.edicion_usuario = true;
                this.usuario_selected = usuario;
                this.form_edicion_usuario.name = this.usuario_selected.name;
                this.form_edicion_usuario.email = this.usuario_selected.email;
                this.form_edicion_usuario.id_origen = this.usuario_selected.origen.id;
            },
            async asignarRoles(usuario) {
                this.limpiarAsignaciones();
                this.usuario_selected = usuario;
                this.asignar_roles = true;
                this.verificarRoles();
            },
            async cargarRoles() {
                let {data} = await apiUsuarios.roles();
                this.roles = data;
                this.roles.forEach((rol) => {
                    this.$set(this.roles_asignados, rol.id, false)
                });
            },
            verificarRoles() {
                this.usuario_selected.roles.forEach((rol) => {
                    this.roles_asignados[rol.id] = true;
                });
            },
            limpiarAsignaciones() {
                for (let rol in Object.keys(this.roles_asignados)) {
                    this.roles_asignados[rol] = false;
                }
            },
            async asignar(rol) {
                if (this.roles_asignados[rol.id]) {
                    let {data} = await apiUsuarios.asignarRol(this.usuario_selected.id, rol.name);
                    console.log("Data: ", data);
                    if (data) {
                        this.$notify({
                            title: "El permiso se asignó correctamente",
                            type: "success"
                        });
                        this.roles_asignados[rol.id] = true;
                    }else{
                        this.$notify({
                            title: "Error al asignar permiso",
                            type: "danger"
                        });
                    }
                } else {
                    let {data} = await apiUsuarios.removerRol(this.usuario_selected.id, rol.name);
                    if (data) {
                        this.$notify({
                            title: "El permiso se removió correctamente",
                            type: "success"
                        });
                        this.roles_asignados[rol.id] = false;
                    }else{
                        this.$notify({
                            title: "Error al remover el permiso",
                            type: "error"
                        });
                    }
                }
                this.recargarTablaUsuarios();
            },
            async editUser(){
                this.$refs.form.validate(async (valid) => {
                    if(valid){
                        let { data } = await apiUsuarios.editarUsuario(this.form_edicion_usuario, this.usuario_selected.id);
                        console.log("Dato: ", data);
                        if (data) {
                            this.$notify({
                                title: "El usuario se editó correctamente",
                                type: "success"
                            });
                        }else{
                            this.$notify({
                                title: "Error al editar el usuario",
                                type: "error"
                            });
                        }
                        this.recargarTablaUsuarios();
                    }else{
                        this.$notify.error({
                            title: 'Error de validación!',
                            message: 'Revisar los campos del formulario!'
                        });
                    }
                });
            },
            createUser(){
                this.$refs.create_form.validate(async (valid) => {
                    if(valid){
                        try{
                            let { data } = await apiUsuarios.crearUsuario(this.form_creacion_usuario);
                            console.log("Dato: ", data);
                            if (data) {
                                this.$notify({
                                    title: "El usuario se creó correctamente",
                                    type: "success"
                                });
                                this.recargarTablaUsuarios();
                            }else{
                                this.$notify({
                                    title: "Error al crear el usuario",
                                    type: "error"
                                });
                            }

                        }catch(error){
                            if(error.response){
                                let { data } = error.response;
                                console.log("Error: ", error.response);
                                if(data.hasOwnProperty("errors")){
                                    this.$notify({
                                        title: "Error",
                                        message: data.errors[Object.keys(data.errors)[0]][0],
                                        type: "error"
                                    });
                                    this.form_creacion_usuario.email = '';
                                    this.$refs.create_form.validate();
                                }else{
                                    this.$notify({
                                        title: "El usuario se creó correctamente",
                                        type: "success"
                                    });
                                }
                            }
                        }
                    }else{
                        this.$notify.error({
                            title: 'Error de validación!',
                            message: 'Revisar los campos del formulario!'
                        });
                    }
                });
            }
        }
    }
</script>

<style>
    .el-dialog__header {
        padding-bottom: 2px;
        background-color: black;
    }

    .el-dialog__title {
        color: white;
    }

    .el-dialog__body {
        padding-top: 2px;
    }

    .el-dialog__headerbtn .el-dialog__close {
        color: white;
    }
</style>
