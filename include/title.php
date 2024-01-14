<?php 
function title($a,$href1){
   echo "<h1 class=\"title\">$a</h1>";
    echo"<ul class=\"breadcrumbs\">";
       echo" <li><a href=\"../dashboard/dashboard\">Home</a></li>";
        echo"<li class=\"divider\">/</li>";
        echo"<li><a href=\"$href1\" class=\"active\">$a</a></li>";
    echo"</ul>";
}
function title1($a,$href1,$b,$href2){
    echo "<h1 class=\"title\">$a</h1>";
     echo"<ul class=\"breadcrumbs\">";
        echo" <li><a href=\"dashboard.php\">Home</a></li>";
         echo"<li class=\"divider\">/</li>";
         echo"<li><a href=\"$href1\" class=\"active\">$a</a></li>";
             echo"<li class=\"divider\">/</li>";
             echo"<li><a href=\"$href2\" class=\"active\">$b</a></li>";
     echo"</ul>";
 }
?>