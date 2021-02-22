<?
require __DIR__.'/utils.php';

$dataDir = __DIR__.'/data';

$action = $_GET['action'];
if(isset($action))
{
    $id = $_GET['id'];
    switch($action)
    {
        case 'show':
            rename("$dataDir/$id", trim("$dataDir/$id", '_'));
            break;

        case 'hide':
            if(!endsWith($id, '_')) rename("$dataDir/$id", "$dataDir/$id".'_');
            break;
    }
    exit();
}

$pageTitle = "SSFC - The Dashboard";
include __DIR__.'/header.php';

echo "<script src='/lib/imagesloaded.pkgd.min.js'></script>";
echo "<script src='/lib/masonry.pkgd.min.js'></script>";

$path = "$dataDir/$app/$location";
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

    echo "<div class='entry rough-border $hiddenClass' data-id='$app/$location/$entry'>";

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
        echo "<a href='/data/uploads/$entryData[image]' target='_blank'><img class='response-image' src='/data/uploads/thumbs/$entryData[image]'/></a>";
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

        $('.hide-btn').click(function(){
            var $entry = $(this).closest('.entry');
            var id = $entry.attr('data-id');
            if(!id.endsWith('_'))
            {
                $.get( "?action=hide&id="+id, function( data ) {
                    $entry.attr('data-id', id+'_');
                    $entry.addClass('hidden');
                });
            }
        })

        $('.show-btn').click(function(){
            var $entry = $(this).closest('.entry');
            var id = $entry.attr('data-id');
            if(id.endsWith('_'))
            {
                $.get( "?action=show&id="+id, function( data ) {
                    $entry.attr('data-id', id.replace('_', ''))
                    $entry.removeClass('hidden');
                });
            }
        })
    });
</script>

<?include __DIR__.'/footer.php';