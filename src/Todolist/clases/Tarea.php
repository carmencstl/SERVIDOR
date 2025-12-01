<?php

  /**
	 * Desarrollo web en Entorno Servidor
	 * Todo List
	 * Antonio J. Sánchez 
	 */

  namespace Clases ;

  class Tarea
  {
      private int $idCategoria ;
      private int $idUsuario ;
      private int $idTarea ;
      private string $descripcion ;
      private int $fecha ;    # marca de tiempo (timestamp)
      private bool $completada ;
  }