<?php

    class Usuario {
        private ?int $idUsuario = null;
        private string $email;
        private string $nombre;
        private string $apellido;
        private string $password;

        public function __construct(
            string $email,
            string $nombre,
            string $apellidos,
            string $password,
        ) {
            $this->email = $email;
            $this->nombre = $nombre;
            $this->apellido = $apellidos;
            $this->password = $password;
        }

        public function getIdUsuario(): ?int
        {
            return $this->idUsuario;
        }

        public function setIdUsuario(?int $idUsuario): void
        {
            $this->idUsuario = $idUsuario;
        }

        public function getEmail(): string
        {
            return $this->email;
        }

        public function setEmail(string $email): void
        {
            $this->email = $email;
        }

        public function getNombre(): string
        {
            return $this->nombre;
        }

        public function setNombre(string $nombre): void
        {
            $this->nombre = $nombre;
        }

        public function getApellidos(): string
        {
            return $this->apellidos;
        }

        public function setApellidos(string $apellidos): void
        {
            $this->apellidos = $apellidos;
        }

        public function getPassword(): string
        {
            return $this->password;
        }

        public function setPassword(string $password): void
        {
            $this->password = $password;
        }



    }

