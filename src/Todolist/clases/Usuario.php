<?php

  /**
	 * Desarrollo web en Entorno Servidor
	 * Todo List
	 * Antonio J. Sánchez 
	 */
  namespace Clases ;

  class Usuario
  {
      public int $idUsuario ;
      public string $dniUsuario;
      public string $nombre;
      public string $apellido;
      public string $email;
      public string $password;

      /**
       * @return string
       */
      public function __toString(): string
      {
          return "$this->dni: $this->nombre $this->apellido, $this->email<br/>" ;
      }

  }
