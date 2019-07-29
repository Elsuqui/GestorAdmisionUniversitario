const estados  = {
    1: "Sin Notificar",
    2: "Notificado",
    3: "Interesado",
    4: "No Interesado",
    5: "Inscrito"
};

export default {
    obtenerEstado(key){
        return estados[key];
    }
}
