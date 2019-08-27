const estados  = {
    1: "Sin Notificar",
    2: "Notificado",
    3: "Interesado",
    4: "No Interesado",
    5: "Inscrito"
};

const estadosInteres = [
    { key: 3, value: "Interesado" },
    { key: 4, value: "No Interesado" },
    { key: 5, value: "Inscrito" },
];

const colores = {
    1: "#ff867c",
    2: "#64d8cb"
};

export default {
    obtenerEstado(key){
        return estados[key];
    },

    obtenerColor(key){
        return colores[key];
    },

    obtenerEstadoInteres(){
        return estadosInteres;
    },

    obtenerEstadoInteresPorClave(key){
        return estadosInteres.filter((valor) =>{
            return valor.key === key;
        })[0];
    }
}
