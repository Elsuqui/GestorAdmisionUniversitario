const rutas_modulo_mail = {
    path: "/mail",
    component: () => import("../../modulos/mail/paginas/index"),
    name: "index-mail",
    meta: { opcion_menu: '2' },
    props: false
};

export default rutas_modulo_mail;
