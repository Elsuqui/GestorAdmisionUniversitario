const base_url = "/api/v1/usuarios";

export default {
    async consultarTodos(){
        return await axios.get(base_url + "/listado");
    },
    async roles(){
        return await axios.get(base_url + "/roles");
    },
    async asignarRol(usuario, rol){
        return await axios.post(base_url + "/asignar", { usuario: usuario, rol: rol});
    },
    async removerRol(usuario, rol){
        return await axios.post(base_url + "/remover", { usuario: usuario, rol: rol});
    },
    async editarUsuario(payload, id){
        return await axios.post(base_url + "/editar/" + id, payload);
    },
    async crearUsuario(payload){
        return await axios.post(base_url + "/crear", payload);
    }
}
