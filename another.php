<?php
date_default_timezone_set("Africa/Lagos");
$timezone = date_default_timezone_get();

echo $timezone . "<br>";
$date    = Date("M-y-l:h-i-s", (time() + (60 * 60 * 24)));
$hour   = 13;
$min    = 30;
$sec    = 45;
$mon    = 8;
$day    = 12;
$year   = 2025;

if( isset( $_GET['hour'])){
    $hour   = 12 + (int) $_GET['hour'];
}


$timestamp = mktime($hour, $min, $sec, $mon, $day, $year);
$date    = Date("M-y-l:h-i-s", $timestamp);
#CHEET code for formating time Using
#CRON JOBS 
#Y - full year - 2025
#y - for abbr Year - 25
#m - for abbr Month - 02
#M - For abbr Month Name
#d - for abbr Month Day 02
#D - for abbr week Day FRI
#h - hour format 12 Hour format
#H - 24 hours format
#i - Minutes
#s - Seconds
#a - am or pm
#j - the same as d
#l - for Lowercase full representation of week days
echo $date;

var_dump($_SERVER);
?>


<form action="<?= $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
    <label>Enter your hour:</label>
    <input type="text" name="hour" id="">
    <button type="submit">Submit</button>
</form>
