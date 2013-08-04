<div class="row detail">
	<div class="col-lg-2"></div>
	<div class="col-lg-6">
		<?php echo $state; ?>
		<img class="pull-left" src="<?php echo $book["img_link"]; ?>" />
		<h3><?php echo $book["title"]; ?></h3>
		<h4><?php echo $book["author"]; ?></h4>
		<p>
			Pages: <?php echo $book["pages"]; ?><br/><br/>
			Reading date: <?php echo $book["date"]; ?><br/>
		</p>
		<a href="index.php?p=detail&id=<?php echo $book["id"]; ?>&del=<?php echo $book["id"]; ?>"><button type="button" class="btn btn-danger">Delete</button></a> <a href="index.php?p=add&id=<?php echo $book["id"]; ?>"><button type="button" class="btn btn-info">Modify</button></a><br/><br/><br/>

		<div class="clearfix">
			<?php echo $book["desc"]; ?>
		</div>
	</div>
</div>