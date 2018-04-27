<?php

		require_once( dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/wp-config.php' );
		require_once( dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/wp-includes/wp-db.php' );
		if (!$wpdb) {
		    $wpdb = new wpdb( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
		} else {
		    global $wpdb;
		}

		 global $wpdb; 
		 $check_list = '';
         $extra_field_export = '';
         $get_fields = '';

        $ShowTable = "imevent_payments";
        $FileName = "_export.csv";
        $file = fopen($FileName,"w");

        if(isset($_POST['check_list']) && $_POST['check_list']){
            $check_list = $_POST['check_list'];    
        }
        if(isset($_POST['extra_field_export']) && $_POST['extra_field_export'] != ''){
            $extra_field_export = explode(',', str_replace(' ', '', $_POST['extra_field_export']));    
        }
        

        /* Create heading for csv file */
        if($check_list && $extra_field_export){
            $arr_check_list = array_merge($check_list, $extra_field_export);
            fputcsv($file,$arr_check_list);
        }else if(!$check_list && $extra_field_export){
            fputcsv($file,$extra_field_export);
        }else if($check_list && !$extra_field_export){
            fputcsv($file,$check_list);
        }
        

        /* Get the fields to export csv */
        if($check_list){
            foreach ($check_list as $key => $value) {
                $get_fields .= $value.',';
            }
        }
        if($extra_field_export){
        	$get_fields .= 'buyer_info';	
        }
        $get_fields = rtrim($get_fields,',');

        if($get_fields){
            /* Get records with the fields */
            $sql = 'SELECT '.$get_fields.' FROM '.$ShowTable .' WHERE status="Completed" ORDER BY id DESC';
            $result_free_res = $wpdb->get_results($sql);

            
            foreach ( $result_free_res  as $key => $value){
                
                foreach($value as $name1 => $value1){

                    $array_cut_complete_new = array();
                    $array_cut_complete = array();
                    
                    if ($name1=='buyer_info') {
                    
                        

                        $value1 =  strip_tags(html_entity_decode($value1)); 
                        $value1 =  utf8_decode($value1);

                        $explode_buyer = explode('|||',$value1);
                        
                        foreach ($explode_buyer as $key => $value) {

                            $exp_value = explode(':', $value, 2);
                             if(in_array(trim($exp_value['0']), $extra_field_export)){
                                $array_cut_complete[$exp_value['0']][]= $exp_value['1'];
                             }
                        }

                        for ($i=0; $i < count($extra_field_export); $i++) {
                            
                            foreach ($array_cut_complete as $key => $value) {
                                $cache_val = '';
                                if($extra_field_export[$i] == $key){

                                    for ( $k = 0; $k < count( $array_cut_complete[$key] ); $k++ ) {
                                        if($k>=1){
                                            $cache_val .= ' | ';
                                        }    
                                        $cache_val .= $array_cut_complete[$key][$k];
                                        
                                    }
                                    $array_cut_complete_new[] = $cache_val;
                                }
                            }
                        }


                    }
                    else{
                        if ($name1=='created') {
                            $valuesArray[]=date('M d Y', ($value1));
                        } else {
                            $valuesArray[]=$value1;
                        }
                        
                    }   
                }

                
                if (empty($array_cut_complete_new) && empty($valuesArray)) {
                   $new_heading_value=[];
                }
                elseif(empty($valuesArray)){
                   $new_heading_value =  $array_cut_complete_new;
                }
                elseif (empty($array_cut_complete_new)) {
                    $new_heading_value =  $valuesArray;
                }
                else{
                    $new_heading_value= array_merge($valuesArray, $array_cut_complete_new);
                }
            
                    fputcsv($file,$new_heading_value);
                    unset( $valuesArray );
                    unset( $array_cut_complete_new );
                    unset( $new_heading_value );
                    unset( $array_cut_complete);
                
                
            }

             fclose($file);
             
            header("Content-type: text/csv");
            header("Content-disposition: attachment; filename = $FileName");
            readfile("$FileName");
        }else{
            echo 'Please choose field to export';
            echo '<button onclick="window.history.go(-1);" class="btn">&nbsp;Go Back page</button>';
        }
		
        

       
?>
