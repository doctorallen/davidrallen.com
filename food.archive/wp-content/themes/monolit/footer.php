<?php
/*
Template Name: Footer
*/
?>
	</div> <!-- class="cf" -->
	<div id="footer">
		<?php print MONOLIT_CONTENT_FOOTER."\n" ?>
	</div> <!-- id="footer" -->
</div> <!-- class="whitebg"-->
</body>
</html>

<?php
	if ( $_SESSION['monolit:info'] ) session_unregister('monolit:info');
?>
