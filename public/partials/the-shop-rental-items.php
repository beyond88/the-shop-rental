<div class="container">
    <div class="col-xs-12 col-sm-6 col-md-4 float-right-left text-xs-right complate-quote">
        <?php 
            $cart_count = 0;
            $hide       = "hide";
            $page_url   = get_option( 'the_rent_checkout' ) ? get_permalink( get_option( 'the_rent_checkout' ) ) : 0;
            if( isset($_COOKIE['shopping_cart']) ){
                $cookie_data    = stripslashes($_COOKIE['shopping_cart']);
                $cart_data      = json_decode($cookie_data, true);
                $cart_count     = count( $cart_data );
                if( $cart_count > 0 ){
                    $hide           = "";
                }                    
            }                     
        ?>   
        <a href="<?php echo esc_url( $page_url ); ?>" class="view-quotes <?php echo $hide; ?>">
            <span class="quote-text">
            <?php esc_html_e( 'Quote', 'the-shop-rental' ); ?></span>
            <span class="quote-count">
                (<span><?php echo $cart_count; ?></span>)
            </span>
        </a>

        <div class="grid-wrap">
            <ul class="tabs">
                <li><a class="grid" href="#tab-grid"><i class="fa fa-th-large fa-lg"></i></a></li>
                <li><a class="list" href="#tab-list"><i class="fa fa-th-list fa-lg"></i></a></li>
            </ul>
        </div>
        

    </div>
</div>

<?php 
    function search_cookie($id){
        $cookie_data    = stripslashes($_COOKIE['shopping_cart']);
        $cart_data      = json_decode($cookie_data, true);
        foreach($cart_data as $keys => $values)
        {
            if( $values["item_id"] == $id ){
                return $id; 
            }   
        }
    }
?>



<div class="container">
    <div class="col-xs-12 ri-wrapper items-wrapper">
        <?php 

        $rental_tax = array( 
            'taxonomy'      => 'rental_category', 
            'hide_empty'    => true,
            'order'         => 'ASC'
        );

        $taxonomy_terms     = get_terms( $rental_tax ); ?>

        <div class="dropdown"> 
            <select id="catselector">
                <option value=""><?php esc_html_e( 'All Categories', 'the-shop-rental' ); ?></option>
                <?php foreach ($taxonomy_terms as $filter) { ?>
                    <option value="<?php echo $filter->slug; ?>"><?php echo $filter->name; ?></option>
                <?php } ?>
            </select>
        </div>


        <div id="tab-grid" class="panel">
            <div class="category-grid-view">
                <?php foreach ( $taxonomy_terms as $taxonomy_term ) { ?>
                    <div id="<?php echo $taxonomy_term->slug; ?>" class="cat-list">
                        
                        <div class="rental-section ">
                            <div class="rental-items" id="category" data-categoryid="<?php echo $taxonomy_term->term_id; ?>" data-categoryname="<?php echo $taxonomy_term->name; ?>">                
                                <?php 
                                    $term_id = $taxonomy_term->term_id;                                
                                    $query = new WP_Query(
                                    array( 
                                        'post_type' => 'the-shop-rental',
                                        'tax_query' => array(
                                            array(
                                                'taxonomy'  => 'rental_category',
                                                'terms'     => $term_id,
                                                'field'     => 'term_id',
                                            )
                                        ),
                                        'orderby'   => 'title',
                                        'order'     => 'ASC' 
                                    )
                                ); 

                                if ( $query->have_posts()) :  
                                    while ($query->have_posts() ) : $query->the_post(); ?>

                                        <?php 
                                            $id         = 0;
                                            $show_hide  = "hide";
                                            if( isset($_COOKIE['shopping_cart']) ){
                                                if( search_cookie(get_the_ID()) == get_the_ID() ){
                                                    $show_hide = ""; 
                                                    $id = get_the_ID(); 
                                                } 
                                            }
                                        ?>
                                    
                                    <div class="col-md-3">
                                        <div class="rental-item">
                                            <?php if ( has_post_thumbnail()): ?>        
                                            <div class="rental-img text-xs-center">
                                                <?php $get_image = esc_url( wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ) );  ?>
                                                <?php the_post_thumbnail('rental_size_img');  ?>

                                                <div class="col-xs-12 item-name">
                                                    <h3 class="text-xs-center"><?php the_title(); ?></h3>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <div class="rental-desc">
                                                <a class="quick-view" href="#" data-featherlight="#feather-<?php echo get_the_ID() ?>">Quick view</a>
                                                
                                                <div class="col-xs-12 item-specs"></div>
                                                <div class="col-xs-12 add-quote">
                                                    <button class="btn btn-secondary btn-add-quote" data-id="<?php echo get_the_ID(); ?>" data-name="<?php the_title(); ?>" data-category="<?php echo $taxonomy_term->name; ?>">
                                                        <?php esc_html_e( 'Add to quote', 'the-shop-rental' ); ?>
                                                    </button>


                                                    <div class="remove-quote-cnt text-xs-center <?php echo $show_hide; ?>">
                                                        <a href="#" class="text-danger remove-quote" data-id="<?php echo $id; ?>">             
                                                            <?php esc_html_e( 'Remove', 'the-shop-rental' ); ?>
                                                            <i class="fa fa-times-circle" style="padding: 0px 3px;"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>   

                                    <!-- Modal Popup -->
                                    <div class="lightbox ajaxcontent featherlight-inner" id="feather-<?php echo get_the_ID() ?>">
                                        <div id="<?php echo get_the_ID() ?>">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-12 popup-wrap">
                                                        <h1 class="block-title"><?php the_title(); ?></h1>
                                                        <div class="item-content"><?php the_content(); ?></div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End -->

                                <?php
                                    endwhile;       
                                    endif; 
                                ?>
                            </div>                 
                        </div>  
                    </div>
                <?php } ?>
            </div>
        </div>


        <!-- List View -->
        <div id="tab-list" class="panel">
            <div class="category-listing-view">
                <?php foreach ( $taxonomy_terms as $taxonomy_term ) { ?>
                    <div id="<?php echo $taxonomy_term->slug; ?>" class="cat-list">
                        
                        <div class="rental-section ">
                            <div class="rental-items" id="category" data-categoryid="<?php echo $taxonomy_term->term_id; ?>" data-categoryname="<?php echo $taxonomy_term->name; ?>">                
                                <?php 
                                    $term_id = $taxonomy_term->term_id;                                
                                    $query = new WP_Query(
                                    array( 
                                        'post_type' => 'the-shop-rental',
                                        'tax_query' => array(
                                            array(
                                                'taxonomy'  => 'rental_category',
                                                'terms'     => $term_id,
                                                'field'     => 'term_id',
                                            )
                                        ),
                                        'orderby'   => 'title',
                                        'order'     => 'ASC' 
                                    )
                                ); 

                                if ( $query->have_posts()) :  
                                    while ($query->have_posts() ) : $query->the_post(); ?>

                                        <?php 
                                            $id         = 0;
                                            $show_hide  = "hide";
                                            if( isset($_COOKIE['shopping_cart']) ){
                                                if( search_cookie(get_the_ID()) == get_the_ID() ){
                                                    $show_hide = ""; 
                                                    $id = get_the_ID(); 
                                                } 
                                            }
                                        ?>
                                    
                                    <div class="col-md-12">
                                        <div class="rental-item">
                                            <?php if ( has_post_thumbnail()): ?>        
                                                <div class="rental-img">
                                                    <?php $get_image = esc_url( wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ) );  ?>
                                                    <?php the_post_thumbnail('rental_size_img');  ?>
                                                </div>
                                            <?php endif; ?>

                                            <div class="rental-desc">

                                                <div class="col-xs-12 item-name">
                                                    <h3 class="text-xs-center"><?php the_title(); ?></h3>
                                                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal</p>
                                                
                                                    
                                                    <div class="col-xs-12 add-quote">

                                                        <a class="quick-view" href="#" data-featherlight="#feather-<?php echo get_the_ID() ?>">Quick view</a>

                                                        <button class="btn btn-secondary btn-add-quote" data-id="<?php echo get_the_ID(); ?>" data-name="<?php the_title(); ?>" data-category="<?php echo $taxonomy_term->name; ?>">
                                                            <?php esc_html_e( 'Add to quote', 'the-shop-rental' ); ?>
                                                        </button>

                                                        <div class="remove-quote-cnt text-xs-center <?php echo $show_hide; ?>">
                                                            <a href="#" class="text-danger remove-quote" data-id="<?php echo $id; ?>">             
                                                                <?php esc_html_e( 'Remove', 'the-shop-rental' ); ?>
                                                                <i class="fa fa-times-circle" style="padding: 0px 3px;"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>   

                                    <!-- Modal Popup -->
                                    <div class="lightbox ajaxcontent featherlight-inner" id="feather-<?php echo get_the_ID() ?>">
                                        <div id="<?php echo get_the_ID() ?>">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-12 popup-wrap">
                                                        <h1 class="block-title"><?php the_title(); ?></h1>
                                                        <div class="item-content"><?php the_content(); ?></div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End -->

                                <?php
                                    endwhile;       
                                    endif; 
                                ?>
                            </div>                 
                        </div>  



                    </div>
                <?php } ?>
            </div>
        </div>


    </div>
</div>