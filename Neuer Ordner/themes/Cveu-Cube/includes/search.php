<?php if (FUSION_SELF == "search.php") { } else { ?>
	<form id="search" action="<?php echo BASEDIR."search.php" ?>" method="get">
	<input type="text" name="stext" id="s" placeholder="<?php echo $locale['cube_0005']; ?>"/>
	</form>
<?php } ?>