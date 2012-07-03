<!-- YAPB Options Page Head -->

	<!-- YAPB Admin Panel Styles -->
	<link rel="stylesheet" type="text/css" href="<?php echo YAPB_PLUGIN_PATH ?>tpl/css/yapb_options_page.css" />

	<!-- jQuery UI Accordion -->
	<script type="text/javascript" src="<?php echo YAPB_PLUGIN_PATH ?>tpl/js/jquery.scrollTo-min.js"></script>
	<script type="text/javascript" src="<?php echo YAPB_PLUGIN_PATH ?>tpl/js/jquery.dimensions.js"></script>
	<script type="text/javascript" src="<?php echo YAPB_PLUGIN_PATH ?>tpl/js/jquery.ui-1.5b/ui.accordion.js"></script>
	<script type="text/javascript">
		//<![CDATA[
		
		(function($) {

			$(document).ready(
				function() {

					$("#accordion")
					.accordion(
						{
							autoheight:false,
							header:".basic-accordion-link",
							active:<?php echo $this->active ?>,
							alwaysOpen:false
						}
					);

					$(".ui-accordion").bind("change.ui-accordion", function(event, ui) {
						
						var instance = $.data(this, "ui-accordion");
						var options = instance.options;
						var headers = $(options.headers);

						// Find 

						var foundIndex = 'false';
						for (i=0; i<headers.length; i++) {
							if ($(headers[i]).html() == ui.newHeader.html()) {
								foundIndex = i;
								break;
							}
						}

						// we submit the foundindex+1 so the php backend doesn't
						// interpret 0 as false
						$('#accordionindex').attr('value', foundIndex+1);

						// scroll to the start of the tabs
						$.scrollTo($(".basic-accordion-anchor"), 500);

					});

					<?php if (Params::get('accordionindex', null) != null): ?>

						// If we sent an update with an open accordion,
						// we scroll to the accordion anchor

						$.scrollTo($(".basic-accordion-anchor"), 500);

					<?php endif ?>

				}
			)

		})(jQuery);

		//]]>
	</script>

	<!-- /jQuery Accordion -->

<!-- /YAPB Options Page Head -->