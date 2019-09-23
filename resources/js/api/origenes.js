const base_url = "/api/v1/origenes";

export default {
    async listado(){
        return await axios.get(base_url);
    }
}
