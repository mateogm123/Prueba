<?php

    //Iniciar sesión
    session_start();

    //Para ordenar
    $orden=filter_input(INPUT_GET,"orden", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $direccion=filter_input(INPUT_GET,"direccion", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if($orden && $direccion){
        foreach ($_SESSION["personajes"] as $key => $row){
            $array[$key] = $row[$orden];
        }
        $dir= ($direccion=="ascendente") ? SORT_ASC : SORT_DESC;
        array_multisort($array, $dir, $_SESSION["personajes"]);
    }

    //Coger accion e índice
    $accion=filter_input(INPUT_GET,"accion", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $indiceOb= filter_input(INPUT_GET, "indice", FILTER_SANITIZE_NUMBER_INT);

    //Para guardar
    if(isset($_GET['guardar'])){
        $indiceOb= filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION["personajes"][$indiceOb]["nombre"]=$_GET['nombre'];
        $_SESSION["personajes"][$indiceOb]["apellido"]=$_GET['apellido'];
        $_SESSION["personajes"][$indiceOb]["nacionalidad"]=$_GET['nacionalidad'];
        $_SESSION["personajes"][$indiceOb]["nacimiento"]=$_GET['nacimiento'];
    }

    //Para eliminar
    if($accion=="eliminar" && $indiceOb > -1){
        unset($_SESSION["personajes"][$indiceOb]);
    }

    //Para restaurar
    if($accion=="restaurar"){
        unset($_SESSION["personajes"]);
    }

    //Crear array
    if(!isset($_SESSION["personajes"])){
        $_SESSION["personajes"]=[
            ["nombre"=>"Mauro Ezequiel","apellido"=>"Lombardo","imagen"=>"duki.png","nacionalidad"=>"Argentino","nacimiento"=>"1996/06/24"],
            ["nombre"=>"Pedro","apellido"=>"Sánchez","imagen"=>"pedro.jpg","nacionalidad"=>"Español","nacimiento"=>"1972/02/29"],
            ["nombre"=>"Lionel Andrés","apellido"=>"Messi","imagen"=>"messi.jpg","nacionalidad"=>"Argentino","nacimiento"=>"1987/06/24"],
            ["nombre"=>"Cristiano","apellido"=>"Ronaldo","imagen"=>"cristiano.jpg","nacionalidad"=>"Portugués","nacimiento"=>"1985/02/05"],
            ["nombre"=>"Pau","apellido"=>"Gasol","imagen"=>"pau.jpg","nacionalidad"=>"Español","nacimiento"=>"1980/07/06"],
            ["nombre"=>"Benito Antonio","apellido"=>"Martínez","imagen"=>"bad.jpg","nacionalidad"=>"Puertorriqueño","nacimiento"=>"1994/03/10"],
            ["nombre"=>"Raúl Alejandro","apellido"=>"Ocasio","imagen"=>"rauw.jpg","nacionalidad"=>"Puertorriqueño","nacimiento"=>"1993/01/10"],
            ["nombre"=>"Juan Carlos","apellido"=>"Ozuna","imagen"=>"ozuna.jpg","nacionalidad"=>"Puertorriqueño","nacimiento"=>"1992/03/13"],
            ["nombre"=>"Pedro","apellido"=>"González","imagen"=>"pedri.jpg","nacionalidad"=>"Español","nacimiento"=>"2002/11/25"],
            ["nombre"=>"Anssumane","apellido"=>"Fati","imagen"=>"ansu.jpg","nacionalidad"=>"Español","nacimiento"=>"2002/10/31"],
            ["nombre"=>"Ousmane","apellido"=>"Dembélé","imagen"=>"dembele.jpg","nacionalidad"=>"Francés","nacimiento"=>"1997/05/15"],
            ["nombre"=>"Fernando","apellido"=>"Alonso","imagen"=>"alonso.jpg","nacionalidad"=>"Español","nacimiento"=>"1981/07/29"],
            ["nombre"=>"Vinícius José","apellido"=>"Paixaõ de Oliveira","imagen"=>"vinicius.jpg","nacionalidad"=>"Brasileño","nacimiento"=>"2000/07/12"],
            ["nombre"=>"Karim","apellido"=>"Benzema","imagen"=>"benzema.jpg","nacionalidad"=>"Francés","nacimiento"=>"1987/12/19"],
            ["nombre"=>"Kylian","apellido"=>"Mbappé","imagen"=>"mbappe.jpg","nacionalidad"=>"Francés","nacimiento"=>"1998/12/20"],
            ["nombre"=>"Rafael","apellido"=>"Nadal","imagen"=>"rafa.jpg","nacionalidad"=>"Español","nacimiento"=>"1986/06/03"],
            ["nombre"=>"Luka","apellido"=>"Modrić","imagen"=>"modric.jpg","nacionalidad"=>"Croata","nacimiento"=>"1985/09/09"],
            ["nombre"=>"Toni","apellido"=>"Kroos","imagen"=>"toni.jpg","nacionalidad"=>"Alemán","nacimiento"=>"1990/01/04"],
            ["nombre"=>"Erling","apellido"=>"Haaland","imagen"=>"haaland.jpg","nacionalidad"=>"Noruego","nacimiento"=>"2000/07/21"],
            ["nombre"=>"Diego Armando","apellido"=>"Maradona","imagen"=>"maradona.jpg","nacionalidad"=>"Argentino","nacimiento"=>"1960/10/30"],
            ["nombre"=>"Diego Ramón","apellido"=>"Jiménez","imagen"=>"cigala.jpg","nacionalidad"=>"Español","nacimiento"=>"1968/12/27"],
            ["nombre"=>"Ramón","apellido"=>"Melendi","imagen"=>"melendi.jpg","nacionalidad"=>"Español","nacimiento"=>"1979/01/21"],
            ["nombre"=>"José Juan","apellido"=>"Figueiras","imagen"=>"josejuan.jpg","nacionalidad"=>"Español","nacimiento"=>"1979/12/31"],
            ["nombre"=>"Isaac","apellido"=>"Palazón","imagen"=>"isi.jpg","nacionalidad"=>"Español","nacimiento"=>"1994/12/27"],
            ["nombre"=>"Emma Charlotte","apellido"=>"Watson","imagen"=>"emma.jpg","nacionalidad"=>"Británica","nacimiento"=>"1990/04/15"]
        ];
    }

    //Para cambiar fotos
    $error="";
    if (isset($_POST['subirF'])){
        if(substr($_FILES['imagen']['name'], -3, 3)=="jpg" || substr($_FILES['imagen']['name'], -3, 3)=="png"){
            $path = "img/". basename($_FILES['imagen']['name']);
            if(move_uploaded_file($_FILES['imagen']['tmp_name'], $path)) {
                $error= "El archivo ".  basename( $_FILES['imagen']['name']). " ha sido subido";
                $_SESSION["personajes"][$indiceOb]["imagen"]=$_FILES['imagen']['name'];
            } else{
                $error="El archivo no se ha subido correctamente";
            }
        }else{
            $error= "El archivo no se ha subido correctamente";
        }
    }

?>

<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Listado de personajes</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>

    <body>

        <!-- Título -->
        <h1>LISTADO DE PERSONAJES</h1>
        <a href="index.php?accion=restaurar"><input type="submit" value="Restaurar" name="restaurar" class="boton"></a>

        <!-- Cabecera de la lista con botones asc y desc -->
        <ul class="titulo">
            <li>Imagen</li>
            <li>Nombre
                <a href="index.php?orden=nombre&direccion=ascendente"><img src="img/arriba.png" alt="Orden ascendente" class="flecha"></a>
                <a href="index.php?orden=nombre&direccion=descendente"><img src="img/abajo.png" alt="Orden descendente" class="flecha"></a>
            </li>
            <li>Apellido
                <a href="index.php?orden=apellido&direccion=ascendente"><img src="img/arriba.png" alt="Orden ascendente" class="flecha"></a>
                <a href="index.php?orden=apellido&direccion=descendente"><img src="img/abajo.png" alt="Orden descendente" class="flecha"></a>
            </li>
            <li>Nacimiento
                <a href="index.php?orden=nacimiento&direccion=ascendente"><img src="img/arriba.png" alt="Orden ascendente" class="flecha"></a>
                <a href="index.php?orden=nacimiento&direccion=descendente"><img src="img/abajo.png" alt="Orden descendente" class="flecha"></a>
            </li>
            <li>Nacionalidad</li>
            <li>Acciones</li>
        </ul>

        <!-- Bucle con cada personaje de la lista -->
        <ul>
            <?php foreach ($_SESSION["personajes"] as $indice => $personaje){?>

                <!-- Para editar personaje -->
                <?php if($accion=="editar" && $indiceOb==$indice){ ?>

                    <!-- Editar imagen -->
                    <form enctype="multipart/form-data" method="post">
                        <p><?php echo $error ?></p>
                        <li>
                            <input type="file" name="imagen">
                            <input type="submit" value="Subir" name="subirF">
                        </li>
                    </form>

                    <!-- Editar texto -->
                    <form>
                        <li><input type="text" name="nombre" value="<?php echo $personaje["nombre"] ?>" class="texto"></li>
                        <li><input type="text" name="apellido" value="<?php echo $personaje["apellido"] ?>" class="texto"></li>
                        <li><input type="text" name="nacimiento" value="<?php echo $personaje["nacimiento"] ?>" class="texto"></li>
                        <li><input type="text" name="nacionalidad" value="<?php echo $personaje["nacionalidad"] ?>" class="texto"></li>
                        <li>
                            <input name="id" type="hidden" value="<?php echo $indice ?>">
                            <input type="submit" name="guardar" value="Guardar" class="boton">
                        </li>
                    </form>

                <!-- Cada personaje de la lista -->
                <?php }else{ ?>
                    <li><img src="img/<?php echo $personaje["imagen"] ?>" alt="Imagen de un personaje" class="principal"></li>
                    <li><?php echo $personaje["nombre"] ?></li>
                    <li><?php echo $personaje["apellido"] ?></li>
                    <li><?php echo $personaje["nacimiento"] ?></li>
                    <li><?php echo $personaje["nacionalidad"] ?></li>
                    <li>

                        <!-- Botones con acciones -->
                        <a href="ver.php?indice=<?php echo $indice ?>" target="_blank"><img src="img/ver.png" alt="Ver" class="icono"></a>
                        <a href="index.php?accion=eliminar&indice=<?php echo $indice ?>"><img src="img/eliminar.png" alt="Ver" class="icono"></a>
                        <a href="index.php?accion=editar&indice=<?php echo $indice ?>"><img src="img/editar.png" alt="Ver" class="icono"></a>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>

    </body>
</html>
