<?php

namespace CrudGabit\Controladores;

use CrudGabit\Config\Auth;
use CrudGabit\Config\Router;
use CrudGabit\Config\Session;
use CrudGabit\Config\Request;
use CrudGabit\Modelos\Usuario;

class AuthController extends BaseController
{


    /**
     * Mostrar formulario de login
     * @return void
     */
    public function showLogin(): void
    {
        if (Session::active()):
            Request::redirect("/dashboard");
        endif ;
        echo $this->render("auth/login.twig");
    }


    /**
     * Procesar login
     * @return void
     */
    public function login(): void
    {
        $email = Request::get("email");
        $password = Request::get("password");

        if (Auth::login($email, $password)) {
            Request::redirect("/crudGabit/dashboard");
        }
        else{
            echo $this->render("auth/login.twig", [
                "error" => "Los datos de acceso son incorrectos"
            ]);
        }
    }

    /**
     * Mostrar formulario de registro
     * @return void
     */
    public function showRegister(): void
    {
        if(Session::active()) {
            Request::redirect("/dashboard");
        }
        echo $this->render("auth/register.twig");
    }


    public function register(): void
    {
        $email = Request::get("email");
        $nombreUsuario = Request::get("nombreUsuario");
        $resultado = null;

        if (is_object(Usuario::getByEmail($email))) {
            $resultado = $this->render("auth/register.twig", [
                "error" => "El email ya está registrado. Por favor, usa otro email."
            ]);
        } elseif (is_object(Usuario::getByNombreUsuario($nombreUsuario))) {
            $resultado = $this->render("auth/register.twig", [
                "error" => "El nombre de usuario ya está en uso. Por favor, elige otro."
            ]);
        } else {
            $usuario = Usuario::crear(
                $nombreUsuario,
                Request::get("nombre"),
                Request::get("apellidos"),
                $email,
                Request::get("password"),
                "usuario"
            );

            if ($usuario->insertarUsuario()) {
                Auth::login($email, Request::get("password"));
                $resultado = Request::redirect("/dashboard");
            } else {
                $resultado = $this->render("auth/register.twig", [
                    "error" => "Error al crear el usuario. Inténtalo de nuevo."
                ]);
            }
        }
        echo $resultado;
    }

    /**
     * Cerrar sesión
     * @return void
     */
    public function logout(): void
    {
        Auth::logout();
        Request::redirect("/crudGabit/login");
    }
}