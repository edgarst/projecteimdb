<?php namespace MyApp\content;
use MyApp\includes\PlatformDB as platformDB;
use MyApp\includes\Image as image;
use MyApp\includes\MovieAction as action;
use MyApp\includes\ConnectionDB as connection;
// include("header.html"); 
    
?>
<link rel="stylesheet" href="../css/formMovie.css"> 

<?php 
    $platform = new platformDB();
    $platforms = $platform->getPlatforms();
?>

<section class="form-movie">
    <h4>Afegir nova pel·lícula</h4>
    <form method="post" action="" enctype="multipart/form-data">
        <span class="error">*</span>
        <input class="movie-data" type="text" name="title" placeholder="Títol" required>
        <span class="error">*</span>
        <textarea class="movie-data" name="sinopsis" cols="30" rows="5" placeholder="Sinopsis" required></textarea>
        <span class="error">*</span>
        <p id="published-date">Publicació:</p>
        <input class="movie-data" type="date" name="published" required>
        <!-- <input type="text" name="director"> -->
        <input class="movie-data" type="number" name="valoracio" placeholder="Valoració">
        <span class="error">*</span>
        <select class="movie-data" name="plataforma" required>
            <?php for ($i=0; $i < count($platforms); $i++) { ?>
                <option value="<?php echo $platforms[$i] ?>"> <?php echo $platforms[$i] ?></option>
            <?php } ?>
        </select>
        <span class="error">*</span>
        <p id="caratula-text">Caràtula:</p>
        <input class="movie-data" type="file" name="caratula" required>
        <span class="error">* Required fields</span>
        <button type="submit">Enviar</button>
    </form>
</section>