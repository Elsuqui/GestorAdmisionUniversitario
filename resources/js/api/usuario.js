export default {
    async iniciar_sesion(credenciales){
        let respuesta = await axios.post("/ingresar", credenciales);
        return respuesta.data;
    }
}
