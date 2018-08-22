<?php


class General {


function resizeImageFiles($size,$load,$target) {
  
    $image = new SimpleImage();
    $image->load($load);
    $image->resizeToWidth($size);
    $image->save($target);
    // var_error_log($target_file);
    // return $target_file; //return name of saved file in case you want to store it in you database or show confirmation message to user   
}
}