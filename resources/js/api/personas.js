const base_url = "api/v1/personas";

export default {
    async buscarPersona(persona) {
        return await axios.get(base_url + "/busqueda?valor=" + persona);
    },
    async listadoIntereses(filtros) {
        console.log("Filtros: ", filtros);
        console.log("Keys: ", Object.keys(filtros));
        let parameters = "?";
        if (Object.keys(filtros).length > 0) {
            for(var filtro in filtros) {
                if(filtros.hasOwnProperty(filtro)){
                    parameters += filtro + "=" + filtros[filtro] + "&";
                }
            }
        }

        return await axios.get( base_url + "/intereses" + parameters);
    },

    async interesados(filtros){
        let parameters = "?";
        if (Object.keys(filtros).length > 0) {
            for(var filtro in filtros) {
                if(filtros.hasOwnProperty(filtro)){
                    parameters += filtro + "=" + filtros[filtro] + "&";
                }
            }
        }

        return await axios.get( base_url + "/listado-interesados" + parameters);
    }
}
