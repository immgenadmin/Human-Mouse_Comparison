<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css"> 


<!--
body {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 13px;
	background-color: #CCC;
	alignment-adjust: middle;
	background-image: url(images/backGdTile.png);
}
table.general th, td{
	padding: 5px;
	padding-left: 10px;
	padding-right: 10px;
	text-align:left;
}

table.general td.oddTD {
	background-color:#eee;
}

table.form-table td {
	border:none;
}

#div-1 {
position:relative;
top:50px;
left:140px;
}
#div-1a {
position:absolute;
top:0;
left:0;
width:250px;
}
table.form-table1 {
	width: 200px;
	height: 80px;
	background-color: #93BA61;
	border-radius: 8px;
	box-shadow: 2px 2px 5px #666;
}

#div-1b {
position:absolute;
top:0;
left:250px;
width:100px;
}
#div-1c {
position:absolute;
top:0;
left:500px;;
width:200px;
}

table.form-table2 {
  /*	position: absolute;
	left: 500px;
	top: 180px;*/
	width: 200px;
	height: 80px;
	background-color: #A59FA0;
	border-radius: 8px;
	box-shadow: 2px 2px 5px #666;
  /*z-index: 0; */
	padding: 0;
}


#div-1d {
position:absolute;
top:20px;;
left:750px;
}

#div-2 {
position:relative;
top:250px;
}

#div-3 {
position:relative;
top:220px;
}
#div-4 {
position:relative;
<!--top:180px; -->
}
#div-4a {
position:absolute;
left:10px;
}
#div-4b {
position:absolute;
left:120px;
}
#div-5 {
position:relative;
top:100px;
}
#div-6 {
font-family: "Berlin Sans FB";
font-size: 20px;
position:relative;
top:250px;
height:1500px;
}

#div-0 {
font-family: "Berlin Sans FB";
font-size: 13.5pt;
width: 501 px;
}
-->


</style> 


<title>Human and Mouse Comparison</title>
</head>

<body>

<!-- <H1><img src="images/Header.png" width="1001" height="80" /></H1> -->
<H1><img src="images/HeaderWithText.png" width="1001" height="141" />      
<a href="http://rstats.immgen.org/comparative/HumanMouseComparison.html" target="_blank">
      <img title="Help" border="0" src="images/QuestionMark.png" width="24" height="24">
      </a></H1>

<!--
<div id="div-0">
Typing a gene name will present its expression in human and mouse (if it is has one-to-one ortholog and is expressed in both species).
It will also show the module this gene is assigned to in the species you have searched, and the corresponding genes in the other species.
</div>
-->

<?php

error_reporting (E_ALL ^ E_NOTICE); 

include "./genes.php"; //<---- the name of php file holding gene name array


drawForm();

if (isset($_POST['sTermHuman'])) {
	if ($_POST['sTermHuman'] != "") {
	search($_POST['sTermHuman'],$genes, 'human');
	} 
}

if (isset($_POST['sTermMouse'])) {
	if ($_POST['sTermMouse'] != "") {
	search($_POST['sTermMouse'],$genes, 'mouse');
	} 
}

function drawForm() {
  echo '<div id="div-1">';
	echo '<div id="div-1a"> <form method="post" action="" >';
				echo '<table class="form-table1"><tr><td>';
				echo 'Human Gene: <input type="text" name="sTermHuman">';
				echo '</td></tr>';
				echo '</td></tr><tr><td class="btn-td">';
				echo '<input name="submit_term_human" value="Search" type="submit">';
				echo '</td></tr></table></form> </div>';
				echo '<div id="div-1b"> <img src="images/human.png" name="Human" width="47" height="150" id="Human" /> </div>'; 


				echo '<div id="div-1c"> <form method="post" action="" >';
				echo '<table class="form-table2"><tr><td>';
				echo 'Mouse Gene: <input type="text" name="sTermMouse">';
				echo '</td></tr>';
				echo '</td></tr><tr><td class="btn-td">';
				echo '<input name="submit_term_mouse" value="Search" type="submit">';
				echo '</td></tr></table></form> </div>'; 
				echo '<div id="div-1d"> <img src="images/mouse.png" name="mouse" width="150" height="35" id="mouse" /></div>'; 
				echo '</div>';
}



function search($term,$tgArray, $species) {
	$term = strtolower($term);
	$count = 0;
	$table = "";
	$here = CurrentPageURL();
	
	
	for ($i=0; $i < count($tgArray); $i++) {
		
			$pos1 = strtolower($tgArray[$i][0]);
			if ($pos1 === $term) {
				$count++;
				$link = "?";
				$link .= "human_symbol=".$tgArray[$i][0]."&";
				$link .= "probeset_id=".$tgArray[$i][1]."&";
				$link .= "mouse_symbol=".$tgArray[$i][2]."&";
				$link .= "pearson=".$tgArray[$i][4]."&";
				$link .= "human_module=".$tgArray[$i][6]."&";
				$link .= "mouse_module=".$tgArray[$i][7]."&";
				$link .= "species=".$species;
					
				$here .= $link;
					
		}
	}
	
	if ($count == 0) {

		echo '<div id="div-6"> <BR><B>Gene not found. This can be because: <BR>(1) You did not type in a valid gene name. <BR>(2) Gene is not in the filtered one to one orthologs set.</B> </div>';


	} 
	else
	{	
		echo '
		<script type="text/javascript">
			window.location="'.$here.'"
		</script>';
	}

}



function CurrentPageURL() 
{
	$pageURL = "undefine";
	$pageURL = $_SERVER['HTTPs'] == 'on' ? 'https://' : 'http://';
	$url = $_SERVER['REQUEST_URI'];
	$url_poi = parse_url($url,  PHP_URL_PATH);
	$pageURL .= $_SERVER['SERVER_PORT'] != '80' ? $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$url_poi  : $_SERVER['SERVER_NAME'] . $url_poi;


	return $pageURL;
}
	


?>


<SCRIPT LANGUAGE="javascript">
var width = screen.width
var height = screen.height

var query = window.location.search.substring(1);
var vars = query.split('&');

var pair = vars[0].split('=');
var human_symbol = pair[1];
        
var pair = vars[1].split('=');
var probeset_id = pair[1];

var pair = vars[2].split('=');
var mouse_symbol = pair[1];

var pair = vars[3].split('=');
var pearson = pair[1].substring(0,5);

var pair = vars[4].split('=');
var human_module = pair[1];

var pair = vars[5].split('=');
var mouse_module = pair[1];

var pair = vars[6].split('=');
var species = pair[1];



document.write("<div id=div-3>")        

document.write("<h1>Mouse gene symbol:" + mouse_symbol + " COE=" + pearson + "</h3>")

document.write("<div id=div-4> <div id=div-4a> <a href=\"http://www.immgen.org/databrowser/index.html?gene_symbol=" + mouse_symbol + "\" target=\"_blank\"><img src=\"images/SkylineIcon.png\"/></a> </div>")

document.write("<div id=div-4b><a href=\"http://www.immgen.org/ModsRegs/modules.html?module=" + mouse_module + "&resolution=f\" target=\"_blank\"><img src=\"images/ModuleIcon.png\"/></a></div></div>")

document.write("<div id=div-5>")        




document.write("<img src=\"bar/" + human_symbol + ".jpg\" width=\"" + 0.7*width + "\" height=\"" + 0.7*width*0.2364 + "\" alt=\"Bar plot of gene expression\" />")


if (species == 'mouse')
{
	//document.write("<h3>Mouse module " + mouse_module + "</h3>")
	document.write("<img src=\"mouse_modules/" + mouse_module + ".jpg\" width=\"" + 0.7*width + "\" height=\"" + 0.9*width*0.58 + "\" alt=\"This gene was not assigned to a mouse module\" />") 
}
else
{
	//document.write("<h3>Human module " + human_module + "</h3>")
	document.write("<img src=\"human_modules/" + human_module + ".jpg\" width=\"" + 0.7*width + "\" height=\"" + 0.7*width*0.58 + "\" alt=\"This gene was not assigned to a human module\" />") 
}


document.write("</div> </div>")        

</SCRIPT>

</body>
</html>

