const estados  = {
    1: "Sin Notificar",
    2: "Notificado",
    3: "Aceptado",
    4: "Rechazado"
};

export default {
    obtenerEstado(key){
        return estados[key];
    }
}
