<?
require __DIR__.'/utils.php';
include __DIR__.'/header.php';

echo "<script src='/lib/imagesloaded.pkgd.min.js'></script>";
echo "<script src='/lib/masonry.pkgd.min.js'></script>";

$path = __DIR__."/data/$app/$location";
$entries = scandir($path);
//newest images first
rsort($entries);

echo "<h1 class='blue-text'>Stay Sane, Feel Connected – The Dashboard</h1>";
echo "<div class='entries'>";

foreach($entries as $entry)
{
    if(in_array($entry, ['.', '..'])) continue;

    $hidden = endsWith($entry, '_');
    $hiddenClass = $hidden ? 'hidden' : '';

    echo "<div class='entry rough-border $hiddenClass' data-id='$entry'>";

    echo "<div class='meta-data'>" . gmdate("D, d M Y H:i", trim($entry, '_')) . "</div>";
    
    $entryData = json_decode(file_get_contents("$path/$entry"), true);
    foreach($entryData as $key => $value)
    {
        if(!in_array($key, ['app', 'location', 'image']))
        {
            echo "<p class='blue-text large-text'>$value</p>";
        }
    }

    if($entryData['image'])
    {
        echo "<img class='response-image' src='/data/uploads/thumbs/$entryData[image]'/>";
    }
    echo "<div class='hide-btn btn'>hide</div>";
    echo "<div class='show-btn btn'>show</div>";
    echo "</div>";
}

echo "</div>";
?>

<script>
    $(function(){
        var $entries = $('.entries'); 
        $entries.imagesLoaded(function() {
            $entries.masonry({
                columnWidth: 350,
                gutter: 0,
                itemSelector: '.entry'
            });
        });
    });
</script>

<?include __DIR__.'/footer.php';