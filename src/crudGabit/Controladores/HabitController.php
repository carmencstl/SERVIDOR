<?php

namespace CrudGabit\Controladores;

use CrudGabit\Config\Request;
use CrudGabit\Config\Session;
use CrudGabit\Modelos\Habito;
use CrudGabit\Enums\Categoria;
class HabitController extends BaseController
{
    /**
     * Mostrar la lista de hábitos
     * @return void
     */
    public function index(): void
    {
        $habitos = Habito::getHabitsByUser();

        $success = Session::get("success");
        $error = Session::get("error");

        Session::delete("success");
        Session::delete("error");

        echo $this->render("habits/index.twig", [
            "habits" => $habitos
            ,"success" => $success
            ,"error" => $error
        ]);
    }

    /**
     * Borrar un hábito por su ID
     * @return void
     */
    public function deleteHabit(): void
    {
        $idHabit = (int)Request::post("idCamino");
        Habito::deleteHabitById($idHabit);

        Session::set("success", "Habito eliminado correctamente.");

        Request::redirect("/crudGabit/habits");
    }

    /**
     * Actualizar un hábito existente
     * @return void
     */
    public function updateHabit(): void
    {
        $idHabito = (int)Request::post("idCamino");
        $nombreHabito = Request::post("nombreHabito");
        $descripcion = Request::post("descripcion");
        $categoria = Request::post("categoria");

        Habito::actualizarHabito($idHabito, $nombreHabito, $descripcion, $categoria);

        Session::set("success", "Hábito actualizado correctamente.");
        Session::set("habit_edit_id", $idHabito);

        Request::redirect("/crudGabit/habits/edit");
    }


    /**
     * Mostrar el formulario de edición de un hábito
     * @return void
     */
    public function showEdit(): void
    {
        $idHabito = Request::post("idCamino");
        if (!$idHabito) {
            $idHabito = Session::get("habit_edit_id");
        } else {
            Session::set("habit_edit_id", $idHabito);
        }
        if (!$idHabito) {
            Request::redirect("/crudGabit/habits");
            return;
        }

        $habit = Habito::getById((int)$idHabito);
        $categorias = Categoria::toArray();

        $success = Session::get("success");
        Session::delete("success");

        echo $this->render("habits/edit.twig", [
            "habit" => $habit,
            "categorias" => $categorias,
            "success" => $success
        ]);
    }



    /**
     * Mostrar el formulario de creación de un nuevo hábito
     * @return void
     */
    public function showCreate(): void
    {
        $categorias = Categoria::toArray();

        $success = Session::get("success");
        Session::delete("success");

        echo $this->render("habits/create.twig", [
            "categorias" => $categorias,
            "success" => $success
        ]);
    }


    /**
     * Crear un nuevo hábito
     * @return void
     */
    public function createHabit(): void
    {
        $nombre = Request::post("nombreHabito");
        $descripcion = Request::post("descripcion");
        $categoria = Request::post("categoria");

        $habito = Habito::crearHabito($nombre, $descripcion, $categoria);
        $habito->insertarHabitoEnBD();
        Session::set("success", "Hábito creado correctamente.");
        Request::redirect("/crudGabit/habits/create");
    }

}