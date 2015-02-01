<?php
/**
* Get a gravatar based on the user's email.
*/
function get_gravatar($size=null, $user_email) {
	//echo "hej";
  	return 'http://www.gravatar.com/avatar/' . md5( strtolower( trim( $user_email ) ) ) . '.jpg?' . ($size ? "s=$size" : null);
}