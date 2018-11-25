<?php
error_reporting(E_ALL);
require("./src/class.phpmailer.php");
require("config.php");

declare(ticks = 1);
error_reporting(1);

$child=0;
$i=0;
$q=0;
$p=0;
$smtp = "smtps";
$email = "emails";
$sockets = "socks";
$version = 5;
//$mmm =
$letter = file_get_contents('letter.html');

function send($socket, $socket_port, $host,$port,$encryption,$username,$password,$from,$fromname,$to,$subject,$html)
    {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug  = 2;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = $encryption;
        $mail->Socks_host = $socket;
        $mail->Socks_port = $socket_port;
        $mail->Host = $host;
        $mail->Port= $port;
        $mail->Username = $username;
        $mail->Password = $password;
        $mail->From = $from;
        $mail->FromName = $fromname;
        $mail->ClearAddresses();
        $mail->AddAddress($to);
        $mail->Subject    = '=?UTF-8?B?'.base64_encode($subject).'?=';
#       $mail->IsHTML(true);
        $mail->Body = 'Hello World';
        $mail->MsgHTML($html);
        $mail->AltBody  =  "$txt";
#       $mail->AddCustomHeader('Reply-to:','sender@example.com');
        $mail->HeaderLine('Return-Path','sender@example.com');

        return $mail->Send();
    }


function Random($x)
    {
        $chars = "abcdefghijkmnopqrstuvwxyz0123456789";
        srand((double)microtime()*1000000);
        $i=0;
        $pass = '' ;
        while ($i <= $x)
            {
                $num = rand() % 36;
                $tmp = substr($chars, $num, 1);
                $pass = $pass . $tmp;
                $i++;
            }
        return $pass;
    }
    function generateRandomString($length = 6) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
/*$content1 = file($sockets);
for ($s = 0; $s < count($content1); $s++)
                                {
                                        $sox[$s] = explode(':', $content1[$s]);
                                        }
                                        */

                                        $fisier = file_get_contents($sockets); // Read the file with the proxy list
$linii = explode("\n", $fisier); // Get each proxy

for($s = 0; $s < count($linii) - 1; $s++)
                {
                        $sox[$s] = explode(":", $linii[$s]);
                        }

$content2=file($smtp);
for ($j=0;$j<count($content2);$j++)
    {
        $smtps[$j] = explode(' ', $content2[$j]);
    }

$content=file($email);
for($i=0;$i<count($content);$i++)
    {
        if($q==(count($content2)))
            {
                $q=0;
            }
        if($p==(count($linii) - 1))
                                {
                                        $p=0;
                                        }
        $emails[$i] = str_replace("\n","", $content[$i]);
        $pids[$child] = pcntl_fork();

        if($pids[$child] == -1)
            {
                die("Could not fork!");
            }
        elseif($pids[$child] == 0)
            {
                  $socks_host_ip = $sox[$p][0];
                  $sox[$p][1] = str_replace("\n","",$sox[$p][1]);
                  $socks_host_port = $sox[$p][1];
                $pmea=$emails[$i];
                $smtps[$q][4]=str_replace("\n","",$smtps[$q][4]);
                $ip=$smtps[$q][0];
                $port=$smtps[$q][1];
                $encryption=$smtps[$q][2];
                $user=$smtps[$q][3];
                $pass=$smtps[$q][4];
                $emsplit = explode("@",$emails);
                $enc_email=base64_encode($emails[$i]);
                $link2=str_replace("@","-",$emails[$i]);
                $link2=str_replace("_","-",$link2);
                $letter=ereg_replace('/[\]/',"",$letter);
                $letter=str_replace('pulamea', $pmea,$letter);
                $letter=ereg_replace("&email&",$emails[$i],$letter);
                $letter=ereg_replace("&emailenc&",$domeniu."/?id=".$enc_email,$letter);
                $letter=ereg_replace("&date&",date("d/m/Y"),$letter);
                $letter=str_replace("^","<span style='font-size:0px'>".Random(55)."</span>",$letter);

                if($test_smtp==1)
                    {
                        $subject=$ip." ".$port." ".$encryption." ".$user." ".$pass." ".$subject;
                    }

                $to=$emails[$i];

 #              if(send($socks_host_ip, $socks_host_port, $ip,$port,$encryption,$user,$pass,$dhost,$sender_name, $emails[$i],$subject."".rand(99999,999999999),$letter))
               if(send($socks_host_ip, $socks_host_port, $ip,$port,$encryption,$user,$pass,$user,$sender_name, $emails[$i],$subject."".rand(99999,999999999),$letter))
                    {
                        $myFile = "SENT";
                        $fh = fopen($myFile, 'a+');
                      #  $data1 = $to." ".$ip.":".$user."\n";
                       $data1 = $to." ".$ip." ".$port." ".$encryption." ".$user." ".$pass."\n";
                        fwrite($fh, $data1);
                        fclose($fh);
                        echo ($i+1)." -> ".$to." -> ".$ip.":".$user." -> \033[1;32mSENT\033[37m\n";
                    }
                else
                    {
                        $myFile = "FAILED";
                        $fh = fopen($myFile, 'a+');
                        $data1 = $to." ".$ip.":".$user." ".$socks_host_port."\n";
                        fwrite($fh, $data1);
                        fclose($fh);
                        echo ($i+1)." -> ".$to." -> ".$ip.":".$user." -> \033[1;31mFAILED\033[37m\n";
                    }
                posix_kill(getmypid(), 9);
            }
        else
            {
                $child++;
                if($child == $max )
                    {
                        pcntl_wait($status);
                        $child--;
                    }
            }
        $q++;
        $p++;
    }
?>

