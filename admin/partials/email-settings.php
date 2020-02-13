<div class="area">
    <h3><?php esc_html_e( 'Email - Settings', 'the-shop-rental'); ?></h3>
    <?php 
        if( isset($_POST['save_email_settings'])){
            
            $store_email_info = array();
            $arr_inputs = array('email_subject', 'email_message');
            foreach( $_POST as $key => $value ) {
                if( in_array( $key, $arr_inputs) )
                $store_email_info[$key] = $value;
            }
    
            update_option('email_settings', $store_email_info);
            
        }
        
        $email_info = get_option('email_settings');
    ?>
<form method="post" id="mainform" action="" style="float: left;">

   <h4>Email Content</h4>   
   <table class="form-table">
      <tbody>
         <tr valign="top">
            <th scope="row" class="titledesc" style="padding:5px 10px 5px 0">
               <label for="email_subject"><?php esc_html_e( 'Subject:', 'the-shop-rental'); ?></label>
            </th>
            <td class="forminp forminp-text" style="padding: 5px 10px;">
               <input name="email_subject" type="text" class="regular-text" value="<?php if( !empty($email_info['email_subject']) && array_key_exists("email_subject",$email_info) ){ echo $email_info['email_subject']; }?>" placeholder=""> 							
               <div class="vhelp-text"></div>
            </td>
         </tr>
         <tr valign="top">
            <th scope="row" class="titledesc" style="padding:5px 10px 5px 0">
               <label for="email_message"><?php esc_html_e( 'Message:', 'the-shop-rental'); ?></label>
            </th>
            <td class="forminp forminp-text" style="padding: 5px 10px;">
               <textarea name="email_message" id="email_message" style="height:200px;" class="regular-text" ><?php if( !empty($email_info['email_message']) && array_key_exists("email_message",$email_info) ){ echo $email_info['email_message']; }?></textarea>							
            </td>
         </tr>
      </tbody>
   </table>
   <p class="submit">
      <button name="save_email_settings" class="button-primary" type="submit" value="Save changes"><?php esc_html_e( 'Save changes', 'the-shop-rental'); ?></button>
   </p>
</form>


</div>