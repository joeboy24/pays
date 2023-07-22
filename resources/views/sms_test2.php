<html>
    <head></head>
    <body>
        <p>Hello World</p>
    </body>
</html>

<?php 

    $curl = curl_init();

    $endPoint = 'https://api.mnotify.com/api/sms/quick';
    $apiKey = 'uMl30OFBEGRUJXApCnmkgV9mb';
    $url = $endPoint . '?key=' . $apiKey;

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,// your preferred link
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_TIMEOUT => 30000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => array(
            // Set Here Your Requesred Headers
            'Content-Type: application/json',
        ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        print_r(json_decode($response));
    }
    // $data = [
    // 'recipient' => ['0247873637'],
    // 'sender' => 'PivoApps',
    // 'message' => 'Your OTP is 7219. Do not share with anyone.',
    // 'is_schedule' => 'false',
    // 'schedule_date' => ''
    // ];

    // $ch = curl_init();
    // $headers = array();
    // $headers[] = "Content-Type: application/json";
    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    // curl_setopt($ch, CURLOPT_URL, $url);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    // $result = curl_exec($ch);
    // $result = json_decode($result, TRUE);
    // curl_close($ch);

    // echo 'Hello..! Works Perfect';
?>