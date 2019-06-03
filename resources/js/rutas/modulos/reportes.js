const rutas_modulo_reportes = {
        path: "/reportes",
        component: () => import("../../modulos/reportes/paginas/_index"),
        name: "reportes-index",
        props: false
};

export default rutas_modulo_reportes;
