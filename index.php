<?php
// Nombre del archivo donde se guardarán los comentarios
$archivo = "comentarios.txt";

// Procesar el formulario si se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST["nombre"]);
    $comentario = htmlspecialchars($_POST["comentario"]);
    $fecha = date("Y-m-d H:i:s");
    
    // Agregar el nuevo comentario al archivo
    $nuevo_comentario = "$fecha | $nombre | $comentario\n";
    $fp = fopen($archivo, "a");
    if ($fp) {
        fwrite($fp, $nuevo_comentario);
        fclose($fp);
    }
}

// Leer los comentarios existentes
$comentarios = file($archivo);
$comentarios = array_reverse($comentarios); // Mostrar los más recientes primero
?>

<html>
<head>
    <title>Sistema de Comentarios</title>
</head>
<body>
    <h1>Deja tu comentario</h1>
    <form method="post" action="">
        <p>Nombre: <input type="text" name="nombre" required></p>
        <p>Comentario: <textarea name="comentario" required></textarea></p>
        <p><input type="submit" value="Enviar comentario"></p>
    </form>

    <h2>Comentarios:</h2>
    <?php
    foreach ($comentarios as $c) {
        $partes = explode(" | ", $c, 3);
        if (count($partes) == 3) {
            list($fecha, $nombre, $comentario) = $partes;
            echo "<p><strong>$nombre</strong> ($fecha):<br>";
            echo "$comentario</p>";
        }
    }
    ?>
</body>
</html>