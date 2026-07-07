<?php

function columna_existe(mysqli $conexion, string $tabla, string $columna): bool
{
    $tabla = mysqli_real_escape_string($conexion, $tabla);
    $columna = mysqli_real_escape_string($conexion, $columna);
    $res = mysqli_query($conexion, "SHOW COLUMNS FROM `$tabla` LIKE '$columna'");
    return $res && mysqli_num_rows($res) > 0;
}

function asegurar_comunidad_schema(mysqli $conexion): void
{
    if (!columna_existe($conexion, 'preguntasc', 'id_usuario')) {
        mysqli_query($conexion, "ALTER TABLE preguntasc ADD COLUMN id_usuario INT NULL AFTER id_pregunta");
    }

    if (!columna_existe($conexion, 'preguntasc', 'editado')) {
        mysqli_query($conexion, "ALTER TABLE preguntasc ADD COLUMN editado TINYINT(1) NOT NULL DEFAULT 0");
    }

    mysqli_query($conexion, "CREATE TABLE IF NOT EXISTS reacciones_preguntas (
        id_reaccion INT AUTO_INCREMENT PRIMARY KEY,
        id_pregunta INT NOT NULL,
        id_usuario INT NOT NULL DEFAULT 0,
        tipo VARCHAR(30) NOT NULL,
        fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY uq_reaccion_pregunta (id_pregunta, id_usuario, tipo),
        INDEX idx_reaccion_pregunta (id_pregunta)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

    mysqli_query($conexion, "CREATE TABLE IF NOT EXISTS denuncias_preguntas (
        id_denuncia INT AUTO_INCREMENT PRIMARY KEY,
        id_pregunta INT NOT NULL,
        id_usuario INT NULL,
        motivo VARCHAR(120) NOT NULL DEFAULT 'Contenido reportado',
        fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_denuncia_pregunta (id_pregunta)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
}

function usuario_actual_id(): int
{
    return (int)($_SESSION['usuario_id'] ?? $_SESSION['id_usuario'] ?? $_SESSION['id'] ?? 0);
}

function usuario_es_admin(): bool
{
    return isset($_SESSION['es_admin']) && (int)$_SESSION['es_admin'] === 1;
}
