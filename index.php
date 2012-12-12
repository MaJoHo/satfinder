<!doctype html>
<html lang="en">
	<!--
		created by Martin Hohmuth if you like it feel free to copy and use
	-->
<head>

  <meta charset="utf-8" />
  <title>Satellitefinder</title>

  	<link rel="stylesheet" href="css/style.css" />
  	<link rel="stylesheet" href="css/jslider.css" type="text/css">
	<link rel="stylesheet" href="css/jslider.blue.css" type="text/css">
	<link rel="stylesheet" href="css/jslider.plastic.css" type="text/css">
	<link rel="stylesheet" href="css/jslider.round.css" type="text/css">
	<link rel="stylesheet" href="css/jslider.round.plastic.css" type="text/css">
	<link rel="stylesheet" href="css/nanoscroller.css" type="text/css">
	<link rel="stylesheet" href="css/colorbox.css" type="text/css">
	
	<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="js/jquery.isotope.min.js"></script>
	<script type="text/javascript" src="js/jshashtable-2.1_src.js"></script>
	<script type="text/javascript" src="js/jquery.numberformatter-1.2.3.js"></script>
	<script type="text/javascript" src="js/tmpl.js"></script>
	<script type="text/javascript" src="js/jquery.dependClass-0.1.js"></script>
	<script type="text/javascript" src="js/draggable-0.1.js"></script>
	<script type="text/javascript" src="js/jquery.slider.js"></script>
	<script type="text/javascript" src="js/jquery.nanoscroller.js"></script>
	<script type="text/javascript" src="js/jquery.colorbox.js"></script>

</head>
<body>
		
<?php
	$db_server = 'localhost';
	$db_name = 'satfinder';
	$db_user = 'root';
	$db_passwort = '';
      
    $db = @ mysql_connect ($db_server, $db_user, $db_passwort);
    $db_select = @ mysql_select_db($db_name);
?>
<section id="options" class="clearfix combo-filters">

<?php

//FILTER--------------------------------------------------------------------------------------------------
      
      $sql = 'SELECT sensor FROM satellites GROUP BY sensor';
      
      $filter_result = mysql_query($sql);
      
?>

	<div class="list option-combo sensor">
   	<h3>Sensor</h3>
      <ul class="filter option-set clearfix " data-filter-group="sensor">
        	<li><a href="#filter-sensor-any" data-filter-value="" class="selected">any</a></li>
<?php
      while($filter_row = mysql_fetch_row($filter_result))
      
      echo '
         <li><a href="#filter-sensor-'.strtolower($filter_row[0]).'" data-filter-value=".'.strtolower($filter_row[0]).'">'.$filter_row[0].'</a></li>
      ';
?>
		</ul>
   </div>
   
<?php
   
		$sql = 'SELECT agency FROM satellites GROUP BY agency';
      
  		$filter_result = mysql_query($sql);
      
?>

	<div class="list option-combo agency" style="position: absolute; top: 58px;">
   	<h3>Agency</h3>
      <ul class="filter option-set clearfix " data-filter-group="agency">
        	<li><a href="#filter-agency-any" data-filter-value="" class="selected">any</a></li>
<?php
      while($filter_row = mysql_fetch_row($filter_result))
      
      echo '
         <li><a href="#filter-agency-'.strtolower($filter_row[0]).'" data-filter-value=".'.strtolower($filter_row[0]).'">'.$filter_row[0].'</a></li>
      ';
?>
		</ul>
 </div>
     	
<?php
//SLIDER--------------------------------------------------------------------------------------------------

	$sql = 'SELECT price_aq FROM modes GROUP BY price_aq';
	
	$filter_result = mysql_query($sql);
	$i = 0;
	$price_list_ap = array();
	$str_price_list_ap ="";
		
	while($filter_row = mysql_fetch_row($filter_result))
	{
		if($filter_row[0])
		{
			$price_list_ap[$i] = floatval($filter_row[0]);
			$i++;
		}
	}
	
	for($i = 0; $i<count($price_list_ap); $i++)
	{
		if($i == count($price_list_ap)-1)
		{
			$str_price_list_ap = $str_price_list_ap.$price_list_ap[$i];
		}
		else 
		{
			$str_price_list_ap = $str_price_list_ap.$price_list_ap[$i].', ';
		}
		
	}
	
	$sql = 'SELECT price_data FROM modes GROUP BY price_data';
	
	$filter_result = mysql_query($sql);
	$i = 0;
	$price_list_data = array();
	$str_price_list_data ="";
		
	while($filter_row = mysql_fetch_row($filter_result))
	{
		if($filter_row[0])
		{
			$price_list_data[$i] = floatval($filter_row[0]);
			$i++;
		}
	}
	
	for($i = 0; $i<count($price_list_data); $i++)
	{
		if($i == count($price_list_data)-1)
		{
			$str_price_list_data = $str_price_list_data.$price_list_data[$i];
		}
		else 
		{
			$str_price_list_data = $str_price_list_data.$price_list_data[$i].', ';
		}
		
	}
