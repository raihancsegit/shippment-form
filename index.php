<?php 
/* 
Plugin Name: Shippment Form
Description: Shipment is the core plugin for W-Shipping WordPress Theme. You must install this plugin to get a full fledge Shipping WordPress Theme, otherwise you'll miss some cool features.
Author: Raihan Islam
Author URI: https://raihanislamcse.com
Version: 1.0.0
License: GPL2
Text Domain: wp-shipping
*/



if (!defined("ABSPATH"))
    exit;
if (!defined("MY_APP_PLUGIN_DIR_PATH"))
    define("MY_APP_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));
if (!defined("MY_APP_PLUGIN_URL"))
    define("MY_APP_PLUGIN_URL", plugins_url() . "/appointment");

    function my_appointment_include_assets() {

       
        $slug = '';
        $pages_includes = array("frontendpage","appointment-list");

        $currentPage = $_GET['page'];

        //$_SERVER[REQUEST_URI] 
        ///$_SERVER[HTTP_HOST]: http://, https://

        if(empty($currentPage)){
            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                if (preg_match("/appointment/", $actual_link)) {
                    $currentPage = "frontendpage";
                }
        }

	    if(in_array($currentPage,$pages_includes)){
            //styles
            wp_enqueue_style("bootstrap", MY_APP_PLUGIN_URL . "/assets/css/bootstrap.css", '');
            wp_enqueue_style("datatable", MY_APP_PLUGIN_URL . "/assets/css/jquery.dataTables.min.css", '');
            wp_enqueue_style("notifybar", MY_APP_PLUGIN_URL . "/assets/css/jquery.notifyBar.css", '');
            wp_enqueue_style("style", MY_APP_PLUGIN_URL . "/assets/css/style.css", '');
            //scripts
            wp_enqueue_script('jquery');
            wp_enqueue_script('bootstrap.min.js', MY_APP_PLUGIN_URL . '/assets/js/bootstrap.min.js', '', true);
            wp_enqueue_script('validation.min.js', MY_APP_PLUGIN_URL . '/assets/js/jquery.validate.min.js', '', true);
            wp_enqueue_script('datatable.min.js', MY_APP_PLUGIN_URL . '/assets/js/jquery.dataTables.min.js', '', true);
            wp_enqueue_script('jquery.notifyBar.js', MY_APP_PLUGIN_URL . '/assets/js/jquery.notifyBar.js', '', true);
            wp_enqueue_script('script.js', MY_APP_PLUGIN_URL . '/assets/js/script.js', '', true);
        }
           
        
            
        }
        
//add_action("admin_enqueue_scripts", "my_appointment_include_assets");

    function my_appointment_plugin_menus(){
        add_menu_page("Shippment List", "Shippment List", "manage_options", "shippment-se", "my_appointment_list", "dashicons-book-alt", 30);
        add_submenu_page("shippment-se", "Shippment List", "Shippment List", "manage_options", "appointment-list", "my_appointment_list");

    }
add_action("admin_menu", "my_appointment_plugin_menus");

    function my_appointment_list() {
        include_once MY_APP_PLUGIN_DIR_PATH . "/views/appointment-list.php";
    }


global $jal_db_version;
$jal_db_version = '1.0';

function jal_install() {
	global $wpdb;
	global $jal_db_version;

	$table_name = $wpdb->prefix . 'liveshoutbox';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		name tinytext NOT NULL,
        phone varchar(55) DEFAULT '' NOT NULL,
		text text NOT NULL,
		email varchar(55) DEFAULT '' NOT NULL,
		department varchar(55) DEFAULT '' NOT NULL,
		doctor varchar(55) DEFAULT '' NOT NULL,
		sex varchar(55) DEFAULT '' NOT NULL,
		date_of_birth varchar(55) DEFAULT '' NOT NULL,
		book_date varchar(55) DEFAULT '' NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );
}


register_activation_hook( __FILE__, 'jal_install' );


function cf_shortcode2($atts, $content = null) {
    extract( shortcode_atts( array(
        'title'    => '',
        'sub'      => '',
        'phn'      => '',
       
       ), $atts ) );

    ob_start();
    ?>
    <?php
    if ( isset( $_POST['app_submit'] ) ) {

		// sanitize form values
		$country          = sanitize_text_field( $_POST["country"] );
    $cname            = sanitize_text_field( $_POST["cname"] );
    $contact          = sanitize_text_field( $_POST["contact"] );
    $post_code        = sanitize_text_field( $_POST["post_code"] );
    $city             = sanitize_text_field( $_POST["city"] );
    $email            = sanitize_email( $_POST["email"] );
    $tel              = sanitize_text_field( $_POST["tel"] );
    
    $country2         = sanitize_text_field( $_POST["country2"] );
    $cname2           = sanitize_text_field( $_POST["cname2"] );
    $contact2         = sanitize_text_field( $_POST["contact2"] );
    $zip              = sanitize_text_field( $_POST["zip"] );
    $city2            = sanitize_text_field( $_POST["city2"] );
    $state            = sanitize_text_field( $_POST["state"] );
    $email2           = sanitize_email( $_POST["email2"] );
    $tel2             = sanitize_text_field( $_POST["tel2"] );

    $pak                   = sanitize_text_field( $_POST["pak"] );
    $weight                = sanitize_text_field( $_POST["weight"] );
    $length                = sanitize_text_field( $_POST["length"] );
    $width                 = sanitize_text_field( $_POST["width"] );
    $height                = sanitize_text_field( $_POST["height"] );
    $dec_value             = sanitize_text_field( $_POST["dec_value"] );
    
    
    
		
		//$subject          = sanitize_text_field( $_POST["tf-subject"] );
		//$message          = esc_textarea( $_POST["tf-message"] );

		// get the blog administrator's email address
		$to = get_option( 'admin_email' );

		$headers = "From: $name <$email>" . "\r\n";

		// If email has been process for sending, display a success message
		// if ( wp_mail( $to, $subject, $message, $headers ) ) {
		// 	echo '<div>';
		// 	echo '<p>Thanks for contacting me, expect a response soon.</p>';
		// 	echo '</div>';
		// } else {
		// 	echo 'An unexpected error occurred';
        // }
        global $wpdb;
        $table_name = $wpdb->prefix . 'liveshoutbox';
        $suc =  $wpdb->insert( 
            $table_name, 
            array( 
                'time'          => current_time( 'mysql' ),
                'name'          => $name,
                'phone'         => $phone,
                'text'          => $email,
                'email'         => $email,
                'department'    => $dep,
                'doctor'        => $doctor,
                'sex'           => $sex,
                'date_of_birth' => $tf_d_of_birth,
                'book_date' => $appointment_date
            ) 
        );
    $msg = '';
    if($suc){
        $msg = "Appointment Succesfully ";
    }else{
        $msg = "Appointment Not Succesfully ";
    }
    
    }
    ?>
 
    <!-- Create New Shipment Start -->
  <div class="wshipping-content-block shipping-block">
    <div class="container">
      <h2 class="heading2-border mt0">Create New Shipping</h2>
      <div class="row">
        <div class="shipping-form-block">
          <form class="steps" accept-charset="UTF-8" enctype="multipart/form-data" action="<?php echo esc_url($_SERVER['REQUEST_URI']) ?>" method="post">
            <!-- progressbar -->
            <ul id="progressbar">
              <li class="active">Where From</li>
              <li>Where Going</li>
              <li>What</li>
              <li>How</li>
              <li>Payment</li>
              <li>Review</li>
              <li>Complete</li>
            </ul>
            <!-- fieldsets Shipping From Start-->
            <fieldset>
              <h2 class="fs-title">Hello. Where are you shipping from? <a href="" title="" class="login-btn-form">Login</a></h2>
              <h3 class="fs-subtitle">* Indicates required field </h3>
              <div class="shipping-form">
                <div class="row">
                  <div class="col-12 col-lg-4">
                    <div class="form-group">
                      <label>Country<sup>*</sup></label>
                      <select name="country" class="form-control">
                        <option>United States</option>
                        <option>Canada</option>
                        <option>France</option>
                        <option>Germany</option>
                        <option>Greece</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-12 col-lg-4">
                    <div class="form-group">
                      <label>Company or Name<sup>*</sup></label>
                      <input type="text" class="form-control" name="cname" required="required" />
                      <span class="error1" style="display: none;"> <i class="error-log fa fa-exclamation-triangle"></i> </span> </div>
                  </div>
                  <div class="col-12 col-lg-4">
                    <div class="form-group">
                      <label>Contact<sup>*</sup></label>
                      <input type="text" class="form-control" name="contact" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-lg-4">
                    <div class="form-group">
                      <label>Postal Code<sup>*</sup></label>
                      <input type="text" class="form-control" name="post_code"/>
                    </div>
                  </div>
                  <div class="col-12 col-lg-4">
                    <div class="form-group">
                      <label>City<sup>*</sup></label>
                      <input type="text" class="form-control" name="city"/>
                    </div>
                  </div>

                  <div class="col-12 col-lg-4">
                    <div class="form-group">
                      <label>E-mail <sup>*</sup></label>
                      <input type="email" class="form-control" name="email"/>
                    </div>
                  </div>
                 
                </div>
                
                <div class="row">
                  
                  <div class="col-12 col-lg-4">
                    <div class="form-group">
                      <label>Telephone<sup>*</sup></label>
                      <input type="text" class="form-control" name="tel"/>
                    </div>
                  </div>
                  <div class="col-12 col-lg-4">
                    <div class="form-group">
                      <label>Ext.</label>
                      <input type="text" class="form-control" name="ext" />
                    </div>
                  </div>
                </div>
             
                
              </div>
              <input type="button" name="next" class="next action-button" value="Continue" />
              <input type="reset" name="cancel" class="action-button btn-red" value="Cancel Shipment" />
            </fieldset>
            <!-- fieldsets Shipping From end--> 
            
            <!-- fieldsets Shipping going Start-->
            <fieldset>
              <h2 class="fs-title">Where is your shipping going? <a href="" title="" class="login-btn-form">Login</a></h2>
              <h3 class="fs-subtitle">* Indicates required field </h3>
              <div class="shipping-form">
                <div class="row">
                  <div class="col-12 col-lg-4">
                    <label>Country<sup>*</sup></label>
                    <select name="country2" class="form-control">
                      <option>United States</option>
                      <option>Canada</option>
                      <option>France</option>
                      <option>Germany</option>
                      <option>Greece</option>
                    </select>
                  </div>
                  <div class="col-12 col-lg-4">
                    <div class="form-group">
                      <label>Company or Name<sup>*</sup></label>
                      <input type="text" class="form-control" name="cname2" required="required"/>
                      <span class="error1" style="display: none;"> <i class="error-log fa fa-exclamation-triangle"></i> </span> </div>
                  </div>
                  <div class="col-12 col-lg-4">
                    <div class="form-group">
                      <label>Contact<sup>*</sup></label>
                      <input type="text" class="form-control" name="contact2" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-lg-4">
                    <div class="form-group">
                      <label>Address<sup>*</sup></label>
                      <input type="text" class="form-control" name="address4" placeholder="Street Address" />
                    </div>
                  </div>
                  <div class="col-12 col-lg-4">
                    <div class="form-group">
                      <label>Zip Code<sup>*</sup></label>
                      <input type="text" class="form-control" name="zip"/>
                    </div>
                  </div>

                  <div class="col-12 col-lg-4">
                    <div class="form-group">
                      <label>City<sup>*</sup></label>
                      <input type="text" class="form-control" name="city2"/>
                    </div>
                  </div>
                  
                </div>
                <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="form-group">
                      <label>State<sup>*</sup></label>
                      <input type="text" class="form-control" name="state" />
                    </div>
                  </div>

                  <div class="col-12 col-lg-4">
                    <div class="form-group">
                      <label>E-mail <sup>*</sup></label>
                      <input type="email" class="form-control" name="email2"/>
                    </div>
                  </div>
                  <div class="col-12 col-lg-4">
                    <div class="form-group">
                      <label>Telephone<sup>*</sup></label>
                      <input type="text" class="form-control" name="tel2"/>
                    </div>
                  </div>
                 
                </div>
               
              </div>
              <input type="button" name="previous" class="previous action-button" value="Previous" />
              <input type="button" name="next" class="next action-button" value="Continue" />
              <input type="reset" name="cancel" class="action-button btn-red" value="Cancel Shipment" />
            </fieldset>
            <!-- fieldsets Shipping going end--> 
            
            <!-- fieldsets package Start-->
            <fieldset>
              <h2 class="fs-title">What kind of packaging are you using? <a href="" title="" class="login-btn-form">Login</a></h2>
              <h3 class="fs-subtitle">* Indicates required field </h3>
              <div class="shipping-form">
                <div class="row">
                  <div class="col-12 col-lg-8">
                    <div class="row">
                      <div class="col-12 col-lg-6">
                        <div class="form-group">
                          <label>Packaging Type<sup>*</sup></label>
                          <div class="input-comment">
                            <input type="text" class="form-control" name="pak" required="required" />
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-lg-6">
                        <div class="form-group">
                          <label>Weight<sup>*</sup></label>
                          <div class="input-comment">
                            <input type="text" class="form-control" name="weight" required="required" />
                            <span class="error1" style="display: none;"> <i class="error-log fa fa-exclamation-triangle"></i> </span> <span class="field-comment">lbs</span> </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 col-lg-6">
                        <div class="form-group">
                          <label>Length</label>
                          <div class="input-comment">
                            <input type="text" class="form-control" name="length"/>
                            <span class="field-comment">in</span></div>
                        </div>
                      </div>
                      <div class="col-12 col-lg-6">
                        <div class="form-group">
                          <label>Width</label>
                          <div class="input-comment">
                            <input type="text" class="form-control" name="width"/>
                            <span class="field-comment">in</span></div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 col-lg-6">
                        <div class="form-group">
                          <label>Height</label>
                          <div class="input-comment">
                            <input type="text" class="form-control" name="height"/>
                            <span class="field-comment">in</span></div>
                        </div>
                      </div>
                      <div class="col-12 col-lg-6">
                        <div class="form-group">
                          <label>Declared value</label>
                          <div class="input-comment">
                            <input type="text" class="form-control" name="dec_value"/>
                            <span class="field-comment">USD</span></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-lg-4">
                    <div class="what-package"><img src="assets/images/package.jpg" alt=""/></div>
                  </div>
                </div>
              </div>
              <input type="button" name="previous" class="previous action-button" value="Previous" />
              <input type="button" name="next" class="next action-button" value="Continue" />
              <input type="reset" name="cancel" class="action-button btn-red" value="Cancel Shipment" />
            </fieldset>
            <!-- fieldsets package end--> 
            
            <!-- fieldsets pick up Start-->
            <fieldset>
              <h2 class="fs-title">How would you like to ship? <a href="" title="" class="login-btn-form">Login</a></h2>
              <h3 class="fs-subtitle">* Indicates required field </h3>
              <div class="shipping-form dropoff-block">
                <h3>Whould you like us to pick up your shipment?</h3>
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item"><a class="nav-link active" href="#no-drop" aria-controls="no-drop" role="tab" data-toggle="tab">No I'll drop it off</a></li>
                  <li class="or-text">--or--</li>
                  <li class="nav-item"><a class="nav-link" href="#yes-drop" aria-controls="yes-drop" role="tab" data-toggle="tab">Yes pick up my shipment</a></li>
                </ul>
                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane active" id="no-drop">
                    <div class="row">
                      <div class="col-12 col-lg-4">
                        <div class="form-group">
                          <label>Dropoff date:</label>
                          <div class="datepicker-group">
                            <input type="text" class="form-control datetimepicker1" placeholder="Date" />
                            <div class="datepicker-icon"><i class="fa fa-calendar-alt"></i></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <h3>When would like it delivered?</h3>
                    <div class="row">
                      <div class="col-12 col-lg-4">
                        <div class="form-group">
                          <label>Date and short details:</label>
                          <input type="text" class="form-control" name="sDetails" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div role="tabpanel" class="tab-pane" id="yes-drop">
                    <div class="row">
                      <div class="col-12 col-lg-4">
                        <div class="form-group">
                          <label>Pickup date:</label>
                          <div class="datepicker-group">
                            <input type="text" class="form-control datetimepicker1" placeholder="Date" />
                            <div class="datepicker-icon"><i class="fa fa-calendar-alt"></i></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="review">
                      <h3>Pickup Address <a href="" title="Edit" class="btn-edit">Edit</a></h3>
                      <p>Lorem Ipsum is simply dummy text<br>
                        of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                    </div>
                    <div class="review">
                      <h3>Pickup Details <a href="" title="Edit" class="btn-edit">Edit</a></h3>
                      <p>Your pickup window: 9:00AM - 7:00PM<br>
                        Pickup location: Front Door</p>
                    </div>
                  </div>
                </div>
              </div>
              <input type="button" name="previous" class="previous action-button" value="Previous" />
              <input type="button" name="next" class="next action-button" value="Continue" />
              <input type="reset" name="cancel" class="action-button btn-red" value="Cancel Shipment" />
            </fieldset>
            <!-- fieldsets package end--> 
            
            <!-- fieldsets payment Start-->
            <fieldset>
              <h2 class="fs-title">How would like to pay? <a href="" title="" class="login-btn-form">Login</a></h2>
              <h3 class="fs-subtitle">* Indicates required field </h3>
              <div class="shipping-form">
                <div class="form-group">
                  <div class="row">
                    <div class="col-12 col-lg-4">
                      <label>Card Type<sup>*</sup></label>
                      <select name="cardType" class="form-control">
                        <option>Select One</option>
                        <option>Paypal</option>
                        <option>Visa</option>
                        <option>Master</option>
                        <option>American express</option>
                      </select>
                    </div>
                    <div class="col-12 col-lg-4">
                      <div class="we-accept"> <img src="assets/images/card-paypal.png" alt=""/> <img src="assets/images/card-visa.png" alt=""/> <img src="assets/images/card-master.png" alt=""/> <img src="assets/images/card-discover.png" alt=""/> <img src="assets/images/card-amex.png" alt=""/> </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-12 col-lg-4">
                      <label>Card Number<sup>*</sup></label>
                      <input type="text" class="form-control" name="address1" placeholder="Street Address"  required="required" />
                      <span class="error1" style="display: none;"> <i class="error-log fa fa-exclamation-triangle"></i> </span> </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-12 col-lg-4">
                      <label>Exparation<sup>*</sup></label>
                      <select name="exparation" class="form-control">
                        <option>Select Month</option>
                        <option>January</option>
                        <option>February</option>
                        <option>March</option>
                      </select>
                    </div>
                    <div class="col-12 col-lg-4">
                      <label class="empty">&nbsp;</label>
                      <select name="exparation2" class="form-control">
                        <option>Select Year</option>
                        <option>January</option>
                        <option>February</option>
                        <option>March</option>
                      </select>
                    </div>
                    <div class="col-12 col-lg-4">
                      <label>CVV<sup>*</sup></label>
                      <input type="text" class="form-control" name="other-address" />
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-12 col-lg-4">
                      <label class="slide-label">Billing Address</label>
                      <div class="checkbox">
                        <input type="checkbox" name="remember" id="same-bill" class="css-checkbox" />
                        <label for="same-bill" class="css-label">Send updates on this shipment</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <h3>Duties and Taxes</h3>
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.</p>
                  <div class="row">
                    <div class="col-12 col-lg-4">
                      <label class="slide-label">Use a promo code?</label>
                      <div class="slide-redio">
                        <input type="checkbox" value="None" id="slide-radio4" name="check" checked />
                        <label for="slide-radio4"></label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <input type="button" name="previous" class="previous action-button" value="Previous" />
              <input type="button" name="next" class="next action-button" value="Continue" />
              <input type="reset" name="cancel" class="action-button btn-red" value="Cancel Shipment" />
            </fieldset>
            <!-- fieldsets payment Start--> 
            
            <!-- fieldsets Review Start-->
            <fieldset>
              <h2 class="fs-title">Let's make sure everyting is in order</h2>
              <div class="shipping-form">
                <div class="review">
                  <h3>Where <a href="" title="Edit" class="btn-edit">Edit</a></h3>
                  <div class="row">
                    <div class="col-12 col-lg-4">
                      <div class="ship-address">
                        <h4>Ship from</h4>
                        <p>Lorem Ipsum is simply dummy text<br>
                          of the printing and typesetting industry</p>
                      </div>
                    </div>
                    <div class="col-12 col-lg-4">
                      <div class="ship-address">
                        <h4>Ship to</h4>
                        <p>Lorem Ipsum is simplydummy text of the<br>
                          printing and typesetting industry</p>
                      </div>
                    </div>
                    <div class="col-12 col-lg-4">
                      <div class="ship-address">
                        <h4>Return to</h4>
                        <p>Lorem Ipsum is simplydummy text of the<br>
                          printing and typesetting industry</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="review">
                  <h3>What <a href="" title="Edit" class="btn-edit">Edit</a></h3>
                  <h5>Shipment information</h5>
                  <ul>
                    <li><b>Actual Weight:</b> 60 lbs</li>
                    <li><b>Total Bilable Weight:</b> 60 lbs</li>
                  </ul>
                  <h5>Package information</h5>
                  <ul>
                    <li><b>Weight:</b> 60 lbs</li>
                    <li><b>Dimensions:</b> 17x13x11 in</li>
                    <li><b>Declared value:</b> $100</li>
                  </ul>
                </div>
                <div class="review">
                  <h3>How <a href="" title="Edit" class="btn-edit">Edit</a></h3>
                  <h5>Service Selection</h5>
                  <p>It has survived not only five centuries,</p>
                  <h5>Arrival</h5>
                  <p>Mon, Nov6, 2017, End of the day</p>
                </div>
                <div class="review">
                  <h3>Aditional Option <a href="" title="Edit" class="btn-edit">Edit</a></h3>
                  <p>N/A</p>
                </div>
                <div class="review">
                  <h3>Payment <a href="" title="Edit" class="btn-edit">Edit</a></h3>
                  <h5>Bill Shipping Charge to:</h5>
                  <p>Paypal</p>
                  <h5>Bill Duties and Taxes to:</h5>
                  <p>Receive Company name</p>
                  <h5>Enter Promo Code:</h5>
                  <div class="promoCode-input">
                    <input type="text" class="form-control" name="sDetails" />
                  </div>
                </div>
                <div class="review">
                  <div class="checkbox">
                    <input type="checkbox" name="remember" id="trems" class="css-checkbox" />
                    <label for="trems" class="css-label">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</label>
                  </div>
                </div>
              </div>
              <input type="button" name="previous" class="previous action-button" value="Previous" />
              <input type="button" name="next" class="next action-button" value="Continue" />
            </fieldset>
            <!-- fieldsets payment Start-->
            <fieldset>
              <div class="shipping-form">
                <h1 class="tanks-message">Thank You For Create Shipping</h1>
              </div>
              <input type="submit" name="submit" class="submit action-button" value="Submit" />
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Create New Shipment end --> 
 
    <?php
	return ob_get_clean();
}

add_shortcode( 'shipping', 'cf_shortcode2' );



add_action( 'vc_before_init', 'your_name_integrateWithVC' );
function your_name_integrateWithVC() {
 vc_map( array(
    "name" => __( "Shipping Form", "w-shipping" ),
    "base" => "shipping",
    "class" => "",
    "category" => __( "W-Shipping", "w-shipping"),
    'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
    'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __( "Title", "w-shipping" ),
            "param_name" => "title",
        ),
        array(
            "type" => "textfield",
            "heading" => __( "Sub Title", "w-shipping" ),
            "param_name" => "sub",
        ),
        array(
            "type" => "textfield",
            "heading" => __( "Phone No", "w-shipping" ),
            "param_name" => "phn",
        ),
        array(
            'type'       => 'attach_image',
            'heading'    => esc_html__('Font Image', 'w-shipping'),
            'param_name' => 'image',
        ),
        array(
            'type'       => 'attach_image',
            'heading'    => esc_html__('BG Image', 'w-shipping'),
            'param_name' => 'bg_image',
        ),
       

  )
 ) );
}






?>
