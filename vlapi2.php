<?php
error_reporting(0);
$format = 'json';
$mflcode = intval($_GET['mfl']);
 //Set our variables
//Connect to the Database

$con = mysql_connect("mysql", "root", "FnP5FjbnMrzXCm.") or die ('MySQL Error.');
mysql_select_db('vl_kemri2', $con) or die('MySQL Error.');

if ($mflcode !='') {
$sql2=mysql_query("select ID from facilitys where facilitycode='$mflcode'");
$ss2=mysql_fetch_array($sql2);
$facilityid=$ss2['ID'];
}
//echo 'uu'.$mflcode. '- : '. $facilityid;

$vresult = mysql_query("SELECT v.ID,v.patient as Patient,f.facilitycode as MFLCode,v.datetested as DateTested,v.result as Result, j.name AS Justification FROM viralsamples v , facilitys f , viraljustifications j  WHERE  f.ID=v.facility and v.facility='$facilityid' and v.justification=j.ID and  v.repeatt=0 AND  v.flag=1  order by v.datetested desc ") or die(mysql_error());
 $mnumrows=mysql_num_rows($vresult);


//Preapre our output
if($format == 'json') 
{

$json = array();

		while ($maRow = mysql_fetch_assoc($vresult))
		{
$maArray[] = $maRow['ID']  ;
$maArray1[] = $maRow['Patient']  ;
$maArray2[] = $maRow['MFLCode']  ;
$maArray3[] = $maRow['DateTested']  ;
$maArray4[] = $maRow['Result']  ;
$maArray5[] = $maRow['Justification']  ;
 
	   }
for ($mrow = 0; $mrow < $mnumrows; $mrow++)
		{
		$labid=$maArray[$mrow];	
                $cname=$maArray1[$mrow];			
		$fcode=$maArray2[$mrow];
		$datetested=$maArray3[$mrow];
		$results=$maArray4[$mrow];
		$justification=$maArray5[$mrow];

	 $bus = array('ID' => $labid ,'Patient' => $cname,'MFLCode' => $fcode,'DateTested' => $datetested,'Result' => $results,	'Justification' => $justification ,   );
    array_push($json, $bus);
		}
		

$jsonstring = json_encode(array_map('utf8_encode', $json));

$output = json_encode(array('posts' => $json ), JSON_UNESCAPED_SLASHES);


 
} 
elseif($format == 'xml') {
/*
 
header('Content-type: text/xml');
$outputÂ  = "<?xml version=\"1.0\"?>\n";
$output .= "<viralsamples >\n";
 
for($i = 0 ; $i < mysql_num_rows($vresult) ; $i++){
$row = mysql_fetch_assoc($vresult);

if  ($row['result'] == '< LDL copies/ml')
{
$outcome="Below LDL copies/ml";
}
elseif ($row['result'] == '<550') 
{
$outcome="Below 550 copies/ml";
}
elseif ($row['result'] == '< 400 ') 
{
$outcome="Below 400 copies/ml";
}
elseif ($row['result'] == '<150') 
{
$outcome="Below 150 copies/ml";
}
elseif ($row['result'] == '< 20 ') 
{
$outcome="Below 20 copies/ml";
}
elseif ($row['result'] == '< 2.00E+1 (1.30) ') 
{
$outcome="Below 20 copies/ml";
}
else
{
$outcome=$row['result'];
}

$output .= "<viralsample> \n";
$output .= "<viralsample_ID>" . $row['ID'] . "</viralsample_ID> \n";
$output .= "<viralsample_ccc_no>" . $row['patient'] . "</viralsample_ccc_no> \n";
$output .= "<viralsample_MFL_Code>" . $row['facilitycode'] . "</viralsample_MFL_Code> \n";
$output .= "<viralsample_datetested>" . $row['datetested'] . "</viralsample_datetested> \n";
$output .= "<viralsample_result>" . $outcome . "</viralsample_result> \n";
$output .= "<viralsample_justification>" . $row['justification'] . "</viralsample_justification> \n";

$output .= "</viralsample> \n";
}
 
$output .= "</viralsamples >";
 */
} else {
die('Improper response format.');
}
 
//Output the output.
echo $output;

 
?>