?>
	<div class="layout-slider slider option-combo apslider">
		<h3>Price New Aquisition</h3>
<?php
	echo '<input id="slider_ap" type="slider" name="price" value="'.$price_list_ap[0].'; '.$price_list_ap[count($price_list_ap)-1].'" />';
?>  
	  
	<ul class="filter option-set clearfix " data-filter-group="apslider">
		<li><a class="selected" href="#filter-apslider-any" data-filter-value="">cancel</a></li>
		<li><a class="ap_slider" href="#filter-apslider-select" data-filter-value=".ap0">ok</a></li>
	</ul>
	</div>
	
	<div class="layout-slider slider option-combo dataslider" style="position: absolute; top: 80px;">
		<h3>Price Archive Data</h3>
<?php
	echo '<input id="slider_data" type="slider" name="price" value="'.$price_list_data[0].'; '.$price_list_data[count($price_list_data)-1].'" />';
?>  
	  
	<ul class="filter option-set clearfix " data-filter-group="dataslider">
		<li><a class="selected" href="#filter-dataslider-any" data-filter-value="">cancel</a></li>
		<li><a class="data_slider" href="#filter-dataslider-select" data-filter-value=".data0">ok</a></li>
	</ul>
	</div>
</section>

<script type="text/javascript" charset="utf-8">	
	jQuery("#slider_ap").slider(
	{
<?php
	echo '
		from: '.$price_list_ap[0].',
		to: '.$price_list_ap[count($price_list_ap)-1].',
		step: 1,
		smooth: true,
		round: 0,
		dimension: "&nbsp;$",
		skin: "round",
		onstatechange: function( value )
		{
			price_list = new Array('.$str_price_list_ap.');';
?>
   			
   			var range = value.split(";");
			var start = parseFloat(range[0]);
			var end = parseFloat(range[1]);
			var select = new Array;
			var str_select = "";
			var j = 0;
   			
			
			for(i=0; i<price_list.length; i++)
			{
				if(price_list[i] >= start && price_list[i] <= end)
				{
					select[j] = price_list[i];
					j++;
				}
				
			}
			
			for(i=0; i<select.length; i++)
			{
				if(i == select.length-1)
				{
					str_select = str_select+".ap"+select[i];
				}
				else
				{
					str_select = str_select+".ap"+select[i]+", ";
				}				
			}
			$("a.ap_slider").attr({
  				'data-filter-value' : str_select,
  				'class' : 'ap_slider'
			});
  		}
	});
	   
	jQuery("#slider_data").slider(
	{
<?php
	echo '
		from: '.$price_list_data[0].',
		to: '.$price_list_data[count($price_list_data)-1].',
		step: 1,
		smooth: true,
		round: 0,
		dimension: "&nbsp;$",
		skin: "round",
		onstatechange: function( value )
		{
			price_list = new Array('.$str_price_list_data.');';
?>
   			
   			var range = value.split(";");
			var start = parseFloat(range[0]);
			var end = parseFloat(range[1]);
			var select = new Array;
			var str_select = "";
			var j = 0;
   			
			
			for(i=0; i<price_list.length; i++)
			{
				if(price_list[i] >= start && price_list[i] <= end)
				{
					select[j] = price_list[i];
					j++;
				}
				
			}
			
			for(i=0; i<select.length; i++)
			{
				if(i == select.length-1)
				{
					str_select = str_select+".data"+select[i];
				}
				else
				{
					str_select = str_select+".data"+select[i]+", ";
				}				
			}
			$("a.data_slider").attr({
  				'data-filter-value' : str_select,
  				'class' : 'data_slider'
			});
  		}
	});   
</script>

<div class="nano">
<div class="content">
	
<div id="container" class="clearfix">
<?php
//SATELEMENT----------------------------------------------------------------------------------------------

      $sql = 'SELECT * FROM satellites';
      
      $sat_result = mysql_query($sql);
      
      while($sat_row = mysql_fetch_row($sat_result))
      {
      	$str_price_list ='';
		$last_ap = '';
		$last_data = '';
			
      	if($sat_row[8])
      	{
      		$sat_row[7]=substr($sat_row[7],0,4);
      		$sat_row[8]=substr($sat_row[8],0,4);
      	}
      	else
      	{
      		$sat_row[7]=substr($sat_row[7],0,4);
      		$sat_row[8] = 'now';
		}
		
		if($sat_row[5] == 0) 
      	{
      		$sat_row[5] = 'unknown';
		}
		else 
		{
			$sat_row[5] = number_format($sat_row[5],3,',','.');
		}
		
		if($sat_row[6] == 0) 
      	{
      		$sat_row[6] = 'unknown';
		}
		else 
		{
      		$sat_row[6] = number_format($sat_row[6],3,',','.');	
		}
		
      	if($sat_row[12])
      		$bg ='style="background-image:url('.$sat_row[12].')"';
      	else
      		$bg = 'style="background-image:url(img/icons/sat/blank.jpg)"';
		
		if(!$sat_row[13] || $sat_row[13]== NULL)
      		$sat_row[13] = 'img/sat/blank.png';
		
//OVERLAY-------------------------------------------------------------------------------------------------
	
		echo '
	<div class="overlay">
		<div id="overlay-'.strtolower($sat_row[0]).'" class="overlay-content">
			<h1 class="name">'.$sat_row[1].'</h1>
			<table class="head">
				<tr>
					<td>
						<ul>
   							<li>Agency: '.$sat_row[3].'</li>
   							<li>Sensor: '.$sat_row[2].'</li>
   							<li>Band: '.$sat_row[4].'</li>
   							<li>Repeat Cycle: '.$sat_row[9].'</li>
   							<li>Frq.: '.$sat_row[5].'</li>
   							<li>Wavelength: '.$sat_row[6].'</li>
   							<li>Operationtime: '.substr($sat_row[7],0,4).'  -  '.substr($sat_row[8],0,4).'</li>';
      
      					if($sat_row[10])
      					{
      						echo '
      						<li><a href="'.$sat_row[10].'" target="blank">Details</a></li>';
      					}
      	
      					if($sat_row[11])
      					{
      						echo '
      						<li><a href="'.$sat_row[11].'" target="blank">Access</a></li>';
      					}
						echo'
   						</ul>
					
					</td>
					<td class="img"><img src="'.$sat_row[13].'" alt="'.$sat_row[1].'" /><td>
				</tr>
			</table>';	
	
		$sql = 'SELECT * FROM modes WHERE sat_ID = '.$sat_row[0];
		
		$mode_result = mysql_query($sql);
		
		if(mysql_num_rows($mode_result) != 0)
		{
			echo'
			<h3>Modes</h3>
			<table>
				<tr>
					<td>Mode</td>
					<td>Spatial Resolution (m)</td>
					<td>Coverage (km x km)</td>
					<td>Min. Incidence Angle</td>
					<td>Max. Incidence Angle</td>
					<td>Price New Aquisition</td>
					<td>Price Archive Data</td>
				</tr>';

			while($mode_row = mysql_fetch_row($mode_result))
			{
			
				if(!$mode_row[4]||$mode_row[4]==0)
					$mode_row[4]='-';
				else
					$mode_row[4] = number_format($mode_row[4],3,',','.');
				
				if(!$mode_row[5]||$mode_row[5]==0)
					$mode_row[5]='-';
			
				if(!$mode_row[6]||$mode_row[6]==0)
					$mode_row[6]='-';
				else
					$mode_row[6] = number_format($mode_row[6],3,',','.');
			
				if(!$mode_row[7]||$mode_row[7]==0)
					$mode_row[7]='-';
				else
					$mode_row[7] = number_format($mode_row[7],3,',','.');
				
				echo '
					<tr>
						<td>'.$mode_row[2].'</td>
						<td>'.$mode_row[4].'</td>
						<td>'.$mode_row[5].'</td>
						<td>'.$mode_row[6].'</td>
						<td>'.$mode_row[7].'</td>';
				
				if($mode_row[8])
				{
					echo '
						<td>'.number_format($mode_row[8],2,',','.').' $</td>';
					if($last_ap != $mode_row[8])
					{	
						$str_price_list = $str_price_list.'ap'.floatval($mode_row[8]).' ';
						$last_ap = $mode_row[8];
					}
				}
				else {
					echo '
						<td>-</td>';
				}
			
				if($mode_row[9])
				{
					echo '
						<td>'.number_format($mode_row[9],2,',','.').' $</td>';
					if($last_data != $mode_row[9])
					{
						$str_price_list = $str_price_list.'data'.floatval($mode_row[9]).' ';
						$last_data = $mode_row[9];
					}
				}
				else {
					echo '
						<td>-</td>';
				}
				echo'
					</tr>';
			}
			echo'
			</table>';
		}
    	echo'
    	</div>
	</div>';  

//OVERLAY-END--------------------------------------------------------------------------------------------
    	
      	echo '      		
	<div id="satellite" class="element satellite '.strtolower($sat_row[2]).' '.strtolower($sat_row[3]).' '.$str_price_list.'" data-symbol="'.strtolower($sat_row[1]).'" data-category="satellite">
   		<div class ="icon clickable" '.$bg.'>
   			<h3 class="name">'.$sat_row[1].'</h3>
   		</div>
   		<div class="shortinfo hidden '.strtolower($sat_row[2]).' '.strtolower($sat_row[3]).' '.strtolower($sat_row[4]).'">
   			<ul>
   				<li>Agency: '.$sat_row[3].'</li>
   				<li>Sensor: '.$sat_row[2].'</li>
   				<li>Band: '.$sat_row[4].'</li>
   			</ul>
   		</div>
   		<div class="info hidden '.strtolower($sat_row[5]).' '.strtolower($sat_row[6]).' '.strtolower($sat_row[7]).' '.strtolower($sat_row[8]).' '.strtolower($sat_row[9]).'">
			<table class="list">
   				<tr>
   					<td class="repeatcycle '.strtolower($sat_row[9]).'" colspan="2">Repeat Cycle: '.$sat_row[9].'</td>
   				</tr>
   				<tr>
   					<td class="frq '.strtolower($sat_row[5]).'">Frq.: '.$sat_row[5].'</td>
   					<td class="lambda '.strtolower($sat_row[6]).'">Wavelength: '.$sat_row[6].'</td>
   				</tr>
   				<tr>
   					<td class="optime '.strtolower($sat_row[7]).' '.strtolower($sat_row[8]).'" colspan="2">Operationtime: '.substr($sat_row[7],0,4).'  -  '.substr($sat_row[8],0,4).'</td>
   				</tr>
   				<tr>';
      
      			if($sat_row[10])
      			{
      				echo '
      				<td class="detailurl  '.strtolower($sat_row[10]).'"><a id="satellite_url" href="'.$sat_row[10].'" target="blank">Details</a></td>';
      			}
      	
      			if($sat_row[11])
      			{
      				echo '
      				<td class="accessurl '.strtolower($sat_row[11]).'"><a id="satellite_url" href="'.$sat_row[11].'" target="blank">Access</a></td>';
      			}
      	
      			echo '
      				<td><a class="inline" href="#overlay-'.strtolower($sat_row[0]).'">More</a></td>
      			</tr>
      		</table>
		</div>	
	</div>';
  }
  mysql_close($db);				
?>
</div>

</div>
</div>
<script>
  $(document).ready(function(){
	//Examples of how to assign the ColorBox event to elements
	$(".inline").colorbox({inline:true, width:"540px"});
				
	//Example of preserving a JavaScript event for inline calls.
	$("#click").click(function(){ 
		$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
		return false;
	});
  });

  $(function(){

    var $container = $('#container'),
        $selector = '.element',
        filters = {};

    $container.isotope({
      itemSelector : $selector,
    });

    $('.filter a').click(function(){
      var $this = $(this);
      if ( $this.hasClass('selected') ) {
        return;
      }

      var $optionSet = $this.parents('.option-set');
      $optionSet.find('.selected').removeClass('selected');
      $this.addClass('selected');

      var group = $optionSet.attr('data-filter-group');
      filters[ group ] = $this.attr('data-filter-value');
      var isoFilters = [];
      for ( var prop in filters ) {
        isoFilters.push( filters[ prop ] )
      }
      var selector = isoFilters.join('');
      $container.isotope({ filter: selector });

      return false;
    });
    
    $container.delegate( '.element', 'click', function(){
      $(this).toggleClass('large');
      $container.isotope('reLayout');
    });
    
    $('#toggle-sizes').find('a').click(function(){
      $container
        .toggleClass('variable-sizes')
        .isotope('reLayout');
      return false;
    });

  });
  		
  $(".nano").nanoScroller({ scroll: 'top' });
</script>
</body>
</html>