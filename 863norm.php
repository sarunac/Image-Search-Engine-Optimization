<?php
$count =0;

$con = mysql_connect('localhost', 'root', '');
mysql_select_db('t7', $con);

$minvalquery1 = "SELECT MIN(  `vmean` ) FROM  `properties_new`";
$minvalquery = mysql_query($minvalquery1) or die(mysql_error());
$result_row = mysql_fetch_row($minvalquery);
$minval=$result_row[0];


$maxvalquery1 = "SELECT max(  `vmean` ) FROM  `properties_new`";
$maxvalquery = mysql_query($maxvalquery1) or die(mysql_error());
$result_row1 = mysql_fetch_row($maxvalquery);
$maxval=$result_row1[0];

echo 'minval'.$minval;
?> <br>
<?php
echo 'maxval'.$maxval;

$actualvalquery1 = "SELECT `vmean` FROM  `properties_new`";
$actualvalquery = mysql_query($actualvalquery1) or die(mysql_error());
while($result_row2 = mysql_fetch_row($actualvalquery))
{
$actualval=$result_row2[0];
//echo $actualval;
if($maxval == $minval)
{
	$newval=$actualval;
	$newvalquery1 = "UPDATE `properties_new` set `vmeannorm` ='".$actualval."' where `vmean`='".$actualval."'" ;
	$newvalquery = mysql_query($newvalquery1) or die(mysql_error());
}
else {
	$newval = ($actualval-$minval)/($maxval-$minval);
//echo 'newval'.$newval;
$newvalquery1 = "UPDATE `properties_new` set `vmeannorm` ='".$newval."' where `vmean`='".$actualval."'" ;
$newvalquery = mysql_query($newvalquery1) or die(mysql_error());
}

$count=$count+1;

}
echo 'count'. $count;

 ?>