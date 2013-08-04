<div class="row detail">
	<div class="col-lg-1"></div>
	<div class="col-lg-7">
		<p id="overview">
			<br/>
			Books read: <?php echo $booksNumber; ?><br/>
			Pages read: <?php echo $pagesNumber; ?><br/>
			Time reading: <?php echo $date; ?><br/>
		</p>
		<p id="graphs">
			<div id="bookPerMonth"></div>
			<div id="bookPerYear"></div>
		</p>
	</div>
</div>

<script type="text/javascript">
	// Load the Visualization API and the piechart package.
	google.load('visualization', '1.0', {'packages':['corechart']});

	// Set a callback to run when the Google Visualization API is loaded.
	google.setOnLoadCallback(drawCharts);

	// Callback that creates and populates a data table,
	// instantiates the pie chart, passes in the data and
	// draws it.
	function drawCharts() {
		//BookPerMonth
		// Create the data table.
		var bookPerMonth = google.visualization.arrayToDataTable([
				['Month', 'Books'],
				<?php
					foreach($count as $key => $number){
						echo "['$monthList[$key]',  $number],";
					}
				?>
		]);

		// Set chart options
		var bookPerMonthOptions = {'title':'Books per month'};

		// Instantiate and draw our chart, passing in some options.
		var bookPerMonthChart = new google.visualization.ColumnChart(document.getElementById('bookPerMonth'));
		bookPerMonthChart.draw(bookPerMonth, bookPerMonthOptions);

		//BookPerYear
		// Create the data table.
		var bookPerYear = google.visualization.arrayToDataTable([
				['Year', 'Books'],
			<?php
				foreach($countYear as $key => $number){
					echo "['$key',  $number],";
				}
			?>
		]);

		// Set chart options
		var bookPerYearOptions = {'title':'Books per year'};

		// Instantiate and draw our chart, passing in some options.
		var bookPerYearChart = new google.visualization.LineChart(document.getElementById('bookPerYear'));
		bookPerYearChart.draw(bookPerYear, bookPerYearOptions);
	}
</script>