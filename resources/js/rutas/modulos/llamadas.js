const rutas_modulo_llamadas = {
    path: "/llamadas",
    component: () => import("../../modulos/llamadas/paginas/index"),
    name: "index-llamadas",
    meta: { opcion_menu: '4' },
    props: false
};

export default rutas_modulo_llamadas;
