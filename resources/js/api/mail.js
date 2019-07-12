const url_base = "/api/v1/mail";
export default {
    url(){
        return url_base;
    },
    async listadoPersonasInteresadas(){
        return await axios.get(url_base + "/personas-interesadas");
    },
    async enviarMailInformativo(datos){
        return await axios.post(url_base + "/enviar-mail-informativo", datos);
    }
}
