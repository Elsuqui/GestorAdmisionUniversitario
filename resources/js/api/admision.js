const url_base = "/api/v1/admision";
export default {
    url(){
        return url_base;
    },
    async nueva_admision(datos){
        return await axios.post(this.url() + "/admisiones", datos);
    },
    async cambiarEstadoInteres(datos){
        return await axios.post(this.url() + "/cambiar-estado-interes", datos);
    },
    async reporteAdmision(){
        return await axios.get(this.url() + "/reporte-admision");
    },
    async reporteNumeroIngresados(){
        return await axios.get(this.url() + "/reporte-numero-ingresados");
    }
}
