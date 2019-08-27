const respuestas = {
    1: "NO_LLAMAR",
    2: "DEVOLVER_LLAMADA",
    3: "LLAMAR_DESPUES"
};

export default {
    obtener_listado(){
        return respuestas;
    },

    obtenerEstado(key){
        return respuestas[key];
    }
}
