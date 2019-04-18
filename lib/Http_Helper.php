<?php

class Http_Helper
{
    // コンストラクタ
    function __construct() 
    {
    }
    
    function Controller_Get($url){
        $json = $this->Get($url);
        $obj = json_decode($json, true);

        return $obj;
    }

    // $data is supposed to be an array
    function Controller_Post($url, $data){
        $json = $this->Post($url, $data);
        $obj = json_decode($json, true);

        return $obj;
    }

    function Get($url){
        
        $contents = file_get_contents($url, false, stream_context_create($options));
        return $contents;
    }

    // $data is supposed to be an array
    function Post($url, $data){
        // 初期化
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // SSL証明書を検証しない
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, true);             // POSTメッソッドを使用
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));     // リクエストパラメータを指定
        
        // リクエストを実行
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }
    
    function Post_Json($url, $data){
        // 初期化
        $ch = curl_init();
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_AUTOREFERER => true,
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // SSL証明書を検証しない
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, true);             // POSTメッソッドを使用
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);     // リクエストパラメータを指定
        curl_setopt_array($ch, $options);
        
        // リクエストを実行
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }

    // $data is supposed to be an array
    function Post_GetHeaderArray($url, $data){
        // 初期化
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // SSL証明書を検証しない
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, true);             // POSTメッソッドを使用
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));     // リクエストパラメータを指定
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        //curl_setopt($ch, CURLOPT_REFERER,        "REFERER");
        //curl_setopt($ch, CURLOPT_USERAGENT,      "USER_AGENT");

        // リクエストを実行
        $res = curl_exec($ch);
        
        // ステータスコード取得
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        // header & body 取得
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE); // ヘッダサイズ取得
        $header = substr($res, 0, $header_size); // headerだけ切り出し
        // // $body = substr($response, $header_size); // bodyだけ切り出し
        
        $headers = $this->get_headers_from_curl_response($header);

        curl_close($ch);

        return $headers;
    }

    function get_headers_from_curl_response($response)
    {
        $headers = array();
    
        // $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));

        foreach (explode("\r\n", $response) as $i => $line)
            if ($i === 0)
                $headers['http_code'] = $line;
            else
            {
                list ($key, $value) = explode(': ', $line);
    
                $headers[$key] = $value;
            }
    
        return $headers;
    }
}
?>