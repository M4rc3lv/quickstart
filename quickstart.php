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
  ?>
  <div class="m w3-container">
  <a href="quickstart.php"><img class="logo" src="https://marcelv.net/pix/logo.png" /><h1>Webservers</h1></a>
  <table class='w3-table w3-border w3-bordered'>
  <tr><td colspan="3"><?php echo $debug; ?></td></tr>
  <tr><th>Status</th><th>Opstarten</th><th>Open site</th></tr>
  <?php
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
