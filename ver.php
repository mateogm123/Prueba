<?php

    //Seguir en la sesión que tenemos
    session_start();

    //Saber índice del personaje
    $indice= filter_input(INPUT_GET, "indice", FILTER_SANITIZE_NUMBER_INT);

    //Con el índice sacar resto de datos del personaje
    if($indice > -1){
        $nombre= $_SESSION["personajes"][$indice]["nombre"];
        $apellido= $_SESSION["personajes"][$indice]["apellido"];
        $nacionalidad= $_SESSION["personajes"][$indice]["nacionalidad"];
        $nacimiento= $_SESSION["personajes"][$indice]["nacimiento"];
        $imagen= $_SESSION["personajes"][$indice]["imagen"];
    }

?>

<html lang="es">
    <head>
        <meta charset="utf-8">
        <title><?php echo $nombre ?></title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>

    <!-- Mostrar datos del personaje -->
    <body>
        <h1><?php echo $nombre." "."$apellido" ?></h1>
        <p><?php echo $nacionalidad." - "."$nacimiento" ?></p>

        <img src="img/<?php echo $imagen ?>" alt="Imagen de un personaje" class="foto">

    </body>
</html>
