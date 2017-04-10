<?php
	
	
	// helper kunglaw
	
	if(!defined('BASEPATH')) exit ('No direct script access allowed');
	
	if ( ! function_exists('date_format_db'))
	{
		
			/*d - The day of the month (from 01 to 31)
			D - A textual representation of a day (three letters)
			j - The day of the month without leading zeros (1 to 31)
			l (lowercase 'L') - A full textual representation of a day
			N - The ISO-8601 numeric representation of a day (1 for Monday, 7 for Sunday)
			S - The English ordinal suffix for the day of the month 
				(2 characters st, nd, rd or th. Works well with j)
			w - A numeric representation of the day (0 for Sunday, 6 for Saturday)
			z - The day of the year (from 0 through 365)
			W - The ISO-8601 week number of year (weeks starting on Monday)
			F - A full textual representation of a month (January through December)
			m - A numeric representation of a month (from 01 to 12)
			M - A short textual representation of a month (three letters)
			n - A numeric representation of a month, without leading zeros (1 to 12)
			t - The number of days in the given month
			L - Whether it's a leap year (1 if it is a leap year, 0 otherwise)
			o - The ISO-8601 year number
			Y - A four digit representation of a year
			y - A two digit representation of a year
			a - Lowercase am or pm
			A - Uppercase AM or PM
			B - Swatch Internet time (000 to 999)
			g - 12-hour format of an hour (1 to 12)
			G - 24-hour format of an hour (0 to 23)
			h - 12-hour format of an hour (01 to 12)
			H - 24-hour format of an hour (00 to 23)
			i - Minutes with leading zeros (00 to 59)
			s - Seconds, with leading zeros (00 to 59)
			u - Microseconds (added in PHP 5.2.2)
			e - The timezone identifier (Examples: UTC, GMT, Atlantic/Azores)
			I - (capital i) - Whether the date is in daylights 
				savings time (1 if Daylight Savings Time, 0 otherwise)
			O - Difference to Greenwich time (GMT) in hours (Example: +0100)
			P - Difference to Greenwich time (GMT) in hours:minutes (added in PHP 5.1.3)
			T - Timezone abbreviations (Examples: EST, MDT)
			Z - Timezone offset in seconds. The offset for timezones west of UTC 
				is negative (-43200 to 50400)
			c - The ISO-8601 date (e.g. 2013-05-05T16:34:42+00:00)
			r - The RFC 2822 formatted date (e.g. Fri, 12 Apr 2013 12:01:05 +0200)
			U - The seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)*/

		
		function date_format_db($var = '') // datetime format : 2014-10-28 18:25:12
		{
			/*$tahun = substr($var,0,4);
			$bulan = substr($var,5,2);
			$tanggal = substr($var,8,2);
			
			$jam = substr($var,11,2);
			$menit = substr($var,14,2);
			$detik = substr($var,17,2);*/
			
			$cd  = date_create($var);
			 
			
			$df = date_format($cd,"l, F d , Y - H:i");
			$df = str_replace("-","at",$df);
			
			if($var == "0000-00-00" || $var == "0000-00-00 00:00:00")
			{
				$df = "";
			}	
			
			return $df;
			
			//$arrtime = array($tahun,$bulan,$tanggal,$jam,$menit,$detik);
			
			
			//print_r($arrtime);
		}  
		
		function date_format_simple($var = '')
		{
			$cd  = date_create($var);
			$df = date_format($cd,"l, F d");
			$df = str_replace("-","at",$df);
			
			return $df;
		}
		
		function date_format_str($date = "0000-00-00") // datetime format : 2014-10-28 18:25:12
		{
			$hasil = date("M d, Y", strtotime($date));
			if($date == "0000-00-00")
			{
				$hasil = "";
			}
			
			return $hasil;
		}
		
		 
	}
	
	if(!function_exists('since'))
	{
		function since($date){
			$from = date_create(date("Y-m-d H:i:s"));
			$to = date_create($date);
			$diff = date_diff($from, $to);
	
			$years = $diff->format("%y");
			$months = $diff->format("%m");
			$days = $diff->format("%d");
			$hours = $diff->format("%h");
			$minutes = $diff->format("%i");
			$seconds = $diff->format("%s");
	
			$results = "";
			if($years>=1){ $results = $years." years ago"; if($years == 1){ $results = $years." year ago"; }}
			elseif($months>=1) { $results = $months." months ago"; if($months == 1){ $results = $months." month ago"; } }
			elseif($days>=1) { $results = $days." days ago"; if($days == 1){ $results = $days." day ago"; }} 
			elseif($hours>=1) { $results = $hours." hours ago"; if($hours == 1){ $results = $hours." day ago"; } } 
			elseif($minutes>=1) { $results = $minutes." minutes ago"; if($minutes == 1){ $results = $minutes." hour ago"; }  } 
			elseif($seconds>=1){  $results = $seconds." seconds ago"; if($seconds == 1){ $results = $seconds." second ago"; } }
			return $results;
		}
	}
	
	if(!function_exists('since_int'))
	{
		function since_int($date){
			$from = date_create(date("Y-m-d H:i:s"));
			$to = date_create($date);
			$diff = date_diff($from, $to);
	
			$years = $diff->format("%y");
			$months = $diff->format("%m");
			$days = $diff->format("%d");
			$hours = $diff->format("%h");
			$minutes = $diff->format("%i");
			$seconds = $diff->format("%s");
	
			$results = "";
			$number = 0;
			$unit = "";
			
			if($years>=1){ $number = $years; $unit = "year"; }
			elseif($months>=1) { $number = $months; $unit = "month"; }
			elseif($days>=1) { $number = $days; $unit = "day"; } 
			elseif($hours>=1) { $number = $hours; $unit = "hour"; } 
			elseif($minutes>=1) { $number = $minutes; $unit = "minute";  } 
			elseif($seconds>=1){  $number = $seconds; $unit = "second"; }
			
			return $results = array("number" => $number, "unit" => $unit);
		}
		
	}

	
	


?>