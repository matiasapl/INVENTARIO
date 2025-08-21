import React, { Component } from "react";

type Props = {
  titulo: string;
  label_usuario: string;
  label_contrasena: string;
  texto_boton_submit: string;
};

type State = {};

function Form({
  titulo,
  label_usuario,
  label_contrasena,
  texto_boton_submit,
}: Props) {
  const state: State = {};

  return (
    <>
      <div>
        <h1>{titulo}</h1>
        <form action="" method="post">
          <label htmlFor="username">{label_usuario}</label>
          <input
            type="text"
            id="username"
            name="username"
            placeholder={label_usuario}
            required
          />

          <label htmlFor="password">{label_contrasena}</label>
          <input
            type="password"
            id="password"
            name="password"
            placeholder={label_contrasena}
            required
          />

          <button type="submit">{texto_boton_submit}</button>
        </form>
      </div>
    </>
  );
}

export default Form;
