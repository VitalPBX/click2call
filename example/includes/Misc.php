<?php
namespace Click2Call\Example;

class Misc{
	public static function phoneFormat($number) {
		if(strlen($number) == 10) {
			$number = '('.substr($number, 0, 3) .') '. substr($number, 3, 3) .' - '. substr($number, 6);
		} else if(strlen($number) == 7) {
			$number = substr($number, 0, 3) .'-'. substr($number, 3, 4);
		}else if(strlen($number) == 8) {
			$number = substr($number, 0, 4) .'-'. substr($number, 4, 4);
		}else if(strlen($number) == 12 && preg_match('/^\+1/', $number)) {
			$number = substr($number, 0, 2) .' ('. substr($number, 2, 3) .') '. substr($number, 5,3).' '. substr($number, 8);
		}else if(strlen($number) == 11 && preg_match('/^1/', $number)) {
			$number = substr($number, 0, 1) .' ('. substr($number, 1, 3) .') '. substr($number, 4,3).' '. substr($number, 7);
		}

		return $number;
	}
}