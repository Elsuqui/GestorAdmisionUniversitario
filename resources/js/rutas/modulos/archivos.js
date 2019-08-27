const rutas_modulo_archivos = {
    path: "/archivos",
    component: () => import("../../modulos/archivos/paginas/index"),
    name: "index-archivos",
    meta: {opcion_menu: '2'},
    props: false
};

export default rutas_modulo_archivos;
