const rutas_modulo_reportes = {
        path: "/reportes",
        component: () => import("../../modulos/reportes/paginas/_index"),
        name: "index-reportes",
        props: false,
        meta: { opcion_menu: '5' },
};

export default rutas_modulo_reportes;

//$message->embed(public_path().'/images/fixng_logo.png')
