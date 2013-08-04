<tr onclick="if(event.target.nodeName != 'A'){document.location = 'index.php?p=detail&id=<?php echo $book["id"]; ?>';}">
	<td><div class="minimize"><a href="index.php?p=detail&id=<?php echo $book["id"]; ?>"><img src="<?php echo $book["img_link"]; ?>"/></a></div></td>
	<td><div class="minimize"><a href="index.php?p=detail&id=<?php echo $book["id"]; ?>"><?php echo $book["author"]; ?></a></div></td>
	<td><div class="minimize title"><a href="index.php?p=detail&id=<?php echo $book["id"]; ?>"><?php echo $book["title"]; ?></a></div></td>
	<td class="desc"><div class="minimize"><a href="index.php?p=detail&id=<?php echo $book["id"]; ?>"><?php echo $book["desc"]; ?></a></div></td>
	<td data-dateformat="DD-MM-YYYY"><div class="minimize no-wrap"><a href="index.php?p=detail&id=<?php echo $book["id"]; ?>"><?php echo $book["date"]; ?></a></div></td>
	<td><div class="minimize no-wrap"><a href="index.php?p=detail&id=<?php echo $book["id"]; ?>"><?php echo $book["mark"]; ?></a></div></td>
</tr>