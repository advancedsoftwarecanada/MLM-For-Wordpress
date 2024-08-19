<?php 

function imlm_encrypt($data) {
	
	$cipher = 'AES-256-CBC';
    $iv_length = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($iv_length);

    $encrypted_data = openssl_encrypt($data, $cipher, IMLM_KEY, OPENSSL_RAW_DATA, $iv);
    $encrypted_data = base64_encode($iv . $encrypted_data);

    return $encrypted_data;
	
}

function imlm_decrypt($encrypted_data) {
	
    $cipher = 'AES-256-CBC';
    $iv_length = openssl_cipher_iv_length($cipher);
    $encrypted_data = base64_decode($encrypted_data);
    $iv = substr($encrypted_data, 0, $iv_length);
    $encrypted_data = substr($encrypted_data, $iv_length);

    $decrypted_data = openssl_decrypt($encrypted_data, $cipher, IMLM_KEY, OPENSSL_RAW_DATA, $iv);

    return $decrypted_data;
	
}