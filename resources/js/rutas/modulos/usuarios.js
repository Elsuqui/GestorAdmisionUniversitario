const rutas_modulo_usuarios = {
    path: "/usuarios",
    component: () => import("../../modulos/usuarios/index"),
    name: "index-usuarios",
    props: false,
    meta: { opcion_menu: '6' }
};

export default rutas_modulo_usuarios;
