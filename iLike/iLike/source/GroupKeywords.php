<?php

$dbconnection = "connection.php";

if(file_exists($dbconnection)) {
	include $dbconnection;
} else if(file_exists("../".$dbconnection)) {
	include "../".$dbconnection;
} else {
	include "../../".$dbconnection;
}

dbConnect();

$tagsquery = "SELECT TAGS FROM PRODUCTDETAILS";
$tags = mysql_query($tagsquery);

$tcoarse = "";
$tContra = "";
$tDirect = "";
$contra = "";
$correl = "";
$ener = "";
$homogen = "";
$imgsum = "";
$imgav = "";
$imgst = "";
$hm = "";
$sm = "";
$vm = "";

$tcoarsenk  = "";
$tContrank = "";
$tDirectnk = "";
$contrank = "";
$correlnk = "";
$enernk = "";
$homogenk = "";
$imgsumnk = "";
$imgavnk = "";
$imgstnk = "";
$hmnk = "";
$smnk = "";
$vmnk = "";

while($tagsresult = mysql_fetch_array($tags)) {
	$tag = $tagsresult["TAGS"];
	$eachtag = explode(' ',$tag);	
	
	foreach ($eachtag as $key) {
		$withkeywordquery = "SELECT Tcoarsenessnorm, TContrastnorm, TDirectionnorm, contrastnorm, correlationnorm, energynorm,
							 homogeneitynorm, imgsumnorm, imgavgnorm, imgstdnorm, imgminnorm, imgmaxnorm, hmeannorm, smeannorm, vmeannorm
							 FROM properties_new WHERE Productname IN
							 (SELECT ImageName FROM PRODUCTDETAILS WHERE
							 TAGS LIKE '%$key%')";
		$withkeyword = mysql_query($withkeywordquery);
		
		if(mysql_num_rows($withkeyword) > 0) {
			$keyfile = $key . '.txt';
			$handlekey = fopen($keyfile, 'w') or die('Cannot open file:  '.$keyfile);
			
			while($withkeywordresult = mysql_fetch_array($withkeyword)) {
				$tcoarseness = $withkeywordresult["Tcoarsenessnorm"];
				$tContrast = $withkeywordresult["TContrastnorm"];
				$tDirection = $withkeywordresult["TDirectionnorm"];
				$contrast = $withkeywordresult["contrastnorm"];
				$correlation = $withkeywordresult["correlationnorm"];
				$energy = $withkeywordresult["energynorm"];
				$homogeneity = $withkeywordresult["homogeneitynorm"];
				$imgsumn = $withkeywordresult["imgsumnorm"];
				$imgavg = $withkeywordresult["imgavgnorm"];
				$imgstd = $withkeywordresult["imgstdnorm"];
				$hmean = $withkeywordresult["hmeannorm"];
				$smean = $withkeywordresult["smeannorm"];
				$vmean = $withkeywordresult["vmeannorm"];	

				$eachrow = $tcoarseness . " " . $tContrast . " " . $tDirection . " " . $contrast . " " .$correlation . " " . $energy . " " . $homogeneity . " " . $imgsumn . " " . $imgavg . " " . $imgstd . " " . $hmean . " " . $smean . " " . $vmean;
				
				fwrite($handlekey, $eachrow . "\n");				
			}
			
			fclose($handlekey);
		}
		
		
		
		$withoutkeywordquery = "SELECT Tcoarsenessnorm, TContrastnorm, TDirectionnorm, contrastnorm, correlationnorm, energynorm,
								homogeneitynorm, imgsumnorm, imgavgnorm, imgstdnorm, imgminnorm, imgmaxnorm, hmeannorm, smeannorm, vmeannorm
						        FROM properties_new WHERE Productname IN
							    (SELECT ImageName FROM PRODUCTDETAILS WHERE
							    TAGS NOT LIKE '%$key%')";
		$withoutkeyword = mysql_query($withoutkeywordquery);
		
		if(mysql_num_rows($withoutkeyword) > 0) {
			$nokeyfile = $key . 'noword.txt';
			$handlenokey = fopen($nokeyfile, 'w') or die('Cannot open file:  '.$nokeyfile);

			while($withoutkeywordresult = mysql_fetch_array($withoutkeyword)) {
				$tcoarsenessnk = $withkeywordresult["Tcoarsenessnorm"];
				$tContrastnk = $withkeywordresult["TContrastnorm"];
				$tDirectionnk = $withkeywordresult["TDirectionnorm"];
				$contrastnk = $withkeywordresult["contrastnorm"];
				$correlationnk = $withkeywordresult["correlationnorm"];
				$energynk = $withkeywordresult["energynorm"];
				$homogeneitynk = $withkeywordresult["homogeneitynorm"];
				$imgsumnnk = $withkeywordresult["imgsumnorm"];
				$imgavgnk = $withkeywordresult["imgavgnorm"];
				$imgstdnk = $withkeywordresult["imgstdnorm"];
				$hmeannk = $withkeywordresult["hmeannorm"];
				$smeannk = $withkeywordresult["smeannorm"];
				$vmeannk = $withkeywordresult["vmeannorm"];
				
				$eachrow = $tcoarsenessnk . " " . $tContrastnk . " " . $tDirectionnk . " " . $contrastnk . " " .$correlationnk . " " . $energynk . " " . $homogeneitynk . " " . $imgsumnnk . " " . $imgavgnk . " " . $imgstdnk . " " . $hmeannk . " " . $smeannk . " " . $vmeannk;
				fwrite($handlenokey, $eachrow . "\n");
			}
			
			fclose($handlenokey);
		}
		
	}
}