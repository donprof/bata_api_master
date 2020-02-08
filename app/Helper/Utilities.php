<?php

namespace App\Helper;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Callbacks\Callback;
/**
* 
*/
class Utilities {

	public static function generatePassword ()
    {
		function randVowel()
        {
          $vowels = array("a", "e", "i", "o", "u");
          return $vowels[array_rand($vowels, 1)];
        }

        function randConsonant()
        {
          $consonants = array('b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'r', 's', 't', 'v', 'w', 'x', 'z');
          return $consonants[array_rand($consonants, 1)];
        }

        function generatePIN($digits = 4){
            $i = 0; //counter
            $pin = ""; //our default pin is blank.
            while($i < $digits){
                //generate a random number between 0 and 9.
                $pin .= mt_rand(0, 9);
                $i++;
            }
            return $pin;
        }

        function rand_word(){
          return ucfirst(randConsonant() .  randVowel() .  randConsonant() .  randVowel()) . generatePIN();
        }
        
        return rand_word();
	}
}