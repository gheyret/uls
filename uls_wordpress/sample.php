<?php
require_once "uls.php";
$cont = file_get_contents('http://www.akademiye.org/ug/index.php');

$time_start = microtime(true);
$ul=U2L($cont);
file_put_contents('index_ul.html',$ul);
$time_end = microtime(true);
$time = $time_end - $time_start;
print "Uyghur To Latin= $time \n";

$time_start = microtime(true);
$us=U2S($cont);
file_put_contents('index_us.html',$us);
$time_end = microtime(true);
$time = $time_end - $time_start;
print "Uyghur To Silawiyan= $time \n";

$time_start = microtime(true);
$uot=U2T($cont);
file_put_contents('index_ut.html',$uot);
$time_end = microtime(true);
$time = $time_end - $time_start;
print "Uyghur To Turk= $time \n";

?>

