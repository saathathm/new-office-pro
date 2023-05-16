<?php
set_time_limit( 0 );
header( 'Content-Type: application/json' );
header( 'Access-Control-Allow-Origin: *' );
header( 'Access-Control-Allow-Methods: POST, GET, OPTIONS' );
header( 'Access-Control-Allow-Headers: Content-Type' );

define( 'COOKIE', __DIR__ . "/cookie.txt" );
if ( file_exists( 'cookie.txt' ) ) {
	unlink( 'cookie.txt' );
}
$data     = json_decode( file_get_contents( 'php://input' ), true );
$base_url = "http://172.107.33.22/time";

$request_types = [
	'login',
	'logout',
	'late_logout',
	'get_status'
];

if ( $data && $data['_token'] == "im_time" ) {
	$request_type = $data['type'];

	if ( ! in_array( $request_type, $request_types ) ) {
		response_json( 3, "Wrong request type!" );
	}

	$login_url = "$base_url/controller/login.php";
	$username  = $data['username'];
	$password  = $data['password'];

	$dashboard_page = send_request( $login_url, "uname=$username&pword=$password" );

	if ( \strpos( $dashboard_page['response'], '/controller/login.php' ) !== false ) {
		response_json( 3, "Something went wrong in login, Please check your login details!" );
	}
	preg_match_all( '#class="login-blurb"(.*?)<\/span>#is', $dashboard_page['response'], $matchesMain4 );
	$login_button = $matchesMain4[0][1];
	preg_match( '#controller\/attendance.php\?emp_id=(.*?)&&action=#is', $login_button, $user_id_matches );

	preg_match( '/(Total Duration)([^`]*?)(<\/)/', $dashboard_page['response'], $time_login_response );

	$user_id    = $user_id_matches[1];
	$logout_url = $base_url . "/controller/attendance.php?emp_id=$user_id&&action=logout_approved";
	if ( \strpos( $login_button, 'action=logout_approved' ) !== false ) {
		if ( $request_type == 'logout' ) {
			$logout_page = send_request( $logout_url )['response'];
			if ( \strpos( $logout_page, 'controller/late_logout.php' ) !== false ) {
				response_json( 2, "You just forgot to logout older login!, You need to fill last logged out time and date. (this feature on development)", [ 'type' => 1 ] );
			} else {
				response_json( 1, "Successfully logged out!", [ 'type' => 2 ] );
			}
		} elseif ( $request_type == 'login' ) {
			response_json( 2, "You're already logged in!", [ 'type' => 1 ] );
		} elseif ( $request_type == 'late_logout' ) {
			if ( trim( $data['time'] ) != "" ) {
				$time        = date( 'h:i a', strtotime( $data['time'] ) );
				$logout_page = send_request( $logout_url )['response'];
				if ( \strpos( $logout_page, 'controller/late_logout.php' ) !== false ) {
					//				response_json( 2, "You just forgot to logout older login!, You need to fill last logged out time and date. (this feature on development)" );
					preg_match( '#<input type="hidden"  value="(.*?)" name="id">#is', $logout_page, $matchesinner );
					preg_match_all( '#<input type="hidden"  value="(.*?)\"#is', $matchesinner[0], $matchesinner2 );
					if ( isset( $matchesinner2[1][1] ) ) {
						$late_logout_id = $matchesinner2[1][1];
						$post           = "time=" . urlencode( $time ) . "&action=Logout&employee_id=$user_id&id=$late_logout_id";
						send_request( $base_url . "/controller/late_logout.php?time=" . urlencode( $time ) . "&action=Logout&employee_id=$user_id&id=$late_logout_id" );
						response_json( 1, "Successfully logged out!", [ 'type' => 2 ] );
					}
				} else {
					response_json( 1, "Successfully logged out!", [ 'type' => 2 ] );
				}
			} else {
				response_json( 2, "You need to fill out the logout time!", [ 'type' => 1 ] );
			}
			response_json( 2, "This request is on development!" . $time );
		} elseif ( $request_type == 'get_status' ) {
			$login_time = 0;
			if ( isset( $time_login_response[2] ) ) {
				$login_time = html_entity_decode( $time_login_response[2] );
			}

			response_json( 1, "You are now logged in! \n Total logged time is " . $login_time, [ 'type'       => 1,
			                                                                                     'login_time' => $login_time
			] );
		} else {
			response_json( 3, "Wrong request type!", [ 'type' => 1 ] );
		}
	} elseif ( \strpos( $login_button, 'action=login_approved' ) !== false ) {
		$login_url = $base_url . "/controller/attendance.php?emp_id=$user_id&&action=login_approved";
		if ( $request_type == 'login' ) {
			$login_page = send_request( $login_url )['response'];
			if ( \strpos( $login_url, 'controller/late_logout.php' ) !== false ) {
				response_json( 2, "You just forgot to logout older login!, You need to fill last logged out time and date. (this feature on development)", [ 'type' => 1 ] );
			} else {
				response_json( 1, "Successfully logged in!", [ 'type' => 1 ] );
			}
		} elseif ( $request_type == 'logout' ) {
			response_json( 2, "You're already logged out!", [ 'type' => 2 ] );
		} elseif ( $request_type == 'late_logout' ) {
			//			$time = date( 'h:i a', strtotime( $data['time'] ) );
			response_json( 2, "You're already logged out!", [ 'type' => 2 ] );
		} elseif ( $request_type == 'get_status' ) {
			$login_time = 0;
			if ( isset( $time_login_response[2] ) ) {
				$login_time = $time_login_response[2];
			}

			response_json( 1, "You are now logged out! And Total logged time is " . $login_time, [ 'type'       => 2,
			                                                                                       'login_time' => $login_time
			] );
		} else {
			response_json( 3, "Wrong request type!", [ 'type' => 2 ] );
		}
	} else {
		response_json( 3, "Something went wrong!,  ERROR: no_matched_status", [ 'type' => 0 ] );
	}
}


function send_request( $url, $post = false ) {

	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $url );
	if ( $post !== false ) {
		curl_setopt( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $post );
	}
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
	curl_setopt( $ch, CURLOPT_COOKIEFILE, COOKIE );
	curl_setopt( $ch, CURLOPT_COOKIEJAR, COOKIE );
	$d['response'] = curl_exec( $ch );
	$d['status']   = curl_getinfo( $ch );

	return $d;
}

function response_json( $status, $message, $ad_array = array() ) {
	/*
	 * Status:
	 *  1 = success
	 *  2 = warning
	 *  3 = error
	 *  4 = other
	 */
	$response_array = [ 'status' => $status, 'message' => $message ];
	if ( ! empty( $ad_array ) ) {
		$response_array = array_merge( $response_array, $ad_array );
	}
	$response_json = json_encode( $response_array );

	echo $response_json;
	die();
}