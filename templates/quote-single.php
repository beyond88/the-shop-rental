<?php

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

get_header(); ?>

<section id="main" class="clearfix">

	<?php
	while ( have_posts() ) : the_post();

    $qoutes_email    		= esc_attr(get_post_meta(get_the_ID(),'qoutes_email',true));
    $qoutes_mobile    		= esc_attr(get_post_meta(get_the_ID(),'qoutes_mobile',true));
    $qoutes_company_name 	= esc_attr(get_post_meta(get_the_ID(),'qoutes_company_name',true));
    $qoutes_city    		= esc_attr(get_post_meta(get_the_ID(),'qoutes_city',true));
    $qoutes_date    		= esc_attr(get_post_meta(get_the_ID(),'qoutes_date',true));
    $qoutes_day    			= esc_attr(get_post_meta(get_the_ID(),'qoutes_day',true));
    $qoutes_data 			= esc_attr(get_post_meta(get_the_ID(),'qoutes_data',true)); ?>
	
	<div class="quote-details-wrap">
		<div class="container" >
			<div class="row">
				<div class="col-sm-3 quote-info-sidebar">
				 	<div class="details-wrapper">
				 		<h3 class="title"><?php esc_html_e('Quote Information', 'quote-rental');?></h3>
				 		<ul class="list-style-none list-inline">
						 	<li><span>Name: </span><?php echo get_the_title(); ?></li>
						 	<li><span>Email: </span><?php echo $qoutes_email; ?></li>
				 			<li><span>Email: </span><?php echo $qoutes_email; ?></li>
				 			<li><span>Mobile: </span><?php echo $qoutes_mobile; ?></li>
				 			<li><span>Company Name: </span><?php echo $qoutes_company_name; ?></li>
				 			<li><span>City: </span><?php echo $qoutes_city; ?></li>
				 			<li><span>Date: </span><?php echo $qoutes_date; ?></li>
				 			<li><span>Day: </span><?php echo $qoutes_day; ?></li>
				 			<li><span>Items: </span><?php echo $qoutes_data; ?></li>
				 		</ul>						
				 	</div> <!--//details-wrapper -->
				</div> 

				<div class="col-sm-9 quote-info-warpper">
					<div class="quote-details">
						<div class="header-title">
							<h3 class="title"><?php esc_html_e('Quote Details', 'quote-rental');?></h3>
						</div>
						<div class="quote-details-text">
							<?php the_content(); ?>							
						</div>
					</div> 
				</div>
			</div>
		</div>
	</div>

	<?php endwhile; ?>

</section>

<?php get_footer();