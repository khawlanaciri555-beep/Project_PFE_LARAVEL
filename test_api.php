<?php
$urls = [
    'http://localhost:8000/api/places',
    'http://localhost:8000/api/services',
    'http://localhost:8000/api/hotels',
    'http://localhost:8000/api/transports'
];

foreach ($urls as $url) {
    $ctx = stream_context_create(array('http'=>
        array(
            'timeout' => 5,
            'ignore_errors' => true // to fetch even if 404/500
        )
    ));
    $response = file_get_contents($url, false, $ctx);
    if(preg_match("@^HTTP/[0-9\.]+ (.*)$@", $http_response_header[0], $m)) {
        echo "$url -> " . $m[1] . "\n";
    }
}
