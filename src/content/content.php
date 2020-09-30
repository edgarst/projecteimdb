<?php namespace MyApp\content;
use MyApp\includes\ConnectionDB as connection;
use MyApp\includes\ImageDB as filmImage;
use MyApp\includes\FilmDB as filmInfo;

    $filmInfo = new filmInfo();
    $films = $filmInfo->getFilms();
?>

<aside class="filter">
    <h1>HOLAAAA SÓC EL FILTRE</h1>
</aside>

<div class="row">
    <?php  for($i=0;$i<count($films);$i++){  ?>
        <div class="col">
            <img src="<?php echo $films[$i]["caratula"]?>"alt="error">
            <div class="text-img">
                <h4><?php echo $films[$i]["titol"] ?></h4>
            </div>
        </div>
    <?php  }  ?>
</div>