<?php

namespace CrudGabit\Controladores;

use CrudGabit\Config\Auth;
use CrudGabit\Config\Session;
use CrudGabit\Config\Request;
use CrudGabit\Modelos\Usuario;

class AuthController
{
    private $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../Vistas');
        $this->twig = new \Twig\Environment($loader);
    }

    public function showLogin(): void
    {
        // Si ya hay sesión, vamos al dashboard del proyecto
        if (Session::active()) {
            Request::redirect("/crudGabit/dashboard");
            return;
        }

        echo $this->twig->render("auth/login.twig");
    }

    public function login(): void
    {
        $email = Request::get("email");
        $password = Request::get("password");

        if (Auth::login($email, $password)) {
            Request::redirect("/crudGabit/dashboard");
        }
        else{
            echo $this->twig->render("auth/login.twig", [
                "error" => "Los datos de acceso son incorrectos"
            ]);
        }

    }

    public function showRegister(): void
    {
        if (Session::active()) {
            Request::redirect("/crudGabit/dashboard");
            return;
        }

        echo $this->twig->render("auth/register.twig");
    }

    public function register(): void
    {
        $nombreUsuario = Request::get("nombreUsuario");
        $nombre = Request::get("nombre");
        $apellidos = Request::get("apellidos");
        $email = Request::get("email");
        $password = Request::get("password");

        $resultado = null;

        // Verificar si el email ya existe
        if (is_object(Usuario::buscarPorEmail($email))) {
            $resultado = $this->twig->render("auth/register.twig", [
                "error" => "El email ya está registrado"
            ]);
        } else {
            // Crear usuario
            $usuario = new Usuario(
                $nombreUsuario,
                $nombre,
                $apellidos,
                $email,
                $password,
                "usuario"
            );

            if ($usuario->insertarUsuario()) {
                Auth::login($email, $password);
                $resultado = Request::redirect("/dashboard");
            } else {
                $resultado = $this->twig->render("auth/register.twig", [
                    "error" => "Error al crear el usuario"
                ]);
            }
        }

        echo $resultado;
    }

    public function logout(): void
    {
        Auth::logout();
        Request::redirect('/crudGabit/login');
    }
}