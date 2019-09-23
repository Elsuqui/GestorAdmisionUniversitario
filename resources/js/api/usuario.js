export default {
    async iniciar_sesion(credenciales){
        let respuesta = await axios.post("/ingresar", credenciales);
        return respuesta.data;
    },

    async cambiar_password(form){
        let respuesta = await axios.post("/password/email", form);
        return respuesta.data;
    },

     async cambiar_password_confirm(form){
         let respuesta = await axios.post("/password/reset", form);
         return respuesta.data;
     }
}
