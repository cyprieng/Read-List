		<script src="<?php echo JS_PATH; ?>bootstrap.js"></script>
		<script src="<?php echo JS_PATH; ?>bootstrap-datepicker.js"></script>
		<script src="<?php echo JS_PATH; ?>bootstrap-sortable.js"></script>
		<script src="<?php echo JS_PATH; ?>jquery.flot.min.js"></script>
		<script src="<?php echo JS_PATH; ?>jquery.flot.categories.js"></script>
		<script>
			$(".datepicker").datepicker({
				format: 'dd-mm-yyyy'
			});

			$("#minimize").click(function(){minimize($(this))});
			function minimize(el){
				el.toggleClass('active');
				$('.minimize').removeClass("minimize").addClass("maximize");
				el.unbind("click").click(function(){maximize(el)});
			}
			function maximize(el){
				el.toggleClass('active');
				$('.maximize').removeClass("maximize").addClass("minimize");
				el.unbind("click").click(function(){minimize(el)});
			}
		</script>
	</body>
</html>