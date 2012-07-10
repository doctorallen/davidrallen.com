<?php while( have_posts() ) : the_post(); ?>
				<div <?php post_class(); ?>>
					<div class="date">
						<p><?php the_time('d'); ?> <span><?php the_time('M'); ?> </span></p>
					</div>
					<div class="post-content">
						<h2><a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h2>
						<?php the_content(''); ?>

						<ul class="post-meta">
							<li>Posted in <?php the_category(', '); ?> </li>
							<li><a href="<?php the_permalink(); ?>#comments"><?php comments_number('No Comments','1 Comment','% Comments'); ?></a><li>
							<li class="read-more"><a href="<?php the_permalink(); ?>">Read More</a></li>
						</ul>
					</div>
			<?php endwhile; ?>

			<div class="pagination">
				<p class="older"><?php next_posts_link('Older posts'); ?></p>
				<p class="newer"><?php previous_posts_link('Newer posts'); ?></p>
			</div>
			
		<?php else : ?>

		<div class="post">
			<h2>Nothing Found</h2>
				<p>Sorry.</p>
				<p><a href="<?php echo get_option('home'); ?>">Return to the homepage</a></p>
		</div>
		<?php endif; ?>
