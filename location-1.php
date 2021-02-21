<?
if(isset($response))
{
	$path = __DIR__."/data/$app/$location/$response";
	if(file_exists($path)) 
	{
		$data = json_decode(file_get_contents($path), true);
		if($data['feelings']) echo "<p>Someone else said:</p><p class='blue-text large-text'>$data[feelings]</p>";
		if($data['image']) echo "<img class='response-image' src='/data/uploads/$data[image]'/>";
	}
}
else
{?>
	<form method="post" action="/save.php" enctype="multipart/form-data">
		<p>We’re inviting you to reconnect with people through this environment.</p>

		<p>Share a message and/or image and someone will receive it. You’ll get one in return!</p>

		<textarea name="feelings" required placeholder="What are you feeling, thinking, wishing?"></textarea>
		<input type="file" name="image" accept="image/*" style="display: none"/>
		<div class="upload-hint">How's the weather??</div>
		<div class='visible-upload-btn'><img src='/assets/camera-2.svg'/></div>

		<input type="hidden" name="location" value="<?=$location?>"/>
		<input type="hidden" name="app" value="<?=$app?>"/>
		<input type="submit" value="send + receive"/>
	</form>
<?}