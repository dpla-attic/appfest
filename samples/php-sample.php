<!DOCTYPE html>
<html>
<head>
	<title>Using PHP with the DPLA</title>
</head>
<body>
	<h1>Using PHP with the DPLA</h1>
	<div>
    	<?php
    	    // Our DPLA API URL.
    	    // Search the keyword field for the term 'deadly'

	   $url = 'http://api.dp.la/v1/items/?q=deadly';

            // Use cURL to GET data from the API
    	    $ch = curl_init($url);            
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec ( $ch ); 
            curl_close($ch);
            
            // Decode the JSON string into something we easily use
            $json_output = json_decode($response);

            // Dump some markup for description
            if (!empty($json_output->docs)) {
                echo "<h2>Items:</h2>";
                echo "<div style='margin-left: 12px; background-color: #EEE; padding: 5px;'>";
     
                foreach ( $json_output->docs as $doc ) {
	            // if we have a source url, add a link.
	            if ( ! empty($doc->source)){
                       echo "\n<h3><a href=\"{$doc->source}\">{$doc->title}</a></h3>";
	            } else {
	               echo "\n<h3>{$doc->title}</h3>";
	            }
                    // description can be either string or array.
	            $descriptions = $doc->description;
	            if ( ! is_array($descriptions )) {
	                $descriptions = array( $descriptions );
	            }
	            foreach ( $descriptions as $description) {
	               echo "\n<div>{$description}</div>";
	            }
                }
                echo "</div>";
            }
        ?>
	</div>
</body>
</html>
