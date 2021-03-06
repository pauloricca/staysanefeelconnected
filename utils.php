<?
function startsWith($string, $startString) 
{ 
    $len = strlen($startString); 
	return (substr($string, 0, $len) === $startString); 
} 

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
            return true;
    }

    return (substr($haystack, -$length) === $needle);
}