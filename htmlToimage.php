<?php

function htmlToPdf($paySlip, $empName) {
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://yakpdf.p.rapidapi.com/pdf",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'source' => [
                'html' => $paySlip
            ],
            'pdf' => [
                'format' => 'A4',
                'scale' => 1,
                'printBackground' => true // set to true to ensure the background is printed
            ],
            'wait' => [
                'for' => 'navigation',
                'waitUntil' => 'load',
                'timeout' => 2500
            ]
        ]),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json; charset=UTF-8",
            "x-rapidapi-host: yakpdf.p.rapidapi.com",
            "x-rapidapi-key: b059de3dabmsh4091613a6987130p1b1a1fjsne53129498b1d"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        // Print the HTTP status code
        // echo "HTTP Status Code: " . $http_status . "\n";

        // Print the first few bytes of the response
        // echo "Response Data (first 100 bytes): " . substr($response, 0, 100) . "\n";

        // Save the PDF response to a file
        if (file_put_contents($empName, $response) !== false) {
            return "PDF saved successfully to " . $empName;
        } else {
            return "Failed to save PDF to " . $empName;
        }
    }
}

// Example usage


