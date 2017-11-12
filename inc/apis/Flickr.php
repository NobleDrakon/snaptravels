<?php

function getPhotos($tags) {
    // default url query
    $url = "https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=77505428b8b9c6dcd5eeeea0042ffad1&sort=relevance&safesearch=3&content_type=1&tags=";
    // add the tags to the end of the url to bring back certain results
    $query = $url . $tags;

    $response = simplexml_load_file($query);

    // empty images array
    $images = [];

    foreach($response->photos->photo as $photo){
        
        // gather required data from the xml response
        $farmid = $photo['farm'];
        $serverid = $photo['server'];
        $id = $photo['id'];
        $secret = $photo['secret'];
        
        // example url: https://farm{farm-id}.staticflickr.com/{server-id}/{id}_{secret}.jpg

        // for every result, create a url and add to $images array
        $images[] = "https://farm" . $farmid . ".staticflickr.com/" . $serverid . "/" . $id . "_" . $secret . ".jpg";
    }

    // returns a list of urls
    return $images;
}

$images = getPhotos("mountain, jungle, expedition, desert, adventure");

foreach($images as $image){
    echo "<img width='200' height='200' src='" . $image . "'>";
}

?>