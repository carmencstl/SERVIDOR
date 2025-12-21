<?php

namespace CrudGabit\Controladores;

use CrudGabit\Config\Auth;
use CrudGabit\Config\Session;
use CrudGabit\Config\Request;
use CrudGabit\Modelos\Usuario;
use CrudGabit\Modelos\Habit;
use CrudGabit\Modelos\Achievement;

class DashboardController
{
    private $twig;

    public function __construct()
    {
        // Inicializar Twig
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . "/../Vistas");
        $this->twig = new \Twig\Environment($loader);
    }

    /**
     * Mostrar dashboard
     * @return void
     */
    public function showDashboard(): void
    {
        if (!Session::active()) {
            Request::redirect("/login");
        }
//        $usuario = Auth::user();
//        $isAdmin = Auth::checkRol();
        echo $this->twig->render("dashboard.twig");
    }
}