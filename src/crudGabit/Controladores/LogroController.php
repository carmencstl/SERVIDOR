<?php

namespace CrudGabit\Controladores;

use CrudGabit\Modelos\Habito;
use CrudGabit\Modelos\Logro;
use CrudGabit\Config\Request;
use CrudGabit\Config\Session;

class LogroController extends BaseController
{


    /**
     * Muestra la lista de logros del usuario.
     * @return void
     *
     */
    public function index(): void
    {
        $logros = Logro::getLogrosByUser();
        $success = Session::get("success");
        Session::delete("success");

        echo $this->render("achievements/index.twig", [
            "logros" => $logros,
            "success" => $success
        ]);
    }

    /**
     * Elimina un logro por su ID.
     * @return void
     */
    public function deleteLogro(): void
    {
        $idLogro = (int)Request::post("idLogro");
        Logro::deleteLogroById($idLogro);
        Session::set("success", "Logro eliminado correctamente.");
        Request::redirect("/crudGabit/achievements");
    }

    /**
     * Muestra el formulario de edición de un logro.
     * @return void
     */
    public function showEdit(): void
    {
        // Intentamos obtener el ID desde POST (botón editar) o sesión
        $idLogro = (int)Request::post("idLogro");
        if (!$idLogro) {
            $idLogro = Session::get("logro_edit_id");
        } else {
            // Guardamos en sesión para futuras llamadas
            Session::set("logro_edit_id", $idLogro);
        }

        // Si no hay ID válido, redirigimos al listado
        if (!$idLogro) {
            Request::redirect("/crudGabit/achievements");
            return;
        }

        // Obtenemos los datos del logro
        $logro = Logro::getById($idLogro);

        // Mensaje de éxito si existe
        $success = Session::get("success");
        Session::delete("success");

        echo $this->render("achievements/edit.twig", [
            "logro" => $logro,
            "success" => $success
        ]);
    }



    /**
         * Actualiza un logro con los datos del formulario.
         * @return void
         */
    public function updateLogro(): void
    {
        $idLogro = (int)Request::post("idLogro");
        $nombreLogro = Request::post("nombre");
        $descripcion = Request::post("descripcion");

        // Actualizamos en la BD
        Logro::actualizarLogro($idLogro, $nombreLogro, $descripcion);

        // Guardamos mensaje de éxito y ID en sesión
        Session::set("success", "Logro actualizado correctamente.");
        Session::set("logro_edit_id", $idLogro);

        // Redirigimos a la misma página de edición
        Request::redirect("/crudGabit/achievements/edit");
    }



    /**
     * Muestra el formulario para crear un nuevo logro.
     * @return void
     */
    public function showCreate(): void
    {
        $habitosDisponibles = Habito::getHabitsByUser();

        // Recuperamos mensaje de éxito si existe
        $success = Session::get("success");
        Session::delete("success"); // solo se muestra una vez

        echo $this->render("achievements/create.twig", [
            "habitos" => $habitosDisponibles,
            "success" => $success
        ]);
    }


    /**
     * Crea un nuevo logro con los datos del formulario.
     * @return void
     */
    public function createLogro(): void
    {
        $nombreLogro = Request::post("nombreLogro");
        $descripcion = Request::post("descripcion");
        $habito = Request::post("idCamino");

        $logro = Logro::crearLogro($nombreLogro, $descripcion, $habito);
        $logro->insertarLogroEnBD();

        // Guardamos mensaje de éxito en sesión
        Session::set("success", "Logro creado correctamente.");

        // Redirigimos a la misma página de creación
        Request::redirect("/crudGabit/achievements/create");
    }


}