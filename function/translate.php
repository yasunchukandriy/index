<?php
   if(!empty($_POST['form_language'])) $_SESSION['language']=$_POST['form_language'];
   elseif(empty($_SESSION['language'])) $_SESSION['language']='English';

    function translate($object,$language)
    {
        $database_handle=new PDO("mysql:host=localhost;dbname=user",'root','');
        $q = $database_handle->prepare("SELECT * FROM translate WHERE English='$object'");
        $q->execute();

        $data = $q->fetch(PDO::FETCH_ASSOC);
        if(strcasecmp($language,"English")==0) return $data["English"];
        else
        return $data["Ukrainian"];
    }
?>
