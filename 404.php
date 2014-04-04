<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

					<div id="main" class="eightcol first clearfix" role="main">

						<article id="post-not-found" class="hentry clearfix">

							<header class="article-header">

								<h1><?php _e( '404 - Page Not Found', 'benchtheme' ); ?></h1>

							</header>

							<section class="entry-content">

								<p><?php _e( 'The page you were looking for was not found, but maybe try looking again!', 'benchtheme' ); ?></p>

							</section>

							<section class="search">

									<p><?php get_search_form(); ?></p>

							</section>
						

						</article>

					</div>

				</div>

			</div>

<?php get_footer(); ?>
