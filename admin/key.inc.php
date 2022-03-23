<?php
function e7061($e){
	$ed = base64_decode($e);
	$n = openssl_decrypt("$ed","AES-256-CBC","dscfghtfgrdeuion",0,"5387593452165789");
	return $n;
}
?>