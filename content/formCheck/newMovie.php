<!-- Comprovació imatge -->
<?php
    $img_folder = "../img/";
    $file = $img_folder . basename($_FILES["caratula"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($file,PATHINFO_EXTENSION));

    // Comprovar que és una imatge
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["caratula"]["tmp_name"]);
        if($check !== false) {
            echo "El fitxer és una imatge - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "El fitxer no és una imatge";
            $uploadOk = 0;
        }
    }

    // Comprovar si el fitxer ja existeix
    if (file_exists($file)) {
        echo "El fitxer ja existeix.";
        $uploadOk = 0;
    }

    // Limitació del tamany
    if ($_FILES["caratula"]["size"] > 500000) {
        echo "Ho sento el fitxer pesa massa";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "El fitxer no s'ha penjat.";
      // Si és OK pujarà l'arxiu
    } else {
        if (move_uploaded_file($_FILES["caratula"]["tmp_name"], $file)) {
            echo "El fitxer ". basename( $_FILES["caratula"]["name"]). " s'ha penjat correctament.";
        } else {
            echo "Hi ha hagut un error a l'hora de penjar el fitxer. Torna a provar en un altre moment.";
        }
    }
?>