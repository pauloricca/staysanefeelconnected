<?include __DIR__.'/header.php';

$app = $_GET['a'] || 1;
$location = $_GET['l'] || 1;
$response = $_GET['response'];

include __DIR__."/location-$location.php";

include __DIR__.'/footer.php';