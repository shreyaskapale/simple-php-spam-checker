<?php

// MASTER SPAM CHECK FUNCTION //
// pass "on" or "off" string to on or off the spam check


function master_spam_check($email,$message,$phone,$spam_on_off)
{
if($spam_on_off!="off")
{
if(spam_message_check($message,$words_list)==true){return true;}
if(spam_email_check($email)==true){return true;}
if(spam_phone_check($phone)==true){return true;}
}
else return false;
}


// MASTER SPAM CHECK FUNCTION END //


// SLAVE SPAM CHECK FUNCTIONS // 


function spam_message_check($spm_check_query,$word_list){

	$spm_check_len = strlen($spm_check_query);
	$spm_check_count = str_word_count($spm_check_query);
	
	if($spm_check_count<=2){
		return true;
		// echo "word count spam ";

	}else if($spm_check_len>=1001 || $spm_check_len <= 25)
	{
		return true;
		// echo "length spam";

	}else if(word_list_check($spm_check_query)==true){
		// echo "word list spam";
		return true;
	}


}			




function spam_email_check($email, $domainCheck = false)
{
	$e_check_temp = explode('@',$email);
	$e_check_temp = $e_check_temp[1];
    if ( checkdnsrr($e_check_temp, 'MX') ) {
  	return false;
 	}
 	else {
  	return true;
 }
}

function spam_phone_check($spm_check_query){
	return word_list_check($spm_check_query);
}



function word_list_check($spm_check_query){

	$words_list = array('spam','lorem','ipsum', 'dolore', 'magna','aliqua','123456791','1111111111','0000000000','123','blabla','fuck','suck','asshole','<','>','{','}','$','9999999999','2222222222','8888888888','7777777777','6666666666','5555555555','4444444444','3333333333','hacker','hack','html','script','alert()','inject',);

	foreach ($words_list as &$word) $word = preg_quote($word, '/');
	$num_found = preg_match_all('/('.join('|', $words_list).')/i', $spm_check_query, $matches);
	if($num_found >= 1)
	{
		return true;
	}
}

// SLAVE SPAM CHECK FUNCTIONS END //


?>
