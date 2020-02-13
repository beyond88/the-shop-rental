<?php 
	if( !defined( 'ABSPATH' ) ){
	    exit;
    }
    
    $qoutes_email 			  	= get_post_meta( $post->ID, 'qoutes_email', true );
    $qoutes_mobile 			  	= get_post_meta( $post->ID, 'qoutes_mobile', true );
    $qoutes_company_name 	    = get_post_meta( $post->ID, 'qoutes_company_name', true );
    $qoutes_city 			  	= get_post_meta( $post->ID, 'qoutes_city', true );
    $qoutes_date 			  	= get_post_meta( $post->ID, 'qoutes_date', true );
	$qoutes_day 			  	= get_post_meta( $post->ID, 'qoutes_day', true );
	$qoutes_data 			  	= get_post_meta( $post->ID, 'qoutes_data', true );

?>

<div class="wrap">
	<table class="form-table">

        <tr valign="top">
			<th scope="row">
				<label for="qoutes_email"><?php esc_html_e('Email Address', 'the-shop-rental'); ?></label>
			</th>
			<td style="vertical-align: middle;">
				<input type="email" name="qoutes_email" readonly value="<?php if( $qoutes_email !='' ){ echo esc_attr($qoutes_email); }?>">
			</td>
		</tr>

        <tr valign="top">
			<th scope="row">
				<label for="qoutes_mobile"><?php esc_html_e('Phone', 'the-shop-rental'); ?></label>
			</th>
			<td style="vertical-align: middle;">
				<input type="text" name="qoutes_mobile" readonly value="<?php if( $qoutes_mobile !='' ){ echo esc_attr($qoutes_mobile); }?>">
			</td>
		</tr>

        <tr valign="top">
			<th scope="row">
				<label for="qoutes_company_name"><?php esc_html_e('Company Name', 'the-shop-rental'); ?></label>
			</th>
			<td style="vertical-align: middle;">
				<input type="text" readonly name="qoutes_company_name" readonly value="<?php if( $qoutes_company_name !='' ){ echo esc_attr($qoutes_company_name); }?>">
			</td>
		</tr>

        <tr valign="top">
			<th scope="row">
				<label for="qoutes_city"><?php esc_html_e('City', 'the-shop-rental'); ?></label>
			</th>
			<td style="vertical-align: middle;">
				<input type="text" name="qoutes_city" readonly value="<?php if( $qoutes_city !='' ){ echo esc_attr($qoutes_city); }?>">
			</td>
		</tr>    

        <tr valign="top">
			<th scope="row">
				<label for="qoutes_date"><?php esc_html_e('Rental Date', 'the-shop-rental'); ?></label>
			</th>
			<td style="vertical-align: middle;">
				<input type="text" name="qoutes_date" readonly value="<?php if( $qoutes_date !='' ){ echo esc_attr($qoutes_date); }?>">
			</td>
		</tr> 

        <tr valign="top">
			<th scope="row">
				<label for="qoutes_day"><?php esc_html_e('Day(s)', 'the-shop-rental'); ?></label>
			</th>
			<td style="vertical-align: middle;">
				<input type="text" name="qoutes_day" readonly value="<?php if( $qoutes_day !='' ){ echo esc_attr($qoutes_day); }?>">
			</td>
		</tr>
		
		<tr valign="top">
			<th scope="row">
				<label for="qoutes_day"><?php esc_html_e('Requested Rental Item(s)', 'the-shop-rental'); ?></label>
			</th>
			<td style="vertical-align: middle;">
				<textarea readonly rows=10 cols=50>
					<?php echo $qoutes_data; ?>
				</textarea>
			</td>
		</tr>		
	</table>
</div>