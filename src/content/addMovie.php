<?php namespace MyApp\content;
use MyApp\includes\Connection_db as connection;
use MyApp\includes\Image as image;
use MyApp\includes\PlatformDB as platform;
// include("../includes/platformDB.php");
// include("header.php"); 
?>
<link rel="stylesheet" href="../css/style.css"> 

<?php 
    // Streaming platform query
    $platformDB = new platform();
    $plataforma = $platformDB->getPlatforms();

    // Check for errors
    $title_error = $sinopsis_error = $img_error = "";
    function empty_title($title){
        global $title_error;
        if (empty($title)) {
            $title_error = "Title is required";
            return true;
        }
        return false;
    }

    function empty_sinopsis($sinopsis){
        global $sinopsis_error;
        if (empty($sinopsis)) {
            $sinopsis_error = "Sinopsis is required";
            return true;
        }
        return false;
    }

    function empty_image($img){
        global $img_error;
        if (empty($img)) {
            $img_error = "Image is required";
            return true;
        }
        return false;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check Required files
        $title = $_POST["title"];
        $title_ok = !empty_title($title);
        
        $sinopsis = $_POST["sinopsis"];
        $sinopsis_ok = !empty_sinopsis($sinopsis);

        $img = $_POST["caratula"];
        $img_ok = !empty_image($img);

        if ($title_ok && $sinopsis_ok && $img_ok) {
            $image = new Image();
            $img_error = $image->check_image($_FILES);
        }
    }
?>

<section class="form-movie">
    <h4>Afegir nova pel·lícula</h4>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        <span class="error">* <?php echo $title_error; ?></span>
        <input class="movie-data" type="text" name="title" placeholder="Títol">
        <span class="error">* <?php echo $sinopsis_error; ?></span>
        <textarea class="movie-data" name="sinopsis" cols="30" rows="5" placeholder="Sinopsis"></textarea>
        <p>Publicació:</p>
        <input class="movie-data" type="date" name="published">
        <input class="movie-data" type="number" name="valoracio" placeholder="Valoració">
        <select class="movie-data" name="plataforma">
            <?php for ($i=0; $i < count($plataforma); $i++) { ?>
                <option value="<?php echo $plataforma[$i] ?>"> <?php echo $plataforma[$i] ?></option>
            <?php } ?>
        </select>
        <span class="error">* <?php echo $img_error; ?></span>
        <p id="caratula-text">Caràtula:</p>
        <input class="movie-data" type="file" name="caratula">
        <span class="error">* Required fields</span>
        <button type="submit">Enviar</button>
    </form>
</section>

