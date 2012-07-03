
	<?php
		
		// Since i'm not able to cleanly remove all division by zero
		// bugs in this script, i'm removing all divisions with this function ;-)

		function saveDiv($param1, $param2) {
			$result = 0;
			if ($param2 != 0) {
				$result = $param1 / $param2;
			}
			return $result;
		}

		$maintainance = $this->yapbMaintainanceInstance;

		$imagefileCount = $maintainance->getImagefileCount();
		$imagefileSize = $maintainance->getImagefileSizeBytes();
		$cachefileCount = $maintainance->getCachefileCount();
		$cachefileSize = $maintainance->getCachefileSizeBytes(); 

		$averageImagefileSize = round(saveDiv($imagefileSize, $imagefileCount), 2);

		function strong($text) {
			return '<strong>' . $text . '</strong>';
		}
		
		function sizePresentation($sizeInBytes) {
			if ($sizeInBytes < 1048576) {
				return strong(round($sizeInBytes / 1024, 0)) . ' KB';
			} else {
				return strong(round($sizeInBytes / 1024 / 1024, 1)) . ' MB';
			}
		}

	?>

	<p>
		<?php printf(__('You have posted %s <a href="http://johannes.jarolim.com/yapb" target="_blank">YAPB</a>-Images with an overall size of %s.', 'yapb'), strong($imagefileCount), sizePresentation($imagefileSize)) ?> <?php if ($imagefileCount > 0): ?><?php printf(__('In average, an image needs %s of disk space', 'yapb'), sizePresentation(saveDiv($imagefileSize, $imagefileCount))) ?><?php endif ?> <a href="options-general.php?page=Yapb.class.php"><?php echo __('more info &raquo;', 'yapb') ?></a>
	</p>

	<?php /** SHOW THE LAST 5 POSTS **/ ?>

	<?php query_posts('category=' . $this->category . '&showposts=' . $this->numberposts) ?>
	<?php if (have_posts()): ?>

		<p><strong>Recent Images</strong></p>

		<?php while (have_posts()): ?>

			<?php the_post(); global $post; ?>

			<?php if (yapb_is_photoblog_post()): ?>
				<?php yapb_thumbnail('', array('rel' => 'lightbox'), '', array('h=50', 'q=90'), 'yapb_dashboard_thumbnail') ?>
			<?php endif ?>

		<?php endwhile ?>

	<?php else: ?>

		<p><?php echo __('No YAPB photoblog posts yet.', 'yapb') ?></p>

	<?php endif ?>
