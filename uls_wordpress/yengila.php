<?php
$contents = file_get_contents('index_uls.php');
file_put_contents('index.php',$contents);
$curlink="http://$_SERVER[HTTP_HOST]".dirname($_SERVER['PHP_SELF'])."/index.php";
#echo $curlink;
header("Location: $curlink");
?>
