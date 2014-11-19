<?php
define('DISQUS_SECRET_KEY', 'jhOCZrgyOoxgBD3RvmQBIzfKnOmll9U7TxNdUxobWNHCcRo8oqNjubh7HQie4mEa');
define('DISQUS_PUBLIC_KEY', '6BnWT0efR9SN6eDcg4mnHymNZKNKDsekR4CWAJh4PrnjcfM6E05vouYbBehIBFdh');
 
$data = array(
        "id" => $user["id"],
        "username" => $user["username"],
        "email" => $user["email"]
    );
 
function dsq_hmacsha1($data, $key) {
    $blocksize=64;
    $hashfunc='sha1';
    if (strlen($key)>$blocksize)
        $key=pack('H*', $hashfunc($key));
    $key=str_pad($key,$blocksize,chr(0x00));
    $ipad=str_repeat(chr(0x36),$blocksize);
    $opad=str_repeat(chr(0x5c),$blocksize);
    $hmac = pack(
                'H*',$hashfunc(
                    ($key^$opad).pack(
                        'H*',$hashfunc(
                            ($key^$ipad).$data
                        )
                    )
                )
            );
    return bin2hex($hmac);
}
 
$message = base64_encode(json_encode($data));
$timestamp = time();
$hmac = dsq_hmacsha1($message . ' ' . $timestamp, DISQUS_SECRET_KEY);
?>
