<?php namespace MyApp\includes;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = action::checkRequired();
        $title_error = $errors['title'];
        $sinopsis_error = $errors['sinopsis'];
        $img_error = $errors['img'];
    }

    // Check for errors
   function checkRequired() 
   {
        // Check Required files
        $title = $_POST['title'];
        $title_ok = ! empty_title($title);
        
        $sinopsis = $_POST['sinopsis'];
        $sinopsis_ok = ! empty_sinopsis($sinopsis);
    
        $img = $_POST['caratula'];
        $img_ok = ! empty_image($img);
   
        if ($title_ok && $sinopsis_ok && $img_ok) {
           $title_error = $sinopsis_error = $img_error = '';
           $image = new image();
           $img_error = $image->check_image($_FILES);
        } else {
            $title_error = 'Title is required';
            $sinopsis_error = 'Sinopsis is required';
            $img_error = 'Image is required';
        }

        return [
            'title' => $title_error,
            'sinopsis' => $sinopsis_error,
            'img' => $img_error
        ];
   }

   function empty_title($title)
   {
       global $title_error;

       if (empty($title)) {
           return true;
       }

       return false;
   }

   function empty_sinopsis($sinopsis)
   {
       global $sinopsis_error;

       if (empty($sinopsis)) {
           return true;
       }

       return false;
   }

   function empty_image($img)
   {
       global $img_error;

       if (empty($img)) {
           return true;
       }

       return false;
   }
?>