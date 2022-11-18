<?php

function usuarioAutenticado() : bool {
    session_start();

    $auth = $_SESSION['login'];
    if ($auth) {
        return true;
    }
    return false;
}