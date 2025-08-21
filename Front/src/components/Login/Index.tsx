import React, { Component } from "react";
import Form from "./Form";
type Props = {};

type State = {};

function Index(props: Props) {
  const state: State = {};

  return (
    <>
      <Form
        titulo="Iniciar Sesión"
        label_usuario="Usuario"
        label_contrasena="Contraseña"
        texto_boton_submit="Entrar"
      />
    </>
  );
}

export default Index;
