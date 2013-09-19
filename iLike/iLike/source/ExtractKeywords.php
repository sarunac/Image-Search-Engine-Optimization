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

function extractCommonWords($string){
	$stopWords = array('printed','enhance','choose','will','keep','featuring','make','great','like','up','no','matter','enough','yet','pair','irresistible','comfortable','things','flirty','create','creating','stay','look','essential','twice','thrice','just','time','basic','add','some','under','band','bring','perfect','amount','look','your','our','me','with','in','these','life','party','be','sweet','anand','all','i','a','about','an','and','are','as','at','be','by','com','de','en','for','from','how','in','is','it','la','of','on','or','that','the','this','them','Calvin Klein','Levi','to','was','what','when','where','who','will','with','und','the','www');
	 
	$string = preg_replace('/\s\s+/i', '', $string); 
	$string = trim($string); 
	$string = preg_replace('/[^a-zA-Z0-9 -]/', '', $string); 
	$string = strtolower($string); 
	 
	preg_match_all('/\b.*?\b/i', $string, $matchWords);
	$matchWords = $matchWords[0];

	foreach ( $matchWords as $key=>$item ) {
		if ( $item == '' || in_array(strtolower($item), $stopWords) || strlen($item) <= 3 ) {
			unset($matchWords[$key]);
		}
	}
	$wordCountArr = array();
	if ( is_array($matchWords) ) {
		foreach ( $matchWords as $key => $val ) {
			$val = strtolower($val);
			if ( isset($wordCountArr[$val]) ) {
				$wordCountArr[$val]++;
			} else {
				$wordCountArr[$val] = 1;
			}
		}
	}
	arsort($wordCountArr);
	$wordCountArr = array_slice($wordCountArr, 0, 10);
	return $wordCountArr;
}

$descriptionquery = "SELECT ProductID, DESCRIPTION FROM PRODUCTDETAILS";
$description = mysql_query($descriptionquery);

while($descriptionresult = mysql_fetch_array($description)) {
	$productID = $descriptionresult["ProductID"];
	$descriptionvalue = $descriptionresult["DESCRIPTION"];
	
	$words = extractCommonWords($descriptionvalue);
	$tags = "";
	foreach($words as $key => $value) {
		$tags = $tags . " " . $key;		
	}
	
	$takecolorquery = "SELECT Color FROM PRODUCTDETAILS WHERE ProductID = '$productID'";
	$takecolor = mysql_query($takecolorquery);
	if(mysql_num_rows($takecolor) == 1) {
		$colorarray = mysql_fetch_row($takecolor);
		$color = $colorarray[0];
	}
	
	$takecategoryquery = "SELECT Category FROM PRODUCTDETAILS WHERE ProductID = '$productID'";
	$takecategory = mysql_query($takecategoryquery);
	if(mysql_num_rows($takecategory) == 1) {
		$cateogryarray = mysql_fetch_row($takecategory);
		$category = $cateogryarray[0];
	}
	
	if(isset($color)) {
		$tags = $tags . " " . $color;
	}
	if(isset($category)) {
		$tags = $tags . " " . $category;
	}
	
 	$inserttagsquery = "UPDATE PRODUCTDETAILS SET tags = '$tags' WHERE ProductID = '$productID'";
 	$inserttags = mysql_query($inserttagsquery);
}

?>