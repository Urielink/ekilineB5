<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 */

?>

<article class="border rounded p-2 mb-2 media">

	<?php the_post_thumbnail( 'thumbnail' , ['class'=>'mr-3'] ); ?>

	<div class="media-body">

		<?php the_title( '<h2 class="entry-title mb-0"><a href="' . get_the_permalink() . '" title="' . get_the_title() . '">', '</a></h2>' ); ?>

		<?php the_excerpt(); ?>

	</div>

</article><!-- #post-## -->
