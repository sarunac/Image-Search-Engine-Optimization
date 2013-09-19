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

$createwithtag = "CREATE TABLE tablename1
			  `Tcoarseness` double NOT NULL,
  			  `TContrast` double NOT NULL,
  			  `TDirection` double NOT NULL,
  			  `contrast` varchar(300) NOT NULL,
  			  `correlation` varchar(300) NOT NULL,
  			  `energy` varchar(300) NOT NULL,
  			  `homogeneity` varchar(300) NOT NULL,
  			  `imgsum` varchar(300) NOT NULL,
  			  `imgavg` varchar(300) NOT NULL,
  			  `imgstd` varchar(300) NOT NULL,
  			  `imgmin` varchar(300) NOT NULL,
  			  `imgmax` varchar(300) NOT NULL,
  			  `hmean` varchar(300) NOT NULL,
			  `smean` varchar(300) NOT NULL,
  			  `vmean` varchar(300) NOT NULL";

$createwithouttag = "CREATE TABLE tablename2
			  `Tcoarseness` double NOT NULL,
  			  `TContrast` double NOT NULL,
  			  `TDirection` double NOT NULL,
  			  `contrast` varchar(300) NOT NULL,
  			  `correlation` varchar(300) NOT NULL,
  			  `energy` varchar(300) NOT NULL,
  			  `homogeneity` varchar(300) NOT NULL,
  			  `imgsum` varchar(300) NOT NULL,
  			  `imgavg` varchar(300) NOT NULL,
  			  `imgstd` varchar(300) NOT NULL,
  			  `imgmin` varchar(300) NOT NULL,
  			  `imgmax` varchar(300) NOT NULL,
  			  `hmean` varchar(300) NOT NULL,
			  `smean` varchar(300) NOT NULL,
  			  `vmean` varchar(300) NOT NULL";

$tagsearch = "SELECT Tcoarseness, TContrast, TDirection, contrast, correlation, energy,
			  homogeneity, imgsum, imgavg, imgstd, imgmin, imgmax, hmean, smean, vmean
			  FROM properties WHERE Productname IN
			  (SELECT ImageName FROM productdetails WHERE DESCRIPTION LIKE '%$value%')";
$notagsearch = "SELECT Tcoarseness, TContrast, TDirection, contrast, correlation, energy,
			    homogeneity, imgsum, imgavg, imgstd, imgmin, imgmax, hmean, smean, vmean
			    FROM properties WHERE Productname IN
			    (SELECT ImageName FROM productdetails WHERE DESCRIPTION NOT LIKE '%$value%')";

$tagsearch = "SELECT Tcoarseness, TContrast, TDirection, contrast, correlation, energy,
			  homogeneity, imgsum, imgavg, imgstd, imgmin, imgmax, hmean, smean, vmean
			  FROM properties WHERE Productname IN
			  (SELECT ImageName FROM productdetails WHERE TITLE LIKE '%$value%')";
$notagsearch = "SELECT Tcoarseness, TContrast, TDirection, contrast, correlation, energy,
			    homogeneity, imgsum, imgavg, imgstd, imgmin, imgmax, hmean, smean, vmean
			    FROM properties WHERE Productname IN
		        (SELECT ImageName FROM productdetails WHERE TITLE NOT LIKE '%$value%')";

$tagsearch = "SELECT Tcoarseness, TContrast, TDirection, contrast, correlation, energy,
			  homogeneity, imgsum, imgavg, imgstd, imgmin, imgmax, hmean, smean, vmean
			  FROM properties WHERE Productname IN
			  (SELECT ImageName FROM productdetails WHERE AdditionalNotes LIKE '%$value%')";
$notagsearch = "SELECT Tcoarseness, TContrast, TDirection, contrast, correlation, energy,
			  homogeneity, imgsum, imgavg, imgstd, imgmin, imgmax, hmean, smean, vmean
			  FROM properties WHERE Productname IN
			  (SELECT ImageName FROM productdetails WHERE AdditionalNotes NOT LIKE '%$value%')";

$tagsearch = "SELECT Tcoarseness, TContrast, TDirection, contrast, correlation, energy,
			  homogeneity, imgsum, imgavg, imgstd, imgmin, imgmax, hmean, smean, vmean
			  FROM properties WHERE Productname IN
			  (SELECT ImageName FROM productdetails WHERE AdditionalNotes LIKE '%$value%')";
$notagsearch = "SELECT Tcoarseness, TContrast, TDirection, contrast, correlation, energy,
			  homogeneity, imgsum, imgavg, imgstd, imgmin, imgmax, hmean, smean, vmean
			  FROM properties WHERE Productname IN
			  (SELECT ImageName FROM productdetails WHERE AdditionalNotes NOT LIKE '%$value%')";

$findwithtags = mysql_query($tagsearch);
if((mysql_num_rows($findwithtags)) > 0) {
	while($withtagsresult = mysql_fetch_array($findwithtags)) {
		$Tcoarseness = $groupresult["Tcoarseness"];
		$TContrast = $groupresult["TContrast"];
		$TDirection = $groupresult["TDirection"];
		$contrast = $groupresult["contrast"];
		$correlation = $groupresult["correlation"];
		$energy = $groupresult["energy"];
		$homogeneity = $groupresult["homogeneity"];
		$imgsum = $groupresult["imgsum"];
		$imgavg = $groupresult["imgavg"];
		$$imgstd = $groupresult["imgstd"];
		$imgmin = $groupresult["imgmin"];
		$imgmax = $groupresult["imgmax"];
		$hmean = $groupresult["hmean"];
		$smean = $groupresult["smean"];
		$vmean = $groupresult["vmean"];
		$addpropertiesquery = "INSERT INTO tablename1(Tcoarseness, TContrast, TDirection, contrast, correlation, energy,
							   homogeneity, imgsum, imgavg, imgstd, imgmin, imgmax, hmean, smean, vmean)
							   VALUES('$Tcoarseness', '$TContrast', '$TDirection', '$contrast', '$correlation', '$energy', 
							   '$homogeneity', '$imgsum', '$imgavg', '$imgmin', '$imgmax', '$hmean', '$smean', '$vmean')";
		$addgroup = mysql_query($addpropertiesquery) or die("Failed to add properties");
	}
}

$findwithouttags = mysql_query($notagsearch);
if((mysql_num_rows($findwithouttags)) > 0) {
	while($withouttagsresult = mysql_fetch_array($findwithouttags)) {
		$Tcoarseness = $groupresult["Tcoarseness"];
		$TContrast = $groupresult["TContrast"];
		$TDirection = $groupresult["TDirection"];
		$contrast = $groupresult["contrast"];
		$correlation = $groupresult["correlation"];
		$energy = $groupresult["energy"];
		$homogeneity = $groupresult["homogeneity"];
		$imgsum = $groupresult["imgsum"];
		$imgavg = $groupresult["imgavg"];
		$$imgstd = $groupresult["imgstd"];
		$imgmin = $groupresult["imgmin"];
		$imgmax = $groupresult["imgmax"];
		$hmean = $groupresult["hmean"];
		$smean = $groupresult["smean"];
		$vmean = $groupresult["vmean"];
		$addpropertiesquery = "INSERT INTO tablename2(Tcoarseness, TContrast, TDirection, contrast, correlation, energy,
							   homogeneity, imgsum, imgavg, imgstd, imgmin, imgmax, hmean, smean, vmean)
							   VALUES('$Tcoarseness', '$TContrast', '$TDirection', '$contrast', '$correlation', '$energy',
							   '$homogeneity', '$imgsum', '$imgavg', '$imgmin', '$imgmax', '$hmean', '$smean', '$vmean')";
		$addgroup = mysql_query($addpropertiesquery) or die("Failed to add properties");
	}
}



?>