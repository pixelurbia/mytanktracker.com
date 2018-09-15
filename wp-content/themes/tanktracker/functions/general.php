<?php


class General {


function resizeImageFiles($size,$load,$target) {
  
    $image = new SimpleImage();
    $image->load($load);
    $image->resizeToWidth($size);
    $image->save($target);
    // var_error_log($target_file);
    // return $target_file; //return name of saved file in case you want to store it in you database or show confirmation message to user   
	}
}


add_action('wp_ajax_trello_bug_report', 'trello_bug_report');
add_action('wp_ajax_nopriv_trello_bug_report', 'trello_bug_report');
function trello_bug_report(){


	 if( !isset( $_POST['trello_bug_report'] ) || !wp_verify_nonce( $_POST['trello_bug_report'], 'trello_bug_report' ) )
    die( 'Ooops, something went wrong, please try again later.' );


// 'https://api.trello.com/1/cards?key=myKey&token=myToken&name=newCardName&desc=newCarddescription&idList=myListId'
 // $url = 'https://api.trello.com/1/members/me/boards?key='.$key.'&token='.$token.'';

// $url ='https://api.trello.com/1/boards/fYOldyoi?key='.$key.'&token='.$token.'';
// $url ='https://api.trello.com/1/lists/fYOldyoi'.$uath;
// $url = 'https://api.trello.com/1/boards/5b554f5441aa075b3ebd03fd/cards'.$uath;


# init curl
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, $url);
// //curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded_fields);
// curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
// curl_setopt($ch, CURLOPT_HEADER, 1);
// curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE); // make sure we see the sended header afterwards
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_TIMEOUT, 0);
// //curl_setopt($ch, CURLOPT_POST, 1);

// # dont care about ssl
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// # download and close
// $output = curl_exec($ch);
// $request =  curl_getinfo($ch, CURLINFO_HEADER_OUT);
// $error = curl_error($ch);
// curl_close($ch);

// echo 'This is output = '.$output .'<br />';
// echo 'This is request = '.$request .'<br />';
// echo 'This is error = '.$error .'<br />';

$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$user_name = $current_user->user_nicename;
$user_email = $current_user->user_email;

    $title    = $_REQUEST['title'];
    $content  = $_REQUEST['content'];
    $donor  = $_REQUEST['donor'];


//api key
$key = 'd15559067c9457077d0dd8e955a86c27';
//token
$token = 'e1e23face87b8c0effb9aaa52700a52d9ae21deecf12b6a271f95c14ebbb6350';
$auth = '?key='.$key.'&token='.$token;

  $card_name = htmlspecialchars($title);
  $card_content = htmlspecialchars($content) . "\n";
  $card_content .= htmlspecialchars($user_name) . " (" . htmlspecialchars($user_email) . ")";
  if ($donor == 'Yes'){
  	$card_content .= '(Donor Request)';
  }
  

  $trello_key          = $key;
  $trello_api_endpoint = 'https://api.trello.com/1';
  $trello_list_id      = '5b554f5441aa075b3ebd03fe';
  $trello_member_token = $token; // Guard this well
  
  $url = 'https://api.trello.com/1/cards';
  $fields='token='.$trello_member_token;
  $fields.='&key='.$trello_key;
  $fields.='&idList='.$trello_list_id;
  $fields.='&name='.$card_name;
  $fields.='&desc='.$card_content;
 
  $result = trello_post($url, $fields);

}


function trello_post($url, $fields){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
  curl_setopt($ch, CURLOPT_HEADER, 0);    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 0);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $output = curl_exec($ch);
  curl_close($ch);
  return json_decode($output);
}
