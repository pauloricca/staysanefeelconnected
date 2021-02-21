<?
if(!count($_POST)) die();
$app = $_POST['app'];
$location = $_POST['location'];

$maxImageSize = 1000;
$thumbSize = 200;

$path = __DIR__."/data/$app/$location";

if(!file_exists(__DIR__.'/data/')) mkdir(__DIR__.'/data/');
if(!file_exists(__DIR__.'/data/uploads')) mkdir(__DIR__.'/data/uploads');
if(!file_exists(__DIR__.'/data/uploads/thumbs')) mkdir(__DIR__.'/data/uploads/thumbs');
if(!file_exists(__DIR__."/data/$app")) mkdir(__DIR__."/data/$app");
if(!file_exists($path)) mkdir($path);

$files = scandir($path);

$randomFile = $files[rand(2, count($files)-1)];

$time = time();

if (($_FILES['image']['name']!=""))
{
	// Where the file is going to be stored
	$target_dir = __DIR__."/data/uploads";
	$file = $_FILES['image']['name'];
	$filePath = pathinfo($file);
	$filename = $filePath['filename'];
	$ext = strtolower($filePath['extension']);
	
	if (in_array($ext, ['jpg', 'jpeg', 'gif', 'png', 'webp', 'png']))
	{
		$temp_name = $_FILES['image']['tmp_name'];
		
		$imageFileName = "$time.jpg";
		$imagePath = "$target_dir/$imageFileName";
		$thumbPath = "$target_dir/thumbs/$imageFileName";
		
		$size = getimagesize($temp_name);
		$ratio = $size[0]/$size[1]; // width/height
		if( $ratio > 1) {
		    $width = $maxImageSize;
		    $height = $maxImageSize/$ratio;
		    $thumbWidth = $thumbSize;
		    $thumbHeight = $thumbSize/$ratio;
		}
		else {
		    $width = $maxImageSize*$ratio;
		    $height = $maxImageSize;
		    $thumbWidth = $thumbSize*$ratio;
		    $thumbHeight = $thumbSize;
		}

		// Create main Image
		$src = imagecreatefromstring(file_get_contents($temp_name));
		$dst = imagecreatetruecolor($width,$height);
		imagecopyresampled($dst,$src,0,0,0,0,$width,$height,$size[0],$size[1]);
		imagedestroy($src);
		imagejpeg($dst, $imagePath);
		imagedestroy($dst);

		//Create Thumb
		$src = imagecreatefromstring(file_get_contents($temp_name));
		$dst = imagecreatetruecolor($thumbWidth,$thumbHeight);
		imagecopyresampled($dst,$src,0,0,0,0,$thumbWidth,$thumbHeight,$size[0],$size[1]);
		imagedestroy($src);
		imagejpeg($dst, $thumbPath);
		imagedestroy($dst);
		
		$_POST['image'] = $imageFileName;
	}
}

file_put_contents("$path/$time", json_encode($_POST, true));

header("Location: /?l=$location&a=$app&response=$randomFile");