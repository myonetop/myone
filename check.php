<?php

$fisier = file_get_contents('proxy_list.txt'); // Read the file with the proxy list
$linii = explode("\n", $fisier); // Get each proxy
$fisier = fopen("socks", "a"); // Here we will write the good ones

for($i = 0; $i < count($linii) - 1; $i++) test($linii[$i]); // Test each proxy

function test($proxy)
{
  global $fisier;
  $splited = explode(':',$proxy); // Separate IP and port
  if($con = @fsockopen($splited[0], $splited[1], $eroare, $eroare_str, 3)) 
  {
    fwrite($fisier, $proxy . "\n"); // Check if we can connect to that IP and port
    print $proxy . '<br>'; // Show the proxy
    fclose($con); // Close the socket handle
  }
}

fclose($fisier); // Close the file

?>
