<<<<<<< HEAD:src/content/content.php
<?php 
    try{
        $connect = ConnectionDB::connect();
=======
<?php namespace MyApp\content;
use MyApp\includes\ConnectionDB as connection;
    try{
        $connect = connection::connect();
>>>>>>> feature/Database_Test:content/content.php
        $sql = $connect->prepare('SELECT * FROM pelicula');
        $sql->execute(array());
        $result = $sql->fetchAll();
    
        $i = 0;
        foreach ($result as $row) {
            $caratula[$i] = $row["caratula"];
            $i++;
        }

    }catch(PDOException $e){
        echo "ERROR: " . $e->getMessage();
    }
?>

<div class="caratula">
    <?php  for($i=0;$i<count($caratula);$i++){  ?>
        <img src="<?php echo $caratula[$i]?>"alt="error">
    <?php  }  ?>
</div>