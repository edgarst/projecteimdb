<?php include("header.php"); ?>
<?php require_once("../include/connection_db.php"); ?>
<link rel="stylesheet" href="../css/style.css"> 

<?php 
    try{
        $sql = $connect->prepare('SELECT * FROM plataforma');
        $sql->execute(array());
        $result = $sql->fetchAll();
    
        $i = 0;
        foreach ($result as $row) {
            $plataforma[$i] = $row["nom"];
            $i++;
        }
    }catch(PDOException $e){
        echo "ERROR: " . $e->getMessage();
    }
?>

<section class="form-movie">
    <h4>Afegir nova pel·lícula</h4>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        <input class="movie-data" type="text" name="title" placeholder="Títol">
        <span class="error">* <?php echo $title_error; ?></span>
        <textarea class="movie-data" name="sinopsis" cols="30" rows="5" placeholder="Sinopsis"></textarea>
        <p>Publicació:</p>
        <input class="movie-data" type="date" name="published">
        <input class="movie-data" type="number" name="valoracio" placeholder="Valoració">
        <select class="movie-data" name="plataforma">
            <?php for ($i=0; $i < count($plataforma); $i++) { ?>
                <option value="<?php echo $plataforma[$i] ?>"> <?php echo $plataforma[$i] ?></option>
            <?php } ?>
        </select>
        <p>Caràtula:</p>
        <input class="movie-data" type="file" name="caratula">
        <button type="submit">Enviar</button>
    </form>
</section>

<?php
    $title_error = $img_error = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Comprovació imatge
        $img_folder = "./content/img/";
        $file = $img_folder . basename($_FILES["caratula"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($file,PATHINFO_EXTENSION));
    
        // Comprovar que és una imatge
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["caratula"]["tmp_name"]);
            if($check == false) {
                $img_error = "El fitxer no és una imatge";
                $uploadOk = 0;
            }
        }
    
        // Comprovar si el fitxer ja existeix
        if (file_exists($file)) {
            $img_error = "El fitxer ja existeix.";
            $uploadOk = 0;
        }
    
        // Limitació del tamany
        if ($_FILES["caratula"]["size"] > 500000) {
            $img_error = "Ho sento el fitxer pesa massa";
            $uploadOk = 0;
        }
    
        if ($uploadOk == 0) {
            $img_error = "El fitxer no s'ha penjat. " . $img_error;
            // Si és OK pujarà l'arxiu
        } else {
            if (move_uploaded_file($_FILES["caratula"]["tmp_name"], $file)) {
                $img_error = "El fitxer ". basename( $_FILES["caratula"]["name"]). " s'ha penjat correctament.";
            } else {
                $img_error = "Hi ha hagut un error a l'hora de penjar el fitxer. Torna a provar en un altre moment.";
            }
        }
    }
?>