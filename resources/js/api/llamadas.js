const base_url = "api/v1/llamadas";

export default {
    async agregarLlamada(llamada){
        return await axios.post( base_url + "/nueva", llamada);
    }
}
