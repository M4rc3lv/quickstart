 <?php 
 //if(isset($_GET["ping"])) {
    echo "asdasdad";
    exit;
    $host = explode(":",$_GET["ping"])[0];
    $port = explode(":",$_GET["ping"])[1]; 
    $waitTimeoutInSeconds = 1; 
    if($fp = fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds)){   
     // It worked 
     echo("OKido".$host.$port);
    } 
    else {
     // It didn't work 
     echo("Err".$host.$port);
    } 
    fclose($fp);
    exit;
   //}
?>
