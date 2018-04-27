jQuery(window).load(function(){

	var desc = jQuery("#slideshow_fields");


	desc.bind("toggle_showhide",function(){
		var template = 	jQuery('#_cmb_template :selected').val();
		
		if(template == "slide1"){
			jQuery('.cmb_id__cmb_title1').show();
			jQuery('.cmb_id__cmb_title2').show();
			jQuery('.cmb_id__cmb_end_date').show();
			jQuery('.cmb_id__cmb_register_link').show();
			jQuery('.cmb_id__cmb_youtube_link').hide();
			jQuery('.cmb_id__cmb_slideshow_tem1_register_button').show();
			jQuery('.cmb_id__cmb_slideshow_tem2_watchvideo_button').hide();
			jQuery('.cmb_id__cmb_slideshow_tem2_register_button').hide();

		}else if(template == "slide2"){

			jQuery('.cmb_id__cmb_title1').show();
			jQuery('.cmb_id__cmb_title2').show();
			jQuery('.cmb_id__cmb_end_date').hide();
			jQuery('.cmb_id__cmb_register_link').show();
			jQuery('.cmb_id__cmb_youtube_link').show();
			jQuery('.cmb_id__cmb_slideshow_tem1_register_button').hide();
			jQuery('.cmb_id__cmb_slideshow_tem2_watchvideo_button').show();
			jQuery('.cmb_id__cmb_slideshow_tem2_register_button').show();
			
		} else if(template == "slide3"){

			jQuery('.cmb_id__cmb_title1').show();
			jQuery('.cmb_id__cmb_title2').show();
			jQuery('.cmb_id__cmb_end_date').hide();
			jQuery('.cmb_id__cmb_register_link').hide();
			jQuery('.cmb_id__cmb_youtube_link').hide();
			jQuery('.cmb_id__cmb_slideshow_tem1_register_button').hide();
			jQuery('.cmb_id__cmb_slideshow_tem2_watchvideo_button').hide();
			jQuery('.cmb_id__cmb_slideshow_tem2_register_button').hide();
			
		} else if(template == "slide4"){
			
			jQuery('.cmb_id__cmb_title1').show();
			jQuery('.cmb_id__cmb_title2').show();
			jQuery('.cmb_id__cmb_end_date').hide();
			jQuery('.cmb_id__cmb_register_link').hide();
			jQuery('.cmb_id__cmb_youtube_link').show();
			jQuery('.cmb_id__cmb_slideshow_tem1_register_button').hide();
			jQuery('.cmb_id__cmb_slideshow_tem2_watchvideo_button').hide();
			jQuery('.cmb_id__cmb_slideshow_tem2_register_button').hide();
		}

	});
	desc.trigger("toggle_showhide");
	jQuery('#_cmb_template').change(function(){
		desc.trigger("toggle_showhide");
	});

});