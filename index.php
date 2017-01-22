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

//TODO create block filter for words (like 'it', 'is', 'a', etc)
//  also for words that have less than a threshold?
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

$error = "";
$con = db_con("wordcloud");

$result = db_query($con, "SELECT * FROM words");
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
display_cloud($cloud);

mysqli_close($con);
if($error != ""){
    echo $error;
}
?>
</body>
</html>
