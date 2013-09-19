<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>iLike</title>
<link rel="stylesheet" type="text/css" href="/css/searchStyle.css" />
</head>

<body>

<form name="searchform" action="index.php" method="post">
<br/>
<table align="center">
	<tr>
		<td> <input type="text" size="60" class="inputtext" maxlength="300" name="searchinput" id="searchinput"/>
		<input type="submit" name="searchbutton" value="Search" style="background:none;border:0;color:#4C4646;font-size: 18px;"/> </td>		
	</tr>	
	<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>


<?php 
$dbconnection = "Connection.php";

if(file_exists($dbconnection)) {
	include $dbconnection;
} else if(file_exists("../".$dbconnection)) {
	include "../".$dbconnection;
} else {
	include "../../".$dbconnection;
}

dbConnect();

if(isset($_POST['searchbutton'])) {
	$searchinput = $_POST['searchinput'];
	
	if($searchinput != NULL) {
		$valuesinsearch = explode(' ',$searchinput);
		
		foreach ($valuesinsearch as $value) {
			$pvaluesearchquery = "SELECT * FROM
								  pvalue WHERE
								  keyword = '$value'";
		
			$pvaluesearch = mysql_query($pvaluesearchquery) or die('Failed to search pvalue');
				
			if(mysql_num_rows($pvaluesearch) > 0) {
				$Tcoarsenesswq = 0.0;
				$TContrastwq = 0.0;
				$TDirectionwq = 0.0;
				$contrastwq = 0.0;
				$correlationwq = 0.0;
				$energywq = 0.0;
				$homogeneitywq = 0.0;
				$imgsumwq = 0.0;
				$imgavgwq = 0.0;
				$imgstdwq = 0.0;
				$hmeanwq = 0.0;
				$smeanwq = 0.0;
				$vmeanwq = 0.0; 
				
				while($pvaluesearchresults = mysql_fetch_array($pvaluesearch)) {
					$Tcoarsenessp = $pvaluesearchresults["Tcoarsenessp"];
					$TContrastp = $pvaluesearchresults["TContrastp"];
					$TDirectionp = $pvaluesearchresults["TDirectionp"];
					$contrastp = $pvaluesearchresults["contrastp"];
					$correlationp = $pvaluesearchresults["correlationp"];
					$energyp = $pvaluesearchresults["energyp"];
					$homogeneityp = $pvaluesearchresults["homogeneityp"];
					$imgsump = $pvaluesearchresults["imgsump"];
					$imgavgp = $pvaluesearchresults["imgavgp"];
					$imgstdp = $pvaluesearchresults["imgstdp"];
					$hmeanp = $pvaluesearchresults["hmeanp"];
					$smeanp = $pvaluesearchresults["smeanp"];
					$vmeanp = $pvaluesearchresults["vmeanp"];
					
					$Tcoarsenesswq = $Tcoarsenesswq + $Tcoarsenessp;
					$TContrastwq = $TContrastwq + $TContrastp;
					$TDirectionwq = $TDirectionwq + $TDirectionp;
					$contrastwq = $contrastwq + $contrastp;
					$correlationwq = $correlationwq + $correlationp;
					$energywq = $energywq + $energyp;
					$homogeneitywq = $homogeneitywq + $homogeneityp;
					$imgsumwq = $imgsumwq + $imgsump;
					$imgavgwq = $imgavgwq + $imgavgp;
					$imgstdwq = $imgstdwq + $imgstdp;
					$hmeanwq = $hmeanwq + $hmeanp;
					$smeanwq = $smeanwq + $smeanp;
					$vmeanwq = $vmeanwq + $vmeanp; 
				}
			}	
		}
			
		foreach ($valuesinsearch as $value) {
			$normalizedvaluesearchquery = "SELECT * FROM
									  	   properties_new WHERE Productname IN
									       (SELECT ImageName FROM productdetails WHERE
									       TAGS LIKE '%$value%') LIMIT 30";
			$normalizedvaluesearch = mysql_query($normalizedvaluesearchquery) or die('Failed to search normalized value');
			
			if(mysql_num_rows($normalizedvaluesearch) > 0) {
				$productnames = array();
				$tcoarsenessnorm = array();
				$tContrastnorm = array();
				$tDirectionnorm = array();
				$contrastnorm = array();
				$correlationnorm = array();
				$energynorm = array();
				$homogeneitynorm = array();
				$imgsumnnorm = array();
				$imgavgnorm = array();
				$imgstdnorm = array();
				$hmeannorm = array();
				$smeannorm = array();
				$vmeannorm = array();
				
				while($normalizedvaluesearchresults = mysql_fetch_array($normalizedvaluesearch)) {
					$productnames[] = $normalizedvaluesearchresults["Productname"];
					$tcoarsenessnorm[] = $normalizedvaluesearchresults["Tcoarsenessnorm"];
					$tContrastnorm[] = $normalizedvaluesearchresults["TContrastnorm"];
					$tDirectionnorm[] = $normalizedvaluesearchresults["TDirectionnorm"];
					$contrastnorm[] = $normalizedvaluesearchresults["contrastnorm"];
					$correlationnorm[] = $normalizedvaluesearchresults["correlationnorm"];
					$energynorm[] = $normalizedvaluesearchresults["energynorm"];
					$homogeneitynorm[] = $normalizedvaluesearchresults["homogeneitynorm"];
					$imgsumnnorm[] = $normalizedvaluesearchresults["imgsumnorm"];
					$imgavgnorm[] = $normalizedvaluesearchresults["imgavgnorm"];
					$imgstdnorm[] = $normalizedvaluesearchresults["imgstdnorm"];
					$hmeannorm[] = $normalizedvaluesearchresults["hmeannorm"];
					$smeannorm[] = $normalizedvaluesearchresults["smeannorm"];
					$vmeannorm[] = $normalizedvaluesearchresults["vmeannorm"];
				}
			}
		}
		
		$Tcoarsenesswe = 0.0;
		$TContrastwe = 0.0;
		$TDirectionwe = 0.0;
		$contrastwe = 0.0;
		$correlationwe = 0.0;
		$energywe = 0.0;
		$homogeneitywe = 0.0;
		$imgsumwe = 0.0;
		$imgavgwe = 0.0;
		$imgstdwe = 0.0;
		$hmeanwe = 0.0;
		$smeanwe = 0.0;
		$vmeanwe = 0.0;
		
		if(isset($productnames[0])) {
			
		foreach($productnames as $productname) {
			$searchothertagsquery = "SELECT TAGS FROM productdetails
									 WHERE ImageName = '$productname'";
			$searchothertags = mysql_query($searchothertagsquery);
			
			if(mysql_num_rows($searchothertags) > 0) {
				while($tagsresult = mysql_fetch_array($searchothertags)) {
					$tag = $tagsresult["TAGS"];
					$eachtag = explode(' ',$tag);
					
					foreach ($eachtag as $key) {
						$otherpvaluesearchquery = "SELECT * FROM
											  	   pvalue WHERE
											       keyword = '$key'";
						$otherpvaluesearch = mysql_query($otherpvaluesearchquery) or die('Failed to search other pvalue');
						
						if(mysql_num_rows($otherpvaluesearch) > 0) {
							while($pvaluesearchresults = mysql_fetch_array($pvaluesearch)) {
								$Tcoarsenessp = $pvaluesearchresults["Tcoarsenessp"];
								$TContrastp = $pvaluesearchresults["TContrastp"];
								$TDirectionp = $pvaluesearchresults["TDirectionp"];
								$contrastp = $pvaluesearchresults["contrastp"];
								$correlationp = $pvaluesearchresults["correlationp"];
								$energyp = $pvaluesearchresults["energyp"];
								$homogeneityp = $pvaluesearchresults["homogeneityp"];
								$imgsump = $pvaluesearchresults["imgsump"];
								$imgavgp = $pvaluesearchresults["imgavgp"];
								$imgstdp = $pvaluesearchresults["imgstdp"];
								$hmeanp = $pvaluesearchresults["hmeanp"];
								$smeanp = $pvaluesearchresults["smeanp"];
								$vmeanp = $pvaluesearchresults["vmeanp"];
		
								$Tcoarsenesswe = $Tcoarsenesswe + $Tcoarsenessp;
								$TContrastwe = $TContrastwe + $TContrastp;
								$TDirectionwe = $TDirectionwe + $TDirectionp;
								$contrastwe = $contrastwe + $contrastp;
								$correlationwe = $correlationwe + $correlationp;
								$energywe = $energywe + $energyp;
								$homogeneitywe = $homogeneitywe + $homogeneityp;
								$imgsumwe = $imgsumwe + $imgsump;
								$imgavgwe = $imgavgwe + $imgavgp;
								$imgstdwe = $imgstdwe + $imgstdp;
								$hmeanwe = $hmeanwe + $hmeanp;
								$smeanwe = $smeanwe + $smeanp;
								$vmeanwe = $vmeanwe + $vmeanp;
							}
						}
					}
				}	
			}
		}
		}
		
		$alpha = 0.9;
		$beta = 0.1;
		
		$finalTcoarseness = array();
		$finalTContrast = array();
		$finalTDirection = array();
		$finalcontrast = array();
		$finalcorrelation = array();
		$finalenergy = array();
		$finalhomogeneity = array();
		$finalimgsum = array();
		$finalimgavg = array();
		$finalimgstd = array();
		$finalhmean = array();
		$finalsmean = array();
		$finalvmean = array();
		
		if(isset($Tcoarsenesswq) && isset($productnames[0])) {
			
		for($i=0;$i<count($productnames);$i++) {
			$alphaproductTcoarseness = $alpha * $Tcoarsenesswq;
			$betaproductTcoarseness = $beta * $Tcoarsenesswe;
			$sumTcoarseness = $alphaproductTcoarseness + $betaproductTcoarseness;
			$finalTcoarseness[] = $tcoarsenessnorm[$i] * ($sumTcoarseness);
			
			$alphaproductTContrast = $alpha * $Tcoarsenesswq;
			$betaproductTContrast = $beta * $Tcoarsenesswe;
			$sumTContrast = $alphaproductTContrast + $betaproductTContrast;
			$finalTContrast[] = $tContrastnorm[$i] * ($sumTContrast);
			
			$alphaproductTDirection = $alpha * $Tcoarsenesswq;
			$betaproductTDirection = $beta * $Tcoarsenesswe;
			$sumTDirection = $alphaproductTDirection + $betaproductTDirection;
			$finalTDirection[] = $tDirectionnorm[$i] * ($sumTDirection);
			
			$alphaproductcontrast = $alpha * $Tcoarsenesswq;
			$betaproductcontrast = $beta * $Tcoarsenesswe;
			$sumcontrast = $alphaproductcontrast + $betaproductcontrast;
			$finalcontrast[] = $contrastnorm[$i] * ($sumcontrast);
			
			$alphaproductcorrelation = $alpha * $Tcoarsenesswq;
			$betaproductcorrelation = $beta * $Tcoarsenesswe;
			$sumcorrelation = $alphaproductcorrelation + $betaproductcorrelation;
			$finalcorrelation[] = $correlationnorm[$i] * ($sumcorrelation);
			
			$alphaproductenergy = $alpha * $Tcoarsenesswq;
			$betaproductenergy = $beta * $Tcoarsenesswe;
			$sumenergy = $alphaproductenergy + $betaproductenergy;
			$finalenergy[] = $energynorm[$i] * ($sumenergy);
			
			$alphaproducthomogeneity = $alpha * $Tcoarsenesswq;
			$betaproducthomogeneity = $beta * $Tcoarsenesswe;
			$sumhomogeneity = $alphaproducthomogeneity + $betaproducthomogeneity;
			$finalhomogeneity[] = $homogeneitynorm[$i] * ($sumhomogeneity);
			
			$alphaproductimgsum = $alpha * $Tcoarsenesswq;
			$betaproductimgsum = $beta * $Tcoarsenesswe;
			$sumimgsum = $alphaproductimgsum + $betaproductimgsum;
			$finalimgsum[] = $imgsumnnorm[$i] * ($sumimgsum);
			
			$alphaproductimgavg = $alpha * $Tcoarsenesswq;
			$betaproductimgavg = $beta * $Tcoarsenesswe;
			$sumimgavg = $alphaproductimgavg + $betaproductimgavg;
			$finalimgavg[] = $imgavgnorm[$i] * ($sumimgavg);
			
			$alphaproductimgstd = $alpha * $Tcoarsenesswq;
			$betaproductimgstd = $beta * $Tcoarsenesswe;
			$sumimgstd = $alphaproductimgstd + $betaproductimgstd;
			$finalimgstd[] = $imgstdnorm[$i] * ($sumimgstd);
			
			$alphaproducthmean = $alpha * $Tcoarsenesswq;
			$betaproducthmean = $beta * $Tcoarsenesswe;
			$sumhmean = $alphaproducthmean + $betaproducthmean;
			$finalhmean[] = $hmeannorm[$i] * ($sumhmean);
			
			$alphaproductsmean = $alpha * $Tcoarsenesswq;
			$betaproductsmean = $beta * $Tcoarsenesswe;
			$sumsmean = $alphaproductsmean + $betaproductsmean;
			$finalsmean[] = $smeannorm[$i] * ($sumsmean);
			
			$alphaproductvmean = $alpha * $Tcoarsenesswq;
			$betaproductvmean = $beta * $Tcoarsenesswe;
			$sumvmean = $alphaproductvmean + $betaproductvmean;
			$finalvmean[] = $vmeannorm[$i] * ($sumvmean);
		}
		
		}
		
		
		
 		if(isset($finalTcoarseness[0]) && isset($tcoarsenessnorm[0]) && isset($productnames[0])) {
			
		$euclideanvalue = array();
		for($i=0;$i<count($productnames);$i++) {
			$differenceTcoarseness = pow($finalTcoarseness[$i] - $tcoarsenessnorm[$i], 2);
			$differenceTContrast = pow($finalTContrast[$i] - $tContrastnorm[$i], 2);
			$differenceTDirection = pow($finalTDirection[$i] - $tDirectionnorm[$i], 2);
			$differencecontrast = pow($finalcontrast[$i] - $contrastnorm[$i], 2);
			$differencecorrelation = pow($finalcorrelation[$i] - $correlationnorm[$i], 2);
			$differenceenergy = pow($finalenergy[$i] - $energynorm[$i], 2);
			$differencehomogeneity = pow($finalhomogeneity[$i] - $homogeneitynorm[$i], 2);
			$differenceimgsum = pow($finalimgsum[$i] - $imgsumnnorm[$i], 2);
			$differenceimgavg = pow($finalimgavg[$i] - $imgavgnorm[$i], 2);
			$differenceimgstd = pow($finalimgstd[$i] - $imgstdnorm[$i], 2);
			$differencehmean = pow($finalhmean[$i] - $hmeannorm[$i], 2);
			$differencesmean = pow($finalsmean[$i] - $smeannorm[$i], 2);
			$differencevmean = pow($finalvmean[$i] - $vmeannorm[$i], 2);		

			$euclideanvalue[$i] = sqrt($differenceTcoarseness + $differenceTContrast + $differenceTDirection + $differencecontrast + 
							  	   $differencecorrelation + $differenceenergy + $differencehomogeneity + $differenceimgsum + 
							       $differenceimgavg + $differenceimgstd + $differencehmean + $differencesmean + $differencevmean);
		}
		
		}
		
		if(isset($euclideanvalue[0]) && isset($productnames[0])) {

		$result = array_combine($productnames, $euclideanvalue);
		arsort($result);
		$orderedlist = array();
		foreach($result as $x=>$x_value) {
			$orderedlist[] = $x;
		}
		
		foreach($orderedlist as $product) {
			$productquery = "SELECT * FROM productdetails
							 WHERE Imagename = '$product' LIMIT 1";
			$product = mysql_query($productquery);
			
			if(mysql_num_rows($product) > 0) {
				while($productresults = mysql_fetch_array($product)) {
					$title = $productresults["Title"];
					$imagelocation = $productresults["ImageURL"];
			
					echo "<tr><td><a href='$imagelocation'><img src='$imagelocation' height=90 width=170/></a>";
					echo "<a href='$imagelocation' class='stylish-link'><font size='4'>$title</font></a></td></tr>";
				}
			}
		}
		
		} else {
			echo '<script type="text/javascript">';
			echo 'alert("Sorry we dont have this product")';
			echo '</script>';
		}
 		
	}
}
?>
	

</table>
</form>
</body>
</html>