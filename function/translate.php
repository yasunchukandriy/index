<?php
if (isset($_GET["lang"])) {
    $_SESSION['language'] = $_GET["lang"];
}
elseif (!isset($_SESSION['language'])) {
$_SESSION['language'] = "English";
}
unset($_GET["lang"]);
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
