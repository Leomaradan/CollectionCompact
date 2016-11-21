<?php

namespace CollectionCompact;

class Compact {
	public static function compact($volumes) {

		if(!is_array($volumes)) {
			throw new Exception("$volumes is not an array", 1);
		}


		if(count($volumes) == 0) {
			return '';
		}
		sort($volumes);

		$current = current($volumes);
		$min = current($volumes);

		if($min < 1) {
			$min = 1;
		}

		$max = max($volumes);

		$string = $current;

		$mode = 'unique';

		for($i = $min + 1; $i <= $max; $i++) {

			if($mode == 'unique') {
				if(in_array($i,$volumes)) {
					$mode = 'follow';
				} else {
					$mode = 'break';
				}
			} elseif($mode == 'follow' && !in_array($i,$volumes)) {
				$string .= ('-' . ($i - 1));
				$mode = 'break';
			} elseif($mode == 'break') {
				if(in_array($i,$volumes)) {
					$mode = 'unique';
					$string .= (',' . $i);
				}				
			}

			if($i == $max && $mode == 'follow') {
				$string .= ('-' . $i);
			}
		}

		return $string;
	}	
}