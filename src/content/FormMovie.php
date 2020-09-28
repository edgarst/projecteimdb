<?php 
namespace MyApp\content;
use MyApp\includes\PlatformDB as platform;
use MyApp\includes\Image as image;
use MyApp\includes\MovieAction as action;
use MyApp\includes\ConnectionDB as connection;
include("header.html"); 
// include("../includes/PlatformDB.php"); 
?>
<link rel="stylesheet" href="../css/style.css"> 


<?php 
    
?>

<section class="form-movie">
    <h4>Afegir nova pel·lícula</h4>
    <form method="post" action="" enctype="multipart/form-data">
        <span class="error">* <?php echo $title_error; ?></span>
        <input class="movie-data" type="text" name="title" placeholder="Títol" required>
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
