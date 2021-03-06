<?php

namespace CollectionCompact;

class Compact {
	public static function compact($volumes) {

		if(!is_array($volumes)) {
			throw new \Exception("$volumes is not an array", 1);
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

	public static function unpack($packedString) {

		if(is_numeric($packedString)) {
			return [$packedString];
		}

		if(!is_string($packedString)) {
			throw new \Exception("$packedString is not a string", 1);
		}

		if($packedString == "") {
			return [];
		}

		$volumes = explode(',', $packedString);
		$volumes_list = [];

		foreach ($volumes as $volume) {
			if(is_numeric($volume)) {
				$volumes_list[] = $volume;
			} else {
				$group = explode('-', $volume);
				$start = $group[0];
				$end = $group[1];
				for ($i=$start; $i <= $end ; $i++) {
					$volumes_list[] = $i;
				}
			}
		}

		return $volumes_list;
	}
}