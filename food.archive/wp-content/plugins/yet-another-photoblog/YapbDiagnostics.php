<?php

	require_once realpath(dirname(__file__) . '/lib/includes/YapbConstants.script.php');
	require_once realpath(dirname(__file__) . '/lib/Yapb.class.php');

	// Instance Yapb

	$yapb = new Yapb();

	/**
	 * Function checks existance, read- and writeability of a given directory
	 * 
	 * @param string $path Absolute systempath of the directory
	 **/
	function checkDirectory($path) {
		// Check if this path represents a directory
		if (is_dir($path)) {
			// Check if this directory is readable
			if (is_readable($path)) {
				// Check if this directory is writeable
				if (is_writable($path)) {
					// If we have an *nix system - Check if the directory is executable
					if ((YAPB_EXECUTING_OS == 'NIX') && function_exists('is_executable')) {
						if (is_executable($path)) {
							echo '<span class="ok"><strong>OK</strong> (*nix)</span>';
						} else {
							echo '<span class="warn"><strong>Not executable!</strong> Please set directory permission of ' . $path . ' to <strong>777</strong>.</span>';
						}
					} else {
						echo '<span class="ok"><strong>OK</strong> (Windows)</span>';
					}
				} else {
					echo '<span class="warn"><strong>Not writable!</span> Please set directory permission of ' . $path . ' to <strong>777</strong>.</span>';
				}
			} else {
				echo '<span class="warn"><strong>Not readable!</strong> Please set directory permission of ' . $path . ' to <strong>777</strong>.</span>';
			}
		} else {
			echo '<span class="warn"><strong>Not existant!</strong> Please create directory ' . $path . '</span>';
		}
	}


	/**
	 * Function compares current WordPress version string against YAPB requirements
	 *
	 * @param string $installedWordPressVersion
	 **/
	function checkWpVersion($installedWordPressVersion) {

		global $yapb;
		$works = false;

		if ($installedWordPressVersion == $yapb->requiredWordPressVersion) {

			// Same Version Strings
			$works = true;

		} else {

			// Version strings do not equal
			// Split the tokens for an 1:1 comparison

			$version = explode('.', $installedWordPressVersion);
			$required = explode('.', $yapb->requiredWordPressVersion);

			// Equalize token length

			if (count($version) < count($required)) {
				$version = array_pad($version, count($required), '0');
			}

			if (count($required) < count($version)) {
				$required = array_pad($required, count($version), '0');
			}

			// 1:1 comparsion of each an every token

			for ($i=0, $len=count($required); $i<$len; $i++) {

				// if the version is bigger than required:
				// everything is ok: we quit with positive result

				if ($version[$i] > $required[$i]) {
					$works = true;
					break;
				}

				// if the version is smaller than required:
				// we quit with an negative result

				if ($version[$i] < $required[$i]) {
					$works = false;
					break;
				}

				// if the result is equal we cycle to the next
				// iteration or quit with positive result if
				// this is the last iteration

				if (($i == $len-1) && $version[$i] == $required[$i]) {
					// Absolute Gleichheit
					$works = true;
					break;
				}

			}

		}

		// Output

		if ($works) {
			echo '<span class="ok"><strong>OK</strong> (' . $installedWordPressVersion . ')</span>';
		} else {
			echo '<span class="warn"><strong>' . $installedWordPressVersion . '</strong> (YAPB ' . $yapb->pluginVersion . ' requires WordPress ' . $yapb->requiredWordPressVersion . ' or higher)</span>';
		}

	}

	/**
	 * Templating function
	 *
	 * @param string $name
	 * @param string $value
	 */
	function the_value($name, $value) {
		if (empty($value)) $value = '-';
		echo '<tr><td>' . $name . '</td><td>' . $value . '</td></tr>';
	}


?>
<html>
<head>
	<title>YAPB Diagnostics</title>
	<style type="text/css">

		body {
			background-color:white; 
			padding:1em;
		}

		h1 { color:#0066CC; margin:0;}
		h2 { color:#000000; }
		h3 { color:#666666; }

		tr.alternate {
			background-color:#efefef;
		}

		th {
			text-align:left;
			padding:0.4em;
			background-color:#e1e1e1;
			border-left:1px solid gray;
			border-bottom:1px solid gray;
		}

		td {
			padding:0.4em;
			border-left:1px solid gray;
			vertical-align:top;
		}

		p { color:#0066CC; margin:0; }

		a {
			color:#0066cc;
			text-decoration:none;
			border-bottom:1px dashed #0066cc;
		}

		a:hover {
			color:#000000;
			border-bottom-color:#000000;
		}

		.ok {
			padding:0 0.3em 0 0.3em;
			background-color:green;
			color:white;
		}

		.warn {
			padding:0 0.3em 0 0.3em;
			background-color:red;
			color:white;
		}

	</style>
</head>
<body>
	
	<h1>YAPB Diagnostics</h1>
	<p>This information may help you getting YAPB to work.</p>

	<h2>Version Information</h2>
	<ul>
		<li>YAPB Version: <strong><?php echo $yapb->pluginVersion ?></strong></li>
		<li>WordPress version: <strong><?php echo get_bloginfo('version') ?></strong></li>
		<li>WordPress version tested up to: <strong><?php echo $yapb->highestTestedWordPressVersion ?></strong></li>
		<li>WordPress version required at least: <strong><?php echo $yapb->requiredWordPressVersion ?></strong></li>
	</ul>

	<h2>Automatic Diagnostics</h2>

	<ol>
		<li>WordPress Version: <?php checkWpVersion(get_bloginfo('version')) ?></li>
		<li>WordPress Upload Base Directory: 
			<?php 
				$wp_upload_dir = wp_upload_dir(); 
				checkDirectory($wp_upload_dir['basedir']);
			?>
		</li>
		<li>
			YAPB Cache Directory: <?php checkDirectory(YAPB_CACHE_ROOT_DIR) ?>
		</li>
	</ol>

	<h1>Debugging Information</h1>
	<p>
		This information (if given) will help me, getting your YAPB to work -<br/>
		Every server configuration is unique and special ;-)
	</p>

	<h2>PHP / Webserver</h2>
	<table border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th>Key</th>
				<th>Value</th>
			</tr>
		</thead>
		<tbody>
			<?php the_value('realpath(__file__)', realpath(__file__)); ?>
			<?php the_value('HTTP_HOST', $_SERVER['HTTP_HOST']); ?>
			<?php the_value('SERVER_ADDR', $_SERVER['SERVER_ADDR']); ?>
			<?php the_value('SERVER_PORT', $_SERVER['SERVER_PORT']); ?>
			<?php the_value('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']); ?>
			<?php the_value('SCRIPT_FILENAME', $_SERVER['SCRIPT_FILENAME']); ?>
			<?php the_value('REQUEST_URI', $_SERVER['REQUEST_URI']); ?>
			<?php the_value('SCRIPT_NAME', $_SERVER['SCRIPT_NAME']); ?>
			<?php the_value('PHP upload_max_filesize', ini_get('upload_max_filesize')); ?>
			<?php the_value('PHP post_max_size', ini_get('post_max_size')); ?>
			<?php the_value('PHP memory_limit', (function_exists('memory_get_usage') ? ini_get('memory_limit') : 'no memory limit detected')); ?>
		</tbody>
	</table>

	<h2>WordPress</h2>
	<h3>Options</h3>
	<table border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th>Key</th>
				<th>Value</th>
			</tr>
		</thead>
		<tbody>
			<?php the_value('blogname', get_option('blogname')); ?>
			<?php the_value('siteurl', get_option('siteurl')); ?>
			<?php the_value('home', get_option('home')); ?>
			<?php the_value('upload_path', get_option('upload_path')); ?>
			<?php the_value('upload_url_path', get_option('upload_url_path')); ?>
			<?php the_value('uploads_use_yearmonth_folders', get_option('uploads_use_yearmonth_folders')); ?>
		</tbody>
	</table>

	<h3>Internal</h3>
	<table border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th>Info</th>
				<th>Value</th>
			</tr>
		</thead>
		<tbody>
			<?php the_value('get_bloginfo(\'version\')', get_bloginfo('version')); ?>
			<tr>
				<td>wp_upload_dir()</td>
				<td><pre><?php print_r($wp_upload_dir) ?></pre></td>
			</tr>

		</tbody>
	</table>

	<h3>Constants</h3>
	<table border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th>Name</th>
				<th>Value</th>
			</tr>
		</thead>
		<tbody>
			<?php the_value('ABSPATH', ABSPATH); ?>
			<?php the_value('UPLOADS', UPLOADS); ?>
			<?php the_value('WP_CONTENT_DIR', WP_CONTENT_DIR); ?>
			<?php the_value('WP_CONTENT_URL', WP_CONTENT_URL); ?>
			<?php the_value('WP_MEMORY_LIMIT', WP_MEMORY_LIMIT); ?>
			<?php the_value('WPLANG', WPLANG); ?>
			<?php the_value('WP_LANG_DIR', WP_LANG_DIR); ?>
			<?php the_value('WPINC', WPINC); ?>
			<?php the_value('WP_PLUGIN_DIR', WP_PLUGIN_DIR); ?>
			<?php the_value('WP_PLUGIN_URL', WP_PLUGIN_URL); ?>
			<?php the_value('WP_POST_REVISIONS', WP_POST_REVISIONS); ?>
		</tbody>
	</table>
	

	<h2>YAPB</h2>
	<h3>Constants</h3>
	<table border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th>Global Name</th>
				<th>Value</th>
			</tr>
		</thead>
		<tbody>

			<?php the_value('YAPB_EXECUTING_OS', YAPB_EXECUTING_OS); ?>
			<?php the_value('YAPB_SYSTEM_SEPARATOR', YAPB_SYSTEM_SEPARATOR); ?>
			<?php the_value('YAPB_PLUGINDIR_NAME', YAPB_PLUGINDIR_NAME); ?>
			<?php the_value('YAPB_WP_ROOT_DIR', YAPB_WP_ROOT_DIR); ?>
			<?php the_value('YAPB_PLUGINDIR', YAPB_PLUGINDIR); ?>
			<?php the_value('YAPB_PHPTHUMB_DIR', YAPB_PHPTHUMB_DIR); ?>

			<?php the_value('YAPB_CACHE_DIR_NAME', YAPB_CACHE_DIR_NAME); ?>
			<?php the_value('YAPB_CACHE_ROOT_DIR_PARENT', YAPB_CACHE_ROOT_DIR_PARENT); ?>
			<?php the_value('YAPB_CACHE_ROOT_DIR', YAPB_CACHE_ROOT_DIR); ?>

			<?php the_value('YAPB_TABLE_NAME', YAPB_TABLE_NAME); ?>
			<?php the_value('YAPB_PLUGIN_PATH', YAPB_PLUGIN_PATH); ?>
			<?php the_value('YAPB_TPL_PATH', YAPB_TPL_PATH); ?>

		</tbody>
	</table>

	<h3>Latest 10 YAPB images</h3>

	<table border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th>id</th>
				<th>post_id</th>
				<th>URI</th>
				<th>YapbImage::systemFilePath(URI)</th>
				<th>post guid</th>
			</tr>
		</thead>
		<tbody>
			<?php

				global $wpdb;
				$query = 'SELECT 
						i.id AS image_id, 
						p.ID AS post_id, 
						i.URI as image_uri, 
						p.guid as post_guid 
					FROM ' . YAPB_TABLE_NAME . ' i 
						LEFT JOIN ' . $wpdb->posts . ' p 
						ON i.post_id = p.ID 
					ORDER BY i.id DESC 
					LIMIT 0,10';

				$latest_images = $wpdb->get_results($query);

			?>
			<?php foreach ($latest_images as $entry): $i++; ?>
				<?php if ($i % 2 == 1): ?><tr><?php else: ?><tr class="alternate"><?php endif ?>
					<td><?php echo $entry->image_id ?></td>
					<td><?php echo $entry->post_id ?></td>
					<td><?php echo $entry->image_uri ?></td>
					<td><?php echo YapbImage::systemFilePath($entry->image_uri) ?></td>
					<td><a href="<?php echo $entry->post_guid ?>"><?php echo $entry->post_guid ?></a></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

</body>
</html>