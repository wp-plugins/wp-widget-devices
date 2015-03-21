<?php
/*
Plugin Name: WP Widget Devices
Plugin URI: 
Description: Displays the content you want only the device you want, movil, tablet or only web.
Version: 1.2
Author: iLen
*/
if(!class_exists('WP_widget_devices')){
	class WP_widget_devices extends WP_Widget {
	 	
		var $default          = array();
		var $default_validate = array();

	    function __construct(){

	        // Widget Builder.
	        $widget_ops = array('classname' => 'wp_widget_devices', 'description' => 'Displays the content you want only the device you want' );
	        $this->WP_Widget('wp_widget_devices', "WP Widget Devices", $widget_ops);

	        // MAKES script in page
	        add_action( 'wp_enqueue_scripts', array(__CLASS__,'my_scripts_style_page' ) );


	        // default inputs
	        $this->default           = array( 'title'   => '',
			                                  'show_in' => 'web',
			                                  'text'	=> '',
			                                  'method'	=> 'css');

	        // validate inputs
	        $this->default_validate =array( 'title'           => 's',
	                                       	'show_in'   	  => 's',
	                                       	'text'			  => 'h',
	                                       	'method'		  => 's');
	    }



	    function widget($args,$instance){

	        
	        extract( $this->validate_inputs_for_default( (array) $instance,  $this->default ) );

	        // variable's widget
	        extract( $args );
	 		
	 		$id_generic = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
	        echo "<div id='wp-only-devices-$id_generic' class='wp-only-devices $show_in'>";

			        echo $before_widget; ?>

			                  <?php 
			                  if ( $title ){
			                        echo $before_title . $title . $after_title;
			                  } ?>

			        <?php
			          
			          	echo $text;
			 
			        ?>

			        <?php
			         echo $after_widget;
	         echo "</div>";

	        if( $method == 'js' ){
		         echo "
		         <script>
		          		var wp_only_devices_html_$id_generic;
		          		var wp_only_devices_type_$id_generic;
						jQuery(document).ready(function($) {

						    if( !  wp_only_devices_html_$id_generic  ){

						         wp_only_devices_html_$id_generic = $('#wp-only-devices-$id_generic').html();

						    }

						    $('wp-only-devices-$id_generic').html('');

						    wp_only_devices_type_$id_generic = '$show_in';

						    $(window).resize(function(){
						            var width = $(window).width();

						            if(width >= 769){

						            	if( wp_only_devices_type_$id_generic == 'web' ){

						            		$('#wp-only-devices-$id_generic').html( wp_only_devices_html_$id_generic );

						            	}

						            	if( wp_only_devices_type_$id_generic == 'tablet' ){

						            		$('#wp-only-devices-$id_generic').html( '' );

						            	}

						            	if( wp_only_devices_type_$id_generic == 'movil' ){

						            		$('#wp-only-devices-$id_generic').html( '' );

						            	}
						                 
						            }
						            else if(width >= 481 && width <= 768){

						            	if( wp_only_devices_type_$id_generic == 'web' ){

						            		$('#wp-only-devices-$id_generic').html( '' );

						            	}

						            	if( wp_only_devices_type_$id_generic == 'tablet' ){

						            		$('#wp-only-devices-$id_generic').html( wp_only_devices_html_$id_generic );

						            	}

						            	if( wp_only_devices_type_$id_generic == 'movil' ){

						            		$('#wp-only-devices-$id_generic').html( '' );

						            	}
						                 
						            }

						            else if( width <= 480){

						            	if( wp_only_devices_type_$id_generic == 'web' ){

						            		$('#wp-only-devices-$id_generic').html( '' );

						            	}

						            	if( wp_only_devices_type_$id_generic == 'tablet' ){

						            		$('#wp-only-devices-$id_generic').html( '' );

						            	}

						            	if( wp_only_devices_type_$id_generic == 'movil' ){

						            		$('#wp-only-devices-$id_generic').html( wp_only_devices_html_$id_generic );

						            	}
						                 
						            }
	 
						            })

						        .resize();

						});
				</script>";
			}
	          ?> <!-- class='widget'  --><?php
	    }
	 
	    function form($instance){
	        
	 
	        $instance = wp_parse_args( (array) $instance, $this->default ); 
	        extract( $instance ); ?>
	 
	        <div>
	            <p>
	                <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo "Title" ?> </label>
	                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
	            </p>
	            <p>
	            	<label for="<?php echo $this->get_field_id('text'); ?>"><?php echo "HTML Output" ?> </label><br />
	            	<textarea id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" style="width:100%;height:100px;"><?php echo esc_attr($text); ?></textarea>
	            </p>
	            <p>
	                <label for="<?php echo $this->get_field_id('show_in'); ?>"><?php echo "Show in" ?> </label>
	                <select id="<?php echo $this->get_field_id('show_in'); ?>" name="<?php echo $this->get_field_name('show_in'); ?>" >
	                	<?php  foreach (array('movil' => 'Only Movil',
	                						  'tablet'=> 'Only Tablet',
	                						  'web'   => 'Only Web') as $key => $value)
	                                echo "<option value='$key' ".selected( $key , $show_in , false ).">$value</option>"; ?>
	                </select>
	            </p>
	            <p>
	                <label for="<?php echo $this->get_field_id('method'); ?>"><?php echo "Method" ?> </label>
	                <select id="<?php echo $this->get_field_id('method'); ?>" name="<?php echo $this->get_field_name('method'); ?>" >
	                	<?php  foreach (array('css' => 'Css (Recommended)',
	                						  'js'	=> 'Javascript') as $key => $value)
	                                echo "<option value='$key' ".selected( $key , $method , false ).">$value</option>"; ?>
	                </select>
	            </p>
	        </div>

	         <?php
	    }
 
        
 

	    function update($new_instance, $old_instance){

	        foreach ($new_instance as $key => $value)  $old_instance[$key] = $this->validate_inputs_ext( ($value),$this->default_validate[$key] ); 

	        $update = $old_instance;

	        return $update;

	    }


	    // scripts & styles
	    function my_scripts_style_page(){
	        if(!is_admin()){
	            wp_register_style( 'custom-style-wp-widget-devices', plugins_url('assets/css/style.css', __FILE__) );
	            wp_enqueue_style( 'custom-style-wp-widget-devices' );
	        }
	    }


	    // =VALIDATE input for type
		function validate_inputs_ext($input,$type){

		  // type = (s)=string,(i)=integet,(h)=HTML output
	
		  if($type){
		      if( $type == 's' ){
		          return (string) esc_attr($input);
		      }elseif( $type == 'i' ){
		          return (int)$input;
		      }elseif( $type == 'h' ){
		          return $input;
		      }
		  }

		}

		// =VALIDATE input if not value
		function validate_inputs_for_default($array_value = array(), $array_default = array() ){

		  $array_new_values = array();
		  if( is_array( $array_value ) ){

		    foreach ($array_value as $key => $value) {
		      
		        if( !$value )
		          $array_new_values[$key] = $array_default[$key];
		        else
		          $array_new_values[$key] = $array_value[$key];
		    }

		  }else
		    $array_new_values = $array_value;


		  return $array_new_values;
		 
		}


	    

	} // class
} // if


add_action( 'widgets_init', create_function('', 'return register_widget("WP_widget_devices");') ); 
?>