<?php
$sql = "SELECT * FROM comentarios_experiencias
        WHERE id_experiencia = ?
        ORDER BY fecha_comentario DESC";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $fila['id_experiencia']);
$stmt->execute();

$resultado = $stmt->get_result();

while ($comentario = $resultado->fetch_assoc()) {
    ?>
    <div class="comentario">
        <strong><?= htmlspecialchars($comentario['nombre_usuario']) ?></strong><br>
        <?= nl2br(htmlspecialchars($comentario['comentario'])) ?><br>
        <small><?= $comentario['fecha_comentario'] ?></small>
    </div>
    <?php
}
?>