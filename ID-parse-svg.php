<?php
error_reporting(0);
//invalid xml file
$xmlfile = 'pat.svg';
$xmlparser = xml_parser_create();

// open a file and read data
$fp = fopen($xmlfile, 'r');
$xmldata = fread($fp, filesize($xmlfile));

xml_parse_into_struct($xmlparser,$xmldata,$values);

xml_parser_free($xmlparser);
#echo "<pre>";print_r($values);
for($i=0;$i<count($values);$i++){
	if($values[$i]['tag'] == "PATH" ){
	//echo "<pre>";print_r($values[$i]);
	echo '<'.strtolower($values[$i]['tag']).' d="'.$values[$i]['attributes']["D"].'" transform="'.$values[$i]['attributes']['TRANSFORM'].'" />';
	}
}
?>