<div class="container">
	<form id="addForm" action="index.php?p=add<?php if(isset($_GET["id"]) && !is_nan($_GET["id"])){echo "&id=".$_GET["id"];} ?>" method="post">
		<fieldset>
			<legend>Add a book</legend>
			<?php echo $state; ?>
			<fieldset>
				<legend>Main information</legend>

				<label for="author">Author: </label>
				<input type="text" id="author" name="author" placeholder="Author" value="<?php echo $author; ?>">

				<label for="title">Title: </label>
				<input type="text" id="title" name="title" placeholder="Title" value="<?php echo $title; ?>"><br/><br/>
				
				<?php if(!$showall){ ?><button type="submit" class="btn btn-default">Search</button><?php } ?>
			</fieldset>

			<?php if($showall){ ?>
				<fieldset>
					<legend>Check extra information</legend>
					
					<label for="img"><img src="<?php echo $data['img']; ?>" /></label>
					<input type="text" id="img" name="img" placeholder="Image link" value="<?php echo $data['img']; ?>"><br/><br/>

					<label for="pages">Number of pages: </label>
					<input type="text" id="pages" name="pages" placeholder="Pages number" value="<?php echo $data['pages']; ?>"><br/><br/>

					<label for="desc">Description: </label>
					<textarea id="desc" name="desc" placeholder="Description"><?php echo $data['desc']; ?></textarea><br/><br/>
				</fieldset>
				<fieldset>
					<legend>Your data</legend>
					
					<label for="date">Reading date: </label>
					<input type="text" class="datepicker" id="date" name="date" placeholder="Reading date" value="<?php echo $date;?>"><br/><br/>

					<label for="mark">Mark: </label>
					<select id="mark" name="mark">
						<option value="0" <?php if($mark == "0") echo "selected"; ?>>0</option>
						<option value="1" <?php if($mark == "1") echo "selected"; ?>>1</option>
						<option value="2" <?php if($mark == "2") echo "selected"; ?>>2</option>
						<option value="3" <?php if($mark == "3") echo "selected"; ?>>3</option>
						<option value="4" <?php if($mark == "4") echo "selected"; ?>>4</option>
						<option value="5" <?php if($mark == "5") echo "selected"; ?>>5</option>
						<option value="6" <?php if($mark == "6") echo "selected"; ?>>6</option>
						<option value="7" <?php if($mark == "7") echo "selected"; ?>>7</option>
						<option value="8" <?php if($mark == "8") echo "selected"; ?>>8</option>
						<option value="9" <?php if($mark == "9") echo "selected"; ?>>9</option>
						<option value="10" <?php if($mark == "10") echo "selected"; ?>>10</option>
						<option value="11" <?php if($mark == "11") echo "selected"; ?>>11</option>
						<option value="12" <?php if($mark == "12") echo "selected"; ?>>12</option>
						<option value="13" <?php if($mark == "13") echo "selected"; ?>>13</option>
						<option value="14" <?php if($mark == "14") echo "selected"; ?>>14</option>
						<option value="15" <?php if($mark == "15") echo "selected"; ?>>15</option>
						<option value="16" <?php if($mark == "16") echo "selected"; ?>>16</option>
						<option value="17" <?php if($mark == "17") echo "selected"; ?>>17</option>
						<option value="18" <?php if($mark == "18") echo "selected"; ?>>18</option>
						<option value="19" <?php if($mark == "19") echo "selected"; ?>>19</option>
						<option value="20" <?php if($mark == "20") echo "selected"; ?>>20</option>
					</select>/20<br/><br/>
				</fieldset>
				<br/><br/>
				<button type="submit" class="btn btn-default">Submit</button>
			<?php } ?>
		</fieldset>
	</form>
</div>