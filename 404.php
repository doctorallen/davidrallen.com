<?php include('includes/header.html'); ?>
<script type="text/javascript">
	$(function (){
		$('#report_link').onClick(){
			alert('Thank you for reporting the link');
		}
	});
</script>
<div class="hero-unit">
<h1 class="fade">This is not the page you are looking for.</h1>
<p class="fade">Or did you really think that <strong><?php echo urldecode($_SERVER['REQUEST_URI']); ?></strong> was a real page?</p>	
<a href="http://davidrallen.com"><button class="btn btn-primary btn-big fade" name="home">Go Home</button></a>
<a href="http://davidrallen.com"><button id="report_link" class="btn btn-danger btn-big fade" name="home">Report Broken Link</button></a>

</div>
<?php include('includes/footer.html'); ?>

