<?php $hood=($_GET['hoodId']);
include("include.php");
$block_query="SELECT blockId,blockName FROM hood WHERE hood='$hood'";
$result = $mysqli->query($block_query);
?>
<select name="block" class="form-control">
<option>Select Block</option>
<?php $counter=1;while ($row = $result->fetch_assoc()) { ?>
<option value=<?php echo $row['blockId']?>><?php echo $row['blockName']?></option>
<?php } ?>
</select>
