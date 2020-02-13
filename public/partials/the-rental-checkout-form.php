<?php 
    $string ='';
    
    $string .='<div class="container">';
    $string .='<form class="quote-form" id="quote_form" data-parsley-validate="" novalidate="">';
    $string .='<div class="col-xs-12 px-0">';
    $string .='<div class="col-xs-12 px-0">';
    $string .='<h3 class="section-title">Review Your Quote</h3>';
    $string .='</div>';
    $string .='<div class="col-xs-12 col-sm-6 px-0 float-right-left col-1">';

    $string .='<div class="col-xs-12">';
    $string .='<h3 class="sec-title">Billing Details</h3>';
    $string .='</div>';

    $string .='<div class="col-xs-12 col-sm-10">';

    $string .='<div class="form-group">';
    $string .='<label for="exampleInputEmail1">Full name</label>';
    $string .='<input type="text" class="form-control" id="fullname" required="" data-parsley-required-message="Please fill out this field" aria-describedby="emailHelp">';
    $string .='</div>';

    $string .='<div class="form-group">';
    $string .='<label for="exampleInputEmail1">Phone</label>';
    $string .='<input type="text" class="form-control input-number" id="phone" required="" data-parsley-required-message="Please fill out this field" aria-describedby="emailHelp">';
    $string .='</div>';

    $string .='<div class="form-group">';
    $string .='<label for="exampleInputEmail1">Email Address</label>';
    $string .='<input type="email" class="form-control" id="email" required="" data-parsley-required-message="Please fill out this field" aria-describedby="emailHelp">';
    $string .='</div>';

    $string .='<div class="form-group">';
    $string .='<label for="exampleInputEmail1">Company Name</label>';
    $string .='<input type="text" class="form-control" id="cmpname" aria-describedby="emailHelp">';
    $string .='</div>';

    $string .='<div class="form-group">';
    $string .='<label for="exampleInputEmail1">City</label>';
    $string .='<select class="form-control select2" id="city" required="" data-parsley-required-message="Please fill out this field">
                    <option value="">Select city</option>
                    <option value="Riyadh">Riyadh</option>
                    <option value="Dammam">Dammam</option>
                    <option value="Tabuk">Tabuk</option>
                    <option value="Yanbu">Yanbu</option>
                    <option value="Qatif">Qatif</option>
                    <option value="Jeddah">Jeddah</option>
                    <option value="Makkah">Makkah</option>
                    <option value="Abha">Abha</option>
                    <option value="Najran">Najran</option>
                    <option value="Jizan">Jizan</option>
                    <option value="Ha\'il">Ha\'il</option>
                    <option value="Medina">Medina</option>
                    <option value="Hofuf">Hofuf</option>
                    <option value="Ta\'if">Ta\'if</option>
                    <option value="Khobar">Khobar</option>
                    <option value="Al Qunfudhah">Al Qunfudhah</option>
                    <option value="Khamis Mushait">Khamis Mushait</option>
                    <option value="Jubail">Jubail</option>
                    <option value="Al Qassim">Al Qassim</option>
                    <option value="Others">Others</option>
                </select>';
        $string .='</div>';

                    $string .='<div class="form-group">';
                    $string .='<label for="rentaldate">Date of rental</label>';
                    $string .='<input type="text" class="form-control input-date" id="rentaldate" aria-describedby="emailHelp">';
                    $string .='</div>';

                    $string .='<div class="form-group">';
                    $string .='<label for="ndays">Number of days</label>';
                    $string .='<input type="text" class="form-control input-number" id="ndays" aria-describedby="emailHelp">';
                    $string .='</div>';

                    $string .='<div class="form-group">';
                    $string .='<label for="notes">Order Notes</label>';
                    $string .='<textarea class="form-control" id="notes" rows="6" aria-describedby="emailHelp"></textarea>';
                    $string .='</div>';
                    $string .='</div>';
                    $string .='</div>';

            $string .='<div class="col-xs-12 col-sm-6 px-0 float-right-left col-2">';
            $string .='<div class="col-xs-12">';
            $string .='<div class="col-xs-12 px-0">';
            $string .='<h3 class="sec-title">Your Quote</h3>';
            $string .='</div>';

            $string .='<div class="col-xs-12 mb-2">';
            $string .='<ul class="list-group" id="quote_items">';
            $string .='<li class="list-group-item header">Products</li>';

                            if( isset($_COOKIE['shopping_cart']) ){
                                $cookie_data    = stripslashes($_COOKIE['shopping_cart']);
                                $cart_data      = json_decode($cookie_data, true);
                                $cart_count     = count( $cart_data );                                    
                                if( $cart_count > 0 ){
                                    foreach($cart_data as $keys => $values)
                                    {
                            $string .='<li class="list-group-item list-group-item'.$cart_data[$keys]['item_id'].'">';
                        $string .='<div class="col-xs-12 col-sm-8 min-height-35">';
                        $string .='<a href="javascript:void(0);" class="item-cnt d-inline-block">
										<i class="fa fa-times text-danger remove-quote-from-checkout" onclick="removeCartItem('.$cart_data[$keys]['item_id'].')" data-id="'.$cart_data[$keys]['item_id'].'" data-tr="quoteItems"></i> '. $cart_data[$keys]['item_name'].'  
                                    </a>';
                            $string .='</div>';

                            $string .='<div class="col-xs-12 col-sm-4 height-35">';
                            $string .='<div class="form-group row mb-0">';
                                $string .='<label for="example-text-input" class="col-md-3 col-form-label d-inline-block">Qty</label>';
                                $string .='<div class="col-md-9">';
                                $string .='<input class="form-control form-control-sm item" type="number" value="1" style="width: 98%" data-itemid="'. $cart_data[$keys]['item_name'].'">';
                                $string .='</div>';
                                $string .='</div>';
                                $string .='</div>';
                                $string .='</li>';
                                    }                 
                                 } 
                             }
                        $string .='</ul>';
                        $string .='<br>';

                $string .='</div>';

                $string .='<div class="col-xs-12 terms-panel">';
                $string .='<div class="jumbotron" style="padding-top: .5em;padding-bottom: 2em;">';
                    $string .='<h4 class="h4 fs-2 my-1">Request a Quote</h4>';
                    $string .='<p class="lead fs-1 bg-clr">Please submit your quote contents to receive a quote.</p>';
                    $string .='<hr class="my-4">';
                    $string .='<p>';
                    $string .='</p>';
                    $string .='<div class="form-check d-inline-block mb-2">';
                    $string .='<label class="form-check-label">';
                        $string .='<input class="form-check-input mb-1" name="trm" type="checkbox" required="" data-parsley-required-message="Please check this field" value="1" data-parsley-multiple="trm"> I’ve read and accept the &nbsp;</label>';
                        $string .='</div>';

                        $string .='<a class="d-inline-block" href="#" data-featherlight="#feather-term>">';
                            $string .='<span class="text-muted terms-conditions"> terms &amp; conditions</span>';
                            $string .='</a>';
                            $string .='<p class="lead text-xs-right">';
                            $string .='<input type="submit" class="btn btn-danger" value="Submit Quote">';
                            $string .='</p>';
                            $string .='</div>';
                    $string .='</div>';

                    
                    $string .='<div class="lightbox ajaxcontent featherlight-inner" id="feather-term"> ';
                    $string .='<div class="container">';
                    $string .='<div class="row">';
                    $string .='<div class="col-sm-12 popup-wrap">';
                    $string .='<h5 class="modal-title">Terms & Conditions</h5>';
                    $string .='<h2 class="h2" style="color:#dcac1c"><strong>Rental Terms</strong></h2>';
                    $string .='<strong>Operability and Safety:</strong>';
                    $string .='<p>
The Renter is responsible for using the rented gear in the manner it was designed to be used by manufacturer. The Renter should not use the Gear in a way that may interfere with the operability of the gear or the safe operation of the Gear. </p>


<strong>Cleanliness:</strong>
<p>The Renter should use the rented gear in a way that maintains the cleanliness and condition of the gear. EQEW may determine at its’ sole discretion whether the rented gear is not maintained well enough by the Renter during the Rental Period and may charge a Renter for repairs and cleaning due to it’s EQEW’s own investigation.</p>

<strong>On Time Rentals:</strong>
If a Renter requests a Listing for a Rental Period, and EQEW accepts the request, the Renter should be available to pick up the gear on-time, based on the Rental Period that was accepted by EQEW and accepted by the Renter.</p>

<strong>Eligibility:</strong>
<p>
Although it is very rare, EQEW may suspend or revoke a Renter’s eligibility to use EQEW’s services at any time for any reason, at EQEW’s sole discretion. In the event that EQEW suspends or revokes a Renter, EQEW reserves the right to suspend or cancel any reserved or active Rentals and cancel any Rental payments.</p>

<strong>Damage:</strong>
<p>If, as a Renter, you notice that the rented Gear was damaged during a Rental, you must contact EQEW immediately and report the damage.</p>


<strong>Theft::</strong>
<p>
    If, as an Renter, you believe that the Owner’s Gear was stolen during a Rental, you must contact EQEW immediately. EQEW is not liable for a member’s deceptive or fraudulent acts, voluntary parting of Gear, and the theft of Gear, but we will completely cooperate with the investigation and produce information about the incident and parties involved, working with law enforcement and any insurance companies involved. The renter is fully responsible for any thefts.
</p>



<strong>Cancellation:</strong>
<p>
  If a renter cancel an order before delivery time in up to 48 hours, a 15% will be charged from the invoice. If a renter cancel an order before less than 48 hours from delivery time, a 60% will be charged from the invoice.  
</p>



<strong>Late Returns and No Shows:</strong>
<p>
If, as a Renter, you are late returning Gear, at an agreed upon date and time with EQEW, you will be subject to pay a late fee 150%. If, as a Renter, you fail to show up for a scheduled Rental Meeting, you must let EQEW know. Significant or multiple late or no shows may affect a Renter’s ability to rent Gear in the future.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </form>
</div>';

return $string;