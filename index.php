<?
$bodyClasses = 'rough-border';
include __DIR__.'/header.php';

$response = $_GET['response'];

echo "<h1 class='blue-text'>Stay Sane,<br>Feel Connected</h1>";

include __DIR__."/location-$location.php";

include __DIR__.'/footer.php';