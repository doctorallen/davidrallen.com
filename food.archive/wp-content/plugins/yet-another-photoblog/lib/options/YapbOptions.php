<?php

	// Option helper classes

	require_once realpath(dirname(__file__) . '/YapbCheckboxInputOption.class.php');
	require_once realpath(dirname(__file__) . '/YapbRadioOption.class.php');
	require_once realpath(dirname(__file__) . '/YapbCheckboxOption.class.php');
	require_once realpath(dirname(__file__) . '/YapbCheckboxSelectOption.class.php');
	require_once realpath(dirname(__file__) . '/YapbExifTagnamesOption.class.php');
	require_once realpath(dirname(__file__) . '/YapbInputOption.class.php');
	require_once realpath(dirname(__file__) . '/YapbSelectOption.class.php');
	require_once realpath(dirname(__file__) . '/YapbSeparatorOption.class.php');
	require_once realpath(dirname(__file__) . '/YapbTextareaOption.class.php');
	require_once realpath(dirname(__file__) . '/YapbOptionGroup.class.php');

	// The actual list of options
	
	$this->options = new YapbOptionGroup(

		__('YAPB Main Plugin'),
		'',
		array(

			new YapbOptionGroup(
				__('General Options', 'yapb'),
				__('Welcome to YAPB and to it\'s numerous configuration possibilities.<br/>Don\'t panic ;-)', 'yapb'),
				array(

					new YapbOptionGroup(
						__('Writing Options', 'yapb'),
						__('These settings do alter the behaviour of the WordPress input mask for new articles.', 'yapb'),
						array(
							new YapbCheckboxOption('yapb_check_post_date_from_exif', __('Check by default: Post date from image exif data if available.', 'yapb'), true),
							new YapbCheckboxSelectOption('yapb_default_post_category', __('Assign post exclusivly to category # if attaching an YAPB-image.', 'yapb'), $this->_options_categories_array(), false, ''),
							new YapbCheckboxOption('yapb_form_on_page_form', __('Enable YAPB-Imageupload for content pages', 'yapb'), false)
						)
					),

					new YapbOptionGroup(
						__('EXIF Filtering Options', 'yapb'), 
						__('EXIF Tags don\'t get displayed by default: Have a look how to adapt your theme manually to show them on your page.', 'yapb'),
						array(
							new YapbCheckboxOption('yapb_filter_exif_data', __('Enable EXIF tags filtering', 'yapb'), false),
							new YapbExifTagnamesOption('yapb_view_exif_tagnames', __('List only the following EXIF tags if available:', 'yapb'), array())
						)
					),
					new YapbOptionGroup(
						'Update Services', 
						'',
						array(
							new YapbTextareaOption('yapb_ping_sites', __('YAPB notifies the following site update services if you publish a photoblog-post.<br />These services will be pinged additionally to the services defined on the options/write admin-panel.<br />Separate multiple service URIs with line breaks.', 'yapb'), '')
						)
					)
				)
			),

			new YapbOptionGroup(
				__('Thumbnailer Options', 'yapb'), 
				__('<a href="http://phpthumb.sourceforge.net/" target="_blank">phpThumb</a> is the thumbnailing library of my choice. For your comfort, i made available a selection of settings: For more Information please refer to <a href="http://phpthumb.sourceforge.net" target="_blank">http://phpthumb.sourceforge.net</a> - Especially this two pages: <a href="http://phpthumb.sourceforge.net/demo/docs/phpthumb.readme.txt" target="_blank">readme</a> and <a href="http://phpthumb.sourceforge.net/demo/docs/phpthumb.faq.txt" target="_blank">faq</a>.', 'yapb'),
				array(
				
					new YapbOptionGroup(
						__('ImageMagick configuration', 'yapb'),
						__('If source image is larger than available memory limits AND <a href="http://www.imagemagick.org" target="_blank">ImageMagick\'s "convert" program</a> is available on your server, phpThumb() will call ImageMagick to perform the thumbnailing of the source image to bypass the memory limitation.', 'yapb'),
						array(
							new YapbInputOption('yapb_phpthumb_imagemagick_path', __('Absolute pathname to "convert": #40', 'yapb'), '')
						)
					),
					new YapbOptionGroup(
						__('Default output configuration', 'yapb'), 
						'',
						array(
							new YapbCheckboxOption('yapb_display_images_xhtml', __('Output Thumbnail URLs XHTML compatible (&amp;amp; instead of &)', 'yapb'), true),
							new YapbSelectOption('yapb_phpthumb_output_format', __('Default output format: # Thumbnail will be output in this format (if available in your version of GD).', 'yapb'), array('JPG' => 'jpeg', 'PNG' => 'png', 'GIF' => 'gif'), 'jpeg'),
							new YapbSelectOption('yapb_phpthumb_jpeg_quality', __('Default JPG output quality: # (The higher, the better; better = bigger filesize)','yapb'), array(
								'10 '.__('(forget that)','yapb') => '10', 
								'15' => '15', 
								'20' => '20', 
								'25' => '25', 
								'30 '.__('(very poor)','yapb') => '30', 
								'35' => '35',
								'40' => '40', 
								'45' => '45', 
								'50' => '50', 
								'55' => '55', 
								'60 '.__('(moderate)','yapb') => '60', 
								'65' => '65', 
								'70' => '70', 
								'75' => '75', 
								'80 '.__('(ok)','yapb') => '80', 
								'85' => '85', 
								'90 '.__('(very good)','yapb') => '90', 
								'95' => '95', 
								'100 '.__('(premium)','yapb') => '100',
							), '80'),
							new YapbCheckboxOption('yapb_phpthumb_output_interlace', __('Interlaced output for GIF/PNG, progressive output for JPEG; if unchecked: non-interlaced for GIF/PNG, baseline for JPEG.', 'yapb'), false)
						)
					)
				)
			),

			new YapbOptionGroup(
				__('Feed Options', 'yapb'), 
				__('Here you may alter the behaviour of the automatic feed insertion.', 'yapb'),
				array(

					new YapbOptionGroup(
						__('Feed content thumbnail', 'yapb'),
						__('YAPB may embed images/thumbnails directly into the content of your RSS2 and ATOM feeds.<br/>You will have to turn on this feature if you want to subscribe to services like <a href="http://photos.vfxy.com" target="_blank">VFXY</a>.', 'yapb'),
						array(
							new YapbCheckboxOption('yapb_display_images_xml', __('<strong>Embed images in RSS2 and ATOM feeds content.</strong>', 'yapb'), true),
							new YapbCheckboxOption('yapb_display_images_xml_xhtml', __('Use XHTML style image tags in content.', 'yapb'), false),
							new YapbInputOption('yapb_display_images_xml_inline_style', __('Inline CSS-Style for image tag: #40', 'yapb'), 'float:left;padding:0 10px 10px 0;'),
							new YapbTextareaOption('yapb_display_images_xml_html_before', __('Custom HTML before image tag', 'yapb'), ''),
							new YapbTextareaOption('yapb_display_images_xml_html_after', __('Custom HTML after image tag', 'yapb'), ''),
							new YapbCheckboxOption('yapb_display_images_xml_thumbnail_activate', __('Embed as thumbnail', 'yapb'), true),
							new YapbOptionGroup(
								'',
								'',
								array(
									new YapbInputOption('yapb_display_images_xml_thumbnail', __('Maximum thumbnail width of #3 px', 'yapb'), '180'),
									new YapbInputOption('yapb_display_images_xml_thumbnail_height', __('Maximum thumbnail height of #3 px', 'yapb'), ''),
									new YapbCheckboxOption('yapb_display_images_xml_thumbnail_crop', __('Crop thumbnail to fill in the defined rectangle', 'yapb'), false)
								)
							)
						)
					),

					new YapbOptionGroup(
						__('RSS Enclosure', 'yapb'),
						__('You may optionally embed your images as <a href="http://en.wikipedia.org/wiki/RSS_enclosure" target="_blank">media enclosures</a> in RSS2 and ATOM feeds.', 'yapb'),
						array(
							new YapbCheckboxOption('yapb_display_images_xml_media_enclosure', __('<strong>Embed images as media enclosures.</strong>', 'yapb'), false),
							new YapbCheckboxOption('yapb_display_images_xml_media_enclosure_resized_activate', __('Embed only resized image', 'yapb'), false),
							new YapbOptionGroup(
								'',
								'',
								array(
									new YapbInputOption('yapb_display_images_xml_media_enclosure_resized_width', __('Maximum image width of #3 px', 'yapb'), '180'),
									new YapbInputOption('yapb_display_images_xml_media_enclosure_resized_height', __('Maximum image height of #3 px', 'yapb'), ''),
									new YapbCheckboxOption('yapb_display_images_xml_media_enclosure_resized_crop', __('Crop image to fill in the defined rectangle', 'yapb'), false)
								)
							)
						)
					),

					new YapbOptionGroup(
						__('Yahoo Media RSS', 'yapb'),
						__('You may optionally add the elements specified by the <a href="http://search.yahoo.com/mrss" target="_blank">Media RSS 1.1.2 specification</a> to your RSS2 Feeds.', 'yapb'),
						array(
							new YapbCheckboxOption('yapb_yahoo_media_rss_activate', __('<strong>Turn on yahoo media RSS2 enhancement in general.</strong>', 'yapb'), false),
							new YapbCheckboxOption('yapb_yahoo_media_rss_resized_activate', __('Embed only resized image', 'yapb'), false),
							new YapbOptionGroup(
								'',
								'',
								array(	
									new YapbInputOption('yapb_yahoo_media_rss_resized_width', __('Maximum image width of #3 px', 'yapb'), '180'),
									new YapbInputOption('yapb_yahoo_media_rss_resized_height', __('Maximum image height of #3 px', 'yapb'), ''),
									new YapbCheckboxOption('yapb_yahoo_media_rss_resized_crop', __('Crop image to fill in the defined rectangle', 'yapb'), false)
								)
							),
							new YapbCheckboxOption('yapb_yahoo_media_rss_thumbnail_activate', __('Include media:thumbnail', 'yapb'), false),
							new YapbOptionGroup(
								'',
								'',
								array(
									new YapbInputOption('yapb_yahoo_media_rss_thumbnail_width', __('Maximum thumbnail width of #3 px', 'yapb'), '60'),
									new YapbInputOption('yapb_yahoo_media_rss_thumbnail_height', __('Maximum thumbnail height of #3 px', 'yapb'), ''),
									new YapbCheckboxOption('yapb_yahoo_media_rss_thumbnail_crop', __('Crop thumbnail to fill in the defined rectangle', 'yapb'), false)
								)
							)
						)
					)
				
				)
			),
			
			new YapbOptionGroup(
				__('Social Media', 'yapb'), 
				__('Connect your images better into social media platforms', 'yapb'),
				array(

					new YapbOptionGroup(
						__('Facebook', 'yapb'),
						__('YAPB supports some Facebook integration improvements <a target="_blank" href="http://www.insidefacebook.com/2009/04/06/increase-your-sites-traffic-through-facebook-share/">as described in this post</a> for example.', 'yapb'),
						array(
							new YapbCheckboxOption('yapb_facebook_activate', __('<strong>Enable Facebook integration in general</strong>', 'yapb'), false),
							new YapbCheckboxOption('yapb_facebook_meta_postthumb_activate', __('Use YAPB image as Facebook Post-Thumbnail in single posts/pages', 'yapb'), true),
							new YapbCheckboxOption('yapb_facebook_meta_mediaimage_activate', __('Declare YAPB-posts as media type medium=image', 'yapb'), true),
						)
					)
				)
			),

			new YapbOptionGroup(
				__('Automatic Image Insertion', 'yapb'),
				__('Yapb does display uploaded images automatically on different sections of your site by default.<br/>That\'s just a help for first-time-users and evaluation purproses: To style your photoblog individually,<br/> turn off this option and have a look at <a target="_blank" href="http://johannes.jarolim.com/blog/wordpress/yet-another-photoblog/adapting-templates/">how to adapt themes manually</a>.', 'yapb'),
				array(

					new YapbOptionGroup(
						__('General', 'yapb'), 
						'',
						array(
							new YapbCheckboxOption('yapb_display_images_activate', '<strong>' . __('Activate automatic image rendering in general.', 'yapb') . '</strong>', true)
						)
					),

					new YapbOptionGroup(
						__('Home page', 'yapb'), 
						__('The homepage usually shows a number of previously published posts.<br />You probably want to show thumbnails only.', 'yapb'),
						array(
							new YapbCheckboxOption('yapb_display_images_home', __('<strong>Display images on HOME page listing.</strong>', 'yapb'), true),
							new YapbCheckboxInputOption('yapb_display_images_home_thumbnail', __('Display image as thumbnail with a width of #3 px', 'yapb'), true, '200'),
							new YapbCheckboxOption('yapb_display_images_home_link_activate', __('Enable image links:', 'yapb'), true),
							new YapbOptionGroup(
								__('Linking', 'yapb'),
								'',
								array(
									new YapbRadioOption('yapb_display_images_home_linktype', __('Link to actual post', 'yapb'), 'post', true),
									new YapbRadioOption('yapb_display_images_home_linktype', __('Link to original image', 'yapb'), 'image', false),
									new YapbOptionGroup(
										__('Link thumbnails to image'),
										'',
										array(
											new YapbCheckboxInputOption('yapb_display_images_home_linktype_image_rel', __('Add rel-attribute #15 to link', 'yapb'), false, 'lightbox'),									
											new YapbCheckboxInputOption('yapb_display_images_home_linktype_image_thumbnail', __('Link to thumbnail with a width of #3 px', 'yapb'), false, '600'),
										)
									),
									new YapbCheckboxSelectOption('yapb_display_images_home_target', __('Add link target with value #', 'yapb'), array(__('_self (Open link in same window/frame)','yapb') => '_self', __('_top (Open link in top window/frame)', 'yapb') => '_top', __('_blank (open link in new browser window/tab)','yapb') => '_blank'), true, '_self')
								)
							),
							new YapbInputOption('yapb_display_images_home_inline_style', __('Inline CSS-Style for image tag: #40', 'yapb'), ''),
							new YapbTextareaOption('yapb_display_images_home_html_before', __('Custom HTML before image tag', 'yapb'), '<div style="float:left;border:10px solid silver;margin-right:10px;margin-bottom:10px;">'),
							new YapbTextareaOption('yapb_display_images_home_html_after', __('Custom HTML after image tag', 'yapb'), '</div>')
						)
					),

					new YapbOptionGroup(
						__('Single Pages', 'yapb'),
						__('A single page shows a published post on its own.<br />You probably want to show the whole image -<br />But you can use thumbnailing here too, if you have design restrictions for example.', 'yapb'),
						array(
							new YapbCheckboxOption('yapb_display_images_single', __('<strong>Display images on SINGLE pages.</strong>', 'yapb'), true),
							new YapbCheckboxInputOption('yapb_display_images_single_thumbnail', __('Display image as thumbnail with a width of #3 px', 'yapb'), true, '460'),
							new YapbCheckboxOption('yapb_display_images_single_link_activate', __('Enable image link.', 'yapb'), true),
							new YapbOptionGroup(
								__('Linking', 'yapb'),
								'',
								array(
									new YapbRadioOption('yapb_display_images_single_linktype', __('Link to actual post', 'yapb'), 'post', true),
									new YapbRadioOption('yapb_display_images_single_linktype', __('Link to original image', 'yapb'), 'image', false),
									new YapbOptionGroup(
										__('Link thumbnails to image'),
										'',
										array(
											new YapbCheckboxInputOption('yapb_display_images_single_linktype_image_rel', __('Add rel-attribute #15 to link', 'yapb'), false, 'lightbox'),									
											new YapbCheckboxInputOption('yapb_display_images_single_linktype_image_thumbnail', __('Link to thumbnail with a width of #3 px', 'yapb'), false, '600'),
										)
									),
									new YapbCheckboxSelectOption('yapb_display_images_single_target', __('Add link target with value #', 'yapb'), array(__('_self (Open link in same window/frame)','yapb') => '_self', __('_top (Open link in top window/frame)', 'yapb') => '_top', __('_blank (open link in new browser window/tab)','yapb') => '_blank'), true, '_self')
								)
							),
							new YapbInputOption('yapb_display_images_single_inline_style', __('Inline CSS-Style for image tag: #40', 'yapb'), ''),
							new YapbTextareaOption('yapb_display_images_single_html_before', __('Custom HTML before image tag', 'yapb'), '<div style="margin-bottom:20px;">'),
							new YapbTextareaOption('yapb_display_images_single_html_after', __('Custom HTML after image tag', 'yapb'), '</div>')
						)
					),

					new YapbOptionGroup(
						__('Archive Pages', 'yapb'),
						__('Archive pages usually show an overview of all published posts in a category, date range, etc.<br />You probably want to use thumbnails here.', 'yapb'),
						array(
							new YapbCheckboxOption('yapb_display_images_archive', __('<strong>Display images on ARCHIVE overview page listings.</strong>', 'yapb'), true),
							new YapbCheckboxInputOption('yapb_display_images_archive_thumbnail', __('Display image as thumbnail with a width of #3 px', 'yapb'), true, '100'),							
							new YapbCheckboxOption('yapb_display_images_archive_link_activate', __('Enable image links.', 'yapb'), true),
							new YapbOptionGroup(
								__('Linking', 'yapb'),
								'',
								array(
									new YapbRadioOption('yapb_display_images_archive_linktype', __('Link to actual post', 'yapb'), 'post', true),
									new YapbRadioOption('yapb_display_images_archive_linktype', __('Link to original image', 'yapb'), 'image', false),
									new YapbOptionGroup(
										__('Link thumbnails to image'),
										'',
										array(
											new YapbCheckboxInputOption('yapb_display_images_archive_linktype_image_rel', __('Add rel-attribute #15 to link', 'yapb'), false, 'lightbox'),									
											new YapbCheckboxInputOption('yapb_display_images_archive_linktype_image_thumbnail', __('Link to thumbnail with a width of #3 px', 'yapb'), false, '600'),
										)
									),
									new YapbCheckboxSelectOption('yapb_display_images_archive_target', __('Add link target with value #', 'yapb'), array(__('_self (Open link in same window/frame)','yapb') => '_self', __('_top (Open link in top window/frame)', 'yapb') => '_top', __('_blank (open link in new browser window/tab)','yapb') => '_blank'), true, '_self')
								)
							),
							new YapbInputOption('yapb_display_images_archive_inline_style', __('Inline CSS-Style for image tag: #40', 'yapb'), ''),
							new YapbTextareaOption('yapb_display_images_archive_html_before', __('Custom HTML before image tag', 'yapb'), '<div style="float:left;border:10px solid silver;margin-right:10px;margin-bottom:10px;">'),
							new YapbTextareaOption('yapb_display_images_archive_html_after', __('Custom HTML after image tag', 'yapb'), '</div>')
						)
					),

					new YapbOptionGroup(
						__('Content Pages', 'yapb'),
						__('You may post images to your content pages if you activate the according option above.<br />On content pages you probably want to show the original image.', 'yapb'),
						array(
							new YapbCheckboxOption('yapb_display_images_page', __('<strong>Display images on CONTENT pages.</strong>', 'yapb'), true),
							new YapbCheckboxInputOption('yapb_display_images_page_thumbnail', __('Display image as thumbnail with a width of #3 px', 'yapb'), false, '100'),
							new YapbCheckboxOption('yapb_display_images_page_link_activate', __('Enable image link.', 'yapb'), true),
							new YapbOptionGroup(
								__('Linking', 'yapb'),
								'',
								array(
									new YapbRadioOption('yapb_display_images_page_linktype', __('Link to actual post', 'yapb'), 'post', true),
									new YapbRadioOption('yapb_display_images_page_linktype', __('Link to original image', 'yapb'), 'image', false),
									new YapbOptionGroup(
										__('Link thumbnails to image'),
										'',
										array(
											new YapbCheckboxInputOption('yapb_display_images_page_linktype_image_rel', __('Add rel-attribute #15 to link', 'yapb'), false, 'lightbox'),									
											new YapbCheckboxInputOption('yapb_display_images_page_linktype_image_thumbnail', __('Link to thumbnail with a width of #3 px', 'yapb'), false, '600'),
										)
									),
									new YapbCheckboxSelectOption('yapb_display_images_page_target', __('Add link target with value #', 'yapb'), array(__('_self (Open link in same window/frame)','yapb') => '_self', __('_top (Open link in top window/frame)', 'yapb') => '_top', __('_blank (open link in new browser window/tab)','yapb') => '_blank'), true, '_self')
								)
							),
							new YapbInputOption('yapb_display_images_page_inline_style', __('Inline CSS-Style for image tag: #40', 'yapb'), ''),
							new YapbTextareaOption('yapb_display_images_page_html_before', __('Custom HTML before image tag', 'yapb'), '<div style="float:left;border:10px solid silver;margin-right:10px;margin-bottom:10px;">'),
							new YapbTextareaOption('yapb_display_images_page_html_after', __('Custom HTML after image tag', 'yapb'), '</div>')
						)
					)

				)
			)

		)
	);

	// Run YAPB Options filter

	$this->options = apply_filters('yapb_options', $this->options);


?>