const rutas_modulo_plantillas = {
    path: "/plantilla",
    component: () => import("../../modulos/plantilla/paginas/index"),
    name: "index-plantilla",
    props: false,
    meta: { opcion_menu: '7' }
};

export default rutas_modulo_plantillas;
