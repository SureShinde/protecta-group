<?php
$to = "jagdish21.3c@gmail.com";
$subject = "My subject123";
$txt = "Hello world!123";
$headers = "From: jagdishkunwar002@gmail.com";
try {
mail($to,$subject,$txt,$headers);
}
catch(Exception $e) {
  echo 'Message: ' .$e->getMessage();
}
?>