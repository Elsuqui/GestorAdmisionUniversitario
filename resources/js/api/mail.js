const url_base = "/api/v1/mail";
export default {
    url(){
        return url_base;
    },
    async listadoPersonasInteresadas(filtros){
        let parameters = "?";
        if (Object.keys(filtros).length > 0) {
            for(var filtro in filtros) {
                if(filtros.hasOwnProperty(filtro)){
                    parameters += filtro + "=" + filtros[filtro] + "&";
                }
            }
        }
        return await axios.get(url_base + "/personas-interesadas" + parameters);
    },
    async enviarMailInformativo(datos){
        return await axios.post(url_base + "/enviar-mail-informativo", datos);
    },
    async enviarMailPersonalizado(mail){
        return await axios.post(url_base + "/enviar-mail-personalizado", { mail: mail });
    }
}
