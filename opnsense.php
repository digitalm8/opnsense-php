<?php

class OpnSenseAPI {
    protected $host;
    protected $key;
    protected $secret;

    protected $debug        = 0;

    protected $def_proto    = 'https://';
    protected $def_endpoint = '/api';

    public function OpnSenseAPI($host, $key, $secret, $debug = 0) {
        $this->host   = $host;
        $this->key    = $key;
        $this->secret = $secret;
        $this->debug  = $debug;
    }

    public function run($mcc, $data = array()) {
        $url = $this->def_proto . $this->host . $this->def_endpoint . '/' . $mcc;
        if ($this->debug)
            print("URL: {$url}\n");

        $ch = curl_init( $url );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->key . ':' . $this->secret);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        if (count($data)) {
            $jdata = json_encode($data, JSON_UNESCAPED_UNICODE|JSON_FORCE_OBJECT);
            if ($this->debug)
                print("JSON: {$jdata}\n");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jdata);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Accept: application/json']);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $html = curl_exec($ch);
        if ($html === false) {
            $errno = curl_errno($ch);
            $message = curl_strerror($errno);
            throw new Exception( "cURL error ({$errno}): {$message}" );
        }
        //print_r(curl_getinfo($ch));
        curl_close($ch);
        if ($this->debug)
            print_r(json_decode($html, true));
        return json_decode($html, true);
    }
}
