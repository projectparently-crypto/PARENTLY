<?php

function obtenerIdEtapa($edad) {

    if ($edad >= 0 && $edad <= 3) {
        return 1; // Primera infancia
    }

    if ($edad >= 4 && $edad <= 6) {
        return 2; // Infancia temprana
    }

    if ($edad >= 7 && $edad <= 9) {
        return 3; // Niñez media
    }

    if ($edad >= 10 && $edad <= 12) {
        return 4; // Preadolescencia
    }

    return 5; // Adolescencia (13+)
}
?>