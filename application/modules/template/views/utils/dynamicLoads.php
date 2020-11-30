<?php
	/**
		This is a script to dynamically load javascript and css files passed to views
		pass them like this
		
		$data['jsFiles']=['file1.js','file2.js','file3.js'];

		$this->load->view('MyView',$data);
	*/
		$jsTag="script";
		$jsTagType=" type='text/javascript'";
		
		$cssTag="link";
		$cssTagType=" type='text/css'";
		
	if(is_array($css_files)){
		foreach($css_files as $file){
			echo "<".$cssTag." rel='stylesheet' href='".base_url()."assets/css/".$file."'".$cssTagType."></".$cssTag.">\n";
		}
	}
	if(is_array($css_plugin_files)){
		foreach($css_plugin_files as $file){
			echo "<".$cssTag." rel='stylesheet' href='".base_url()."assets/plugins/".$file."'".$cssTagType."></".$cssTag.">\n";
		}
	}
	echo "<".$cssTag." rel='stylesheet' href='//cdn.datatables.net/1.10.12/css/jquery.dataTables.css'".$cssTagType."></".$cssTag.">\n";
	echo "<".$cssTag." rel='stylesheet' href='//cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css'".$cssTagType."></".$cssTag.">\n";
	echo "<".$cssTag." rel='stylesheet' href='//cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.css'".$cssTagType."></".$cssTag.">\n";
	
	
	if(is_array($js_plugin_files)){
		foreach($js_plugin_files as $file){
			echo "<".$jsTag." src='".base_url()."assets/plugins/".$file."'".$jsTagType."></".$jsTag.">\n";
		}
	}
	if(is_array($js_files)){
		foreach($js_files as $file){
			echo "<".$jsTag." src='".base_url()."assets/js/".$file."'".$jsTagType."></".$jsTag.">\n";
		}

	}

	echo "<".$jsTag." src='https://code.highcharts.com/highcharts.js'".$jsTagType."></".$jsTag.">\n";
	echo "<".$jsTag." src='https://code.highcharts.com/highcharts-more.js'".$jsTagType."></".$jsTag.">\n";
	echo "<".$jsTag." src='https://code.highcharts.com/modules/exporting.js'".$jsTagType."></".$jsTag.">\n";
	echo "<".$jsTag." src='https://code.highcharts.com/modules/export-data.js'".$jsTagType."></".$jsTag.">\n";
	echo "<".$jsTag." src='https://code.highcharts.com/maps/modules/map.js'".$jsTagType."></".$jsTag.">\n";

	echo "<".$jsTag." src='//cdn.datatables.net/1.10.12/js/jquery.dataTables.js'".$jsTagType."></".$jsTag.">\n";
	echo "<".$jsTag." src='//cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.js'".$jsTagType."></".$jsTag.">\n";
	echo "<".$jsTag." src='//cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js'".$jsTagType."></".$jsTag.">\n";
	echo "<".$jsTag." src='//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js'".$jsTagType."></".$jsTag.">\n";
	echo "<".$jsTag." src='//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'".$jsTagType."></".$jsTag.">\n";

	
