<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Rubik" rel="stylesheet">
<style>

    .XS{
        font-size:12px;
    }
    .S{
        font-size:18px;
    }
    .M{
        font-size:24px;
    }
    .L{
        font-size:28px;
    }
    .XL{
        font-size:32px;
    }
    html,body{
        width:100%;
        font-family: 'Rubik', sans-serif;
    }
    span{
        float:left;
        height:30px;
    }
</style>
</head>
<body>
<?php

// connect words like, thank you
//TODO colours
//TODO shapes maybe?
require_once("dbfunctions.php");
global $error;

function display_cloud($words){
    foreach($words AS $key => $word){
        $fontsize = "";
        $count = $word['count'];
        switch($count){
            case $count<=3:
                $fontsize = "XS";
                break;
            case $count>3 && $count<=5:
                $fontsize = "S";
                break;
            case $count>5 && $count<=8:
                $fontsize = "M";
                break;
            case $count>8 && $count<=12:
                $fontsize = "L";
                break;
            case $count>12:
                $fontsize = "XL";
                break;
        }
        echo "<span class='$fontsize'>".$word['word']."&nbsp;</span>";
    }
}

function sortby_count($wordlist){
	usort($wordlist, function($a, $b){
		return $a['count'] - $b['count'];
    });
	foreach($wordlist AS $attr) {
		echo $attr['word'] . " - " . $attr['count']. "<br/>";
	}
}

$blacklist = array('');

function remove_words($blacklist, $cloud, $threshold=0){
    if($threshold > 0){
        foreach($cloud AS $key => $val){
            if($cloud[$key]['count'] < $threshold){
	            unset($cloud[$key]);
            }
        }
    }
    foreach($blacklist AS $blockedword){
        if(array_key_exists($blockedword, $cloud)){
            unset($cloud[$blockedword]);
        }
    }
    return $cloud;
}

$error = "";
$con = db_con("wordcloud");

$result = db_query($con, "SELECT description FROM words");
$words = array();
if($result){
    $i=0;
    while($row = mysqli_fetch_assoc($result)){
        $words[$i++] = explode(" ", $row['description']);
    }
}

$cloud = array();
foreach($words AS $array) {
    foreach ($array AS $k => $v) {
        $cloud[$v]['word'] = $v;
        isset($cloud[$v]['count']) ? $cloud[$v]['count']++: $cloud[$v]['count'] = 1;;
    }
}
//$cloud = remove_words($blacklist, $cloud);
//sortby_count($cloud);
display_cloud($cloud);

mysqli_close($con);
if($error != ""){
    echo $error;
}
?>
</body>
</html>
