<template>
    <panel titulo="Formulario de registro nuevo interesado">
        <div slot="content">
            <el-form ref="form" status-icon :rules="reglas" :model="form" label-width="120px" size="mini">
                <el-form-item>
                    <el-col :span="10">
                        <el-form-item label="Cédula" prop="cedula">
                            <el-input v-model="form.cedula"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="10">
                        <el-form-item label="Nombres" prop="nombres">
                            <el-input v-model="form.nombres"></el-input>
                        </el-form-item>
                    </el-col>
                </el-form-item>
                <el-form-item label="Unidad Educativa" prop="colegio">
                    <el-input v-model="form.colegio"></el-input>
                </el-form-item>
                <el-form-item label="Telefonos">
                    <el-col :span="11">
                        <el-form-item prop="telconv">
                            <el-input v-model="form.telconv" placeholder="Convencional"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="11" :offset="2">
                        <el-form-item prop="telcel">
                            <el-input v-model="form.telcel" placeholder="Celular"></el-input>
                        </el-form-item>
                    </el-col>
                </el-form-item>
                <el-form-item label="Correo electrónico" prop="mail">
                    <el-input v-model="form.mail"></el-input>
                </el-form-item>
                <el-form-item label="Interes">
                    <el-col :span="12">
                        <el-form-item prop="facultad">
                            <el-select v-model="form.facultad">
                                <el-option label="Ingeniería" :value="1"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item prop="carrera">
                            <el-select v-model="form.carrera">
                                <el-option label="Ciencias de la computación" :value="1"></el-option>
                                <el-option label="Civil" :value="2"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-form-item>
                <el-form-item size="mini">
                    <el-button type="primary" @click="onSubmit">Guardar</el-button>
                    <el-button type="default" @click="limpiarFormulario">Limpiar</el-button>
                </el-form-item>
            </el-form>
        </div>
    </panel>
</template>

<script>
    import api_admision from "@api/admision";
    export default {
        name: "index",
        components: {
            Panel: () => import("@components/PanelComponent"),
            ElForm: () => import("element-ui/lib/form"),
            ElFormItem: () => import("element-ui/lib/form-item"),
            ElInput: () =>  import("element-ui/lib/input"),
            ElCol: () => import("element-ui/lib/col"),
            ElSelect: () => import("element-ui/lib/select"),
            ElOption: () => import("element-ui/lib/option")
        },
        data(){
            return {
                form: {
                    nombres: "",
                    cedula: "",
                    colegio: "",
                    telconv: "",
                    telcel: "",
                    mail: "",
                    facultad: 1,
                    carrera: 1
                },
                reglas: {
                    nombres: [
                        { required: true, message: 'Debe ingresar un nombre', trigger: 'blur' }
                    ],
                    cedula: [
                        { required: true, message: 'Debe ingresar la cédula', trigger: 'blur' },
                        { min: 10, message: 'La cédula debe tener mínimo 10 dígitos' }
                    ],
                    colegio: [
                        { required: true, message: 'Debe ingresar un colegio', trigger: 'blur' }
                    ],
                    telconv:[
                        { validator: this.validarTelefonos, trigger: 'change'}
                    ],
                    telcel:[
                        { validator: this.validarTelefonos, trigger: 'change'}
                    ],
                    mail: [
                        { required: true, message: 'Debe ingresar un correo electrónico', trigger: 'blur' }
                    ],
                    facultad:[
                        { required: true, message: 'Debe seleccionar una facultad', trigger: 'change' }
                    ],
                    carrera:[
                        { required: true, message: 'Debe seleccionar una carrera', trigger: 'change' }
                    ]
                }
            }
        },
        methods: {
            async onSubmit(){
                this.$refs.form.validate(async (valid) => {
                    if(valid){
                        const { data } = await api_admision.nueva_admision(this.form);
                        if(data !== null){
                            this.$notify.success({
                                title: 'Guardado exitoso!',
                                message: 'El interés de admisión ha sido ingresado al sistema'
                            });
                        }else{
                            this.$notify.error({
                                title: 'Guardado fallido!',
                                message: 'Error al ingresar el interés de admisión'
                            });
                        }
                    }else{
                        this.$notify.error({
                            title: 'Error de validación!',
                            message: 'Revisar los campos del formulario!'
                        });
                    }
                });
            },
            validarTelefonos(rule, value, callback){
                if(this.form.telconv === "" && this.form.telcel === ""){
                    callback(new Error("Es necesario por lo menos un teléfono"));
                }else{
                    callback();
                }
            },
            limpiarFormulario() {
                this.$refs.form.resetFields();
            }
        }
    }
</script>

<style scoped>

</style>
