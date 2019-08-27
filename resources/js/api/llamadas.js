const base_url = "api/v1/llamadas";

export default {
    async agregarLlamada(llamada){
        return await axios.post( base_url + "/nueva", llamada);
    },
    async listadoLlamadas(filtros){
        let parameters = "?";
        if (Object.keys(filtros).length > 0) {
            for(var filtro in filtros) {
                if(filtros.hasOwnProperty(filtro)){
                    parameters += filtro + "=" + filtros[filtro] + "&";
                }
            }
        }

        return await axios.get( base_url + "/llamadas" + parameters);
    }
}
