<html>
 <head>
  <link rel="stylesheet" href="w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <style>
   .m {width:1200px; margin:0 auto;}
   h1 {display:inline-block; font-size:1.2em;font-weight:bold}
   .logo {height:22px;margin-right:4px;}
   .ok {color:green}
   .nok {color:red}
   .tt {font-size:0.8em; color:grey; font-family: monospace;}
   .starterinfo {font-size:0.8em;color:grey;margin-top:4px;}
   .error {background:#CC2525; color:white;}
  </style>
  <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
  <script src="quikstart.js"></script>
 </head>
 <body>
  <?php
   $path = "/media/marcel/4TB/Proj/Belangrijk/Quickstart/Starters";
   $debug = "OK";

   function Ping($ping) {
    $host = explode(":",$ping)[0];
    $port = explode(":",$ping)[1];
    $waitTimeoutInSeconds = 2;
    try {
     if($fp = fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds)) {
      return "<span class=ok>OK</span>";
     }
     else {
      return "<span class=nok>Gestopt</span>";
     }
     fclose($fp);
    }
    catch (Exception $e)  {
     return("Error 2");
    }
   }

   if(isset($_GET['start'])) {
    $debug =  "<code>".($path."/".$_GET["start"])."</code>";
    $debug = $debug . "<code>".shell_exec("\"".$path."/".$_GET["start"]."\"")."</code>";
   }
   if(isset($_GET['startpoort'])) {
    $Poort = $_GET["poort"];
    $Pad = $_GET["pad"];
    unlink("fouten");
    shell_exec("php -S localhost:$Poort -t $Pad  > /dev/null 2>fouten &");
    sleep(0.8);
    header("Location: quickstart.php");
    die();
   }

  ?>
  <div class="m w3-container">
  <a href="quickstart.php"><img class="logo" src="https://marcelv.net/pix/logo.png" /><h1>Webservers</h1></a>
  <table class='w3-table w3-border w3-bordered'>
  <?php if(file_exists("fouten") && filesize("fouten")>1) { ?>
   <tr><td colspan="3" class='info'><?php $s=file_get_contents("fouten"); echo $s; ?></td></tr>
   <script>$.ajax({url:'delete.php'});</script>
  <?php } ?>

  <tr><th>Status</th><th width="45%">Opstarten</th><th width="45%">Open site</th></tr>
  <?php
   $Starters = parse_ini_file("config.ini");
   for($i=0; $i<count($Starters["Starter"]); $i++) {
    $Poort=$Starters["Poort"][$i];
    $Pad=$Starters["Pad"][$i];
    $Naam=$Starters["Starter"][$i];
    $Info=$Starters["Info"][$i];
    $Url="http://localhost:$Poort";
    echo "<tr><td>".Ping("localhost:$Poort")."</td>";
    echo "<td>&#9656; <a href='quickstart.php?startpoort=1&poort=$Poort&pad=$Pad'>$Naam</a><div class='starterinfo'>$Info</div></td>";
    echo "<td><a target=_blank data-linktype='site' href='http://localhost:$Poort'>$Naam</a> &#8599;<div class='starterinfo'>$Url</div></td>";
    echo "</tr>";
    //echo "<tr><td class='klein'>$Info</td></tr>";
   }
   die();

   // Scan Projectfolder(s) om te kijken wie er een start-shell-script heeft
   $files = scandir($path);
   for($x = 0; $x < count($files); $x++) {
    if ($files[$x] && $files[$x] !== '.' && $files[$x] !== '..') {
     $Starterinfo = $path."/".$files[$x];
     echo "<tr><td>".Ping("localhost:".explode(":",$files[$x])[1])."</td>";
     //echo "<td><a href='quickstart.php?start=$files[$x]'>".explode(":",$files[$x])[0]."</a></td>";
     echo "<td><a href='quickstart.php?start=$files[$x]'>".explode(":",$files[$x])[0]."</a>".
      "<div class='tt'>".str_replace("\n","<br>",htmlspecialchars(rtrim(file_get_contents($Starterinfo))))."</div>".
      "</td>";
     echo "<td><a target=_blank data-linktype='site' href='http://localhost:".explode(":",$files[$x])[1]."'>".explode(":",$files[$x])[0]."</a> &#11181;</td>";
     echo "</tr>";

     // Januari 2022: toon meer info
     //echo "<tr><td>&nbsp;</td><td class=tt>";
     //$Starterinfo = $path."/".$files[$x];
     //echo str_replace("\n","<br>",htmlspecialchars(file_get_contents($Starterinfo)));
     //echo "</td></tr>";
    }
   }

  ?>
  </table>
  </div>
 </body>
</html>
<?php
?>
