const rutas_modulo_admision = {
    path: "/admision",
    component: () => import("../../modulos/admision/paginas/index"),
    name: "index-admision",
    meta: { opcion_menu: '1' },
    props: false
};

export default rutas_modulo_admision;
