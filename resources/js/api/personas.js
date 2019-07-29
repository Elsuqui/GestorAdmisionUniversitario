const base_url = "api/v1/personas";

export default {
    async buscarPersona(persona){
        return await axios.get( base_url + "/busqueda?valor=" + persona);
    }
}
