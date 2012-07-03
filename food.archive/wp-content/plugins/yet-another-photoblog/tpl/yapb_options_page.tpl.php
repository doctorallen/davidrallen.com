<!-- YAPB Options Page Body -->

<div class="wrap wrap-yapb-options">

	<div id="icon-options-general" class="icon32"><br/></div>
	<h2>YAPB Settings</h2>

	<?php do_action('admin_notices') ?>
	
	
	<?php 
	
		global $yapb;
	
		// Since i'm not able to cleanly remove all division by zero
		// bugs in this script, i'm removing all divisions with this function ;-)

		function saveDiv($param1, $param2) {
			$result = 0;
			if ($param2 != 0) {
				$result = $param1 / $param2;
			}
			return $result;
		}

		$imagefileCount = $this->maintainance->getImagefileCount();
		$imagefileSize = $this->maintainance->getImagefileSizeBytes();
		$cachefileCount = $this->maintainance->getCachefileCount();
		$cachefileSize = $this->maintainance->getCachefileSizeBytes(); 

		$averageImagefileSize = round(saveDiv($imagefileSize, $imagefileCount), 2);

		function strong($text) {
			return '<strong>' . $text . '</strong>';
		}

		function sizePresentation($sizeInBytes) {
			if ($sizeInBytes < 1048576) {
				return round($sizeInBytes / 1024, 0) . ' KB';
			} else {
				return round($sizeInBytes / 1024 / 1024, 1) . ' MB';
			}
		}

	?>	
	
	<div class="statbox yapb-statbox clearfix">

		<ul class="yapb-menu">
			<?php $groups = $this->options->getChildren() ?>
			<?php for ($i=0, $ilen=count($groups); $i<$ilen; $i++): ?>
				<?php $group = $groups[$i] ?>
				<li><a href="javascript:;" onClick="jQuery('.basic-accordion-link-<?php echo $i ?>').click();"><?php echo $group->getTitle() ?></a></li>
			<?php endfor ?>
		</ul>

		<div class="yapb-wrap clearfix">

			<div class="yapb-information">
				<h1><?php printf(__('Yet Another Photoblog %s', 'yapb'), $this->yapbVersion) ?></h1>
				<p><?php echo __('Convert your WordPress Blog into a full featured photoblog in virtually no time. Use the full range of WordPress functions and plugins: Benefit from the big community WordPress has to offer.', 'yapb') ?></p>
				<ul class="yapb-accordion">
					<li>
						<h2><?php echo $imagefileCount ?></strong> <?php _e('Images', 'yapb') ?></h2>
						<div class="content"><?php printf(__('You have posted %s YAPB-Images with an overall size of %s.', 'yapb'), strong($imagefileCount), strong(sizePresentation($imagefileSize))) ?> <?php if ($imagefileCount > 0): ?> <?php printf(__('In average, an image needs %s of disk space.', 'yapb'), sizePresentation(saveDiv($imagefileSize, $imagefileCount))) ?><?php endif ?></div>
					</li>
					<li>
						<h2><?php echo $cachefileCount ?></strong> <?php _e('Thumbnails','yapb') ?></h2>
						<div class="content">
							<?php if ($cachefileCount > 0): ?>
								<?php printf(__('Currently, the cache contains %s thumbnails with a overall size of %s.', 'yapb'), strong($cachefileCount), strong(sizePresentation($cachefileSize))) ?>
								<?php printf(__('In average, a thumbnail needs %s of disk space.', 'yapb'), strong(sizePresentation(saveDiv($cachefileSize, $cachefileCount)))) ?>
							<?php else: ?>
								<?php echo __('no thumbnails were generated yet.', 'yapb') ?>
							<?php endif ?>
						</div>
					</li>
					<li>
						<h2><?php echo sizePresentation($imagefileSize+$cachefileSize) ?></h2>
						<div class="content">
							<?php printf(__('Currently, YAPB consumes %s of disk space for images.', 'yapb'), strong(sizePresentation($imagefileSize + $cachefileSize))) ?><br/>
							<?php if ($cachefileCount > 0): ?>
								<?php printf(__('In average, %s thumbnails per image were generated.', 'yapb'), strong(round(saveDiv($cachefileCount, $imagefileCount), 2))) ?><br/>
								<?php printf(__('In average, one posted image incl. all associated thumbnails needs approx. %s of disk space.', 'yapb'), strong(sizePresentation(saveDiv($cachefileCount, $imagefileCount) * saveDiv($cachefileSize, $cachefileCount) + saveDiv($imagefileSize, $imagefileCount)))) ?><br/>
							<?php endif; ?>
						</div>
					</li>
					
					<?php $missingfiles = $this->maintainance->getMissingFiles(); ?>
					<?php if (!empty($missingfiles)): ?>
						<li class="error">
							<h2>
								<?php if (count($missingfiles) == 1): ?>
									<?php _e('Missing file', 'yapb') ?>
								<?php else: ?>
									<?php printf(__('Missing files (%s)', 'yapb'), count($missingfiles)) ?>
								<?php endif ?>
							</h2>
							<div class="content">
								<?php _e('YAPB is unable to find the following image(s):', 'yapb') ?>
								<ul class="files">
									<?php foreach ($missingfiles as $missingfile): ?>
										<li class="file">
											<?php echo $missingfile->uri ?><br/>
											<a href="<?php echo get_permalink($missingfile->post_id) ?>"><?php _e('show post', '') ?></a> 
											<a href="<?php echo $_SERVER['REQUEST_URI'] ?>&action=cleanup_entry&post_id=<?php echo $missingfile->post_id ?>"><?php _e('clean up entry', 'yapb') ?></a></li>
									<?php endforeach ?>
								</ul>
							</div>
						</li>
					<?php endif ?>
					
				</ul>

				<?php if ($cachefileCount > 0): ?>
					<form method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>" class="yapb-clear-cache" style="margin-top: 20px;">
						<input type="hidden" name="page" value="<?php echo $_GET['page'] ?>">
						<input type="hidden" name="action" value="clear_cache" /> 
						<input type="submit" name="clear" value="<?php _e('Clear thumbnail cache','yapb') ?>" class="button" />
					</form>
				<?php endif ?>

			</div>

			<div class="yapb-teasers">
				<?php /*
				<a class="yapb-teaser yapb-teaser-community clearfix" href="http://forum.jarolim.com/yapb">
					<h2><?php _e('YAPB Community', 'yapb') ?></h2>
					<p><?php _e("There's a growing community using YAPB to publish their photos via WordPress - Ask for help or share your knowledge on the forum.", 'yapb') ?></p>
					<span class="cta"><?php _e('Join YAPB-Forum', 'yapb') ?></span>
				</a>
				*/ ?>
				<?php
				
					$paypal = array(
						'cmd' => '_xclick',
						'business' => 'paypal@johannes.jarolim.com',
						'item_name' => 'A donation for Yet Another Photoblog',
						'item_number' => '1',
						'no_shipping' => '2',
						'no_note' => '1',
						'currency_code' => 'EUR',
						'tax' => '0',
						'lc' => 'AT',
						'bn' => 'PP-DonationsBF'
					);
				
				?>
				<a class="yapb-teaser yapb-teaser-donate clearfix" href="http://www.paypal.com/cgi-bin/websrc?<?php echo http_build_query($paypal) ?>" target="_blank">
					<h2><?php _e('Support Open Source', 'yapb') ?></h2>
					<p><?php _e('Help keeping YAPB freely available, up and running: Support the authors efforts.', 'yapb') ?></p>
					<span class="cta cta-important"><?php _e('Donate now', 'yapb') ?></span>
				</a>
				<a class="yapb-teaser yapb-teaser-support clearfix" href="mailto:office@jarolim.com">
					<h2><?php _e('Professional Support', 'yapb') ?></h2>
					<p><?php _e('In case you need help integrating, using or maintaining YAPB in a professional environment: The plugin author also offers professional support.', 'yapb') ?></p>
					<span class="cta cta-important"><?php _e('Request support', 'yapb') ?></span>
				</a>
			</div>

		</div>

	</div>	
	
	

	<!-- All Options -->

	<?php

		// We attach an timestamp to the form action URL so 
		// we always see accurate data

		$requestURI = $_SERVER['REQUEST_URI'];
		$requestParameters = array();
		$requestParameters[] = 'nocache=' . time();
		$requestParameters[] = 'page=' . Params::get('page', '');
		$requestURI .= ((strpos($requestURI, '?') === false) ? '?' : '&') . implode('&', $requestParameters);

	?>

	<form method="post" action="<?php echo $requestURI ?>">

		<input type="hidden" name="page" value="<?php echo $_GET['page'] ?>"> 
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="tabindex" id="tabindex" value="false" />
		<input type="hidden" name="accordionindex" id="accordionindex" value="<?php echo ($this->active+1) ?>" />

		<?php echo $this->options->toString() ?>

		<p class="submit">
			<input type="submit" name="Submit" value="<?php _e('Save Changes') ?> &raquo;" class="button-primary" /> 
		</p>

	</form>

	<!-- /All Options -->

	<div id="debug"></div>

</div>


<script type="text/javascript" language="javascript">

	jQuery(document).ready(
		function() {

			jQuery('.yapb-accordion li').each(
				function(index) {

					jQuery(this)
					.addClass('yapb-accordion-item')
					.addClass('yapb-accordion-item-'+index)
					.addClass('yapb-accordion-item-closed');

					jQuery('h2', this).replaceWith(
						'<a class="yapb-accordion-link yapb-accordion-link-' + index + '" href="#">' + 
						jQuery('h2', this).html() + 
						'</a>'
					);

					jQuery('.content', this)
					.addClass('yapb-accordion-content')
					.addClass('yapb-accordion-content-'+index)
					.hide();

					jQuery('a', this).click(
						function() {

							var isCurrent = jQuery(this).closest('li').hasClass('yapb-accordion-item-opened');

							// Hide all opened accordions

							jQuery('.yapb-accordion-item-opened').each(
								function() {
									jQuery('.content', this).hide(500);
									jQuery(this).removeClass('yapb-accordion-item-opened');
								}
							);

							if (!isCurrent) {

								// Open desired accordion

								jQuery('.yapb-accordion-item-'+index).each(
									function() {
										jQuery(this)
										.removeClass('yapb-accordion-item-closed')
										.addClass('yapb-accordion-item-opened');
										jQuery('.content', this).show(500);
									}
								);

							}

						}

					);

				}

			);

		}
	);



</script>


<!-- /YAPB Options Page Body -->