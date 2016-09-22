<?php
require_once dirname(__FILE__).'/bootstrap/config.php';

// Versione della documentazione
define("AWS_VERSION", "2013-08-01");
// Endpoint: The region you are interested in
define("AWS_ENDPOINT", "webservices.amazon.it");
define("AWS_URI", "/onca/xml");

$params = [
	"Version" => AWS_VERSION,
	"Service" => "AWSECommerceService",
	"AWSAccessKeyId" => AWS_API_KEY,
	"AssociateTag" => AWS_ASSOCIATE_TAG,
	"Timestamp" => gmdate('Y-m-d\TH:i:s\Z')
];

$params_ItemSearch = [
	"Operation" => "ItemSearch",
	"SearchIndex" => "Electronics",
	"Keywords" => "HTC",
	"ResponseGroup" => "Offers,  Variations, VariationOffers, VariationMatrix, VariationSummary, VariationMinimum",
	"Sort" => "relevancerank" // è quello di default di amazon
];

/**
 * Valid ResponseGroup values for ItemLookup requests include:
 * 'Accessories', (large)
 * 'AlternateVersions', null
 * 'BrowseNodes', // Restituisce le Categorie (large)
 * 'Collections', null
 * 'EditorialReview', // Restituisce EditorialReviews->EditarialReview->Source e EditorialReviews->EditarialReview->Content. Source spesso è Product Description (medium/large)
 * 'Images', // Restituisce le immagini (medium/large)
 * 'ItemAttributes', // Tutti gli item attr. (medium/large)
 * 'ItemIds',
 * 'Large', restiusce i responsegroup segnati + quelli di medium e small
 * 'Medium', (large)
 * 'OfferFull', (offers)
 * 'OfferListings', (Offers - OfferSummary)
 * 'Offers', (large)
 * 'OfferSummary', (medium/large)
 * 'PromotionalTag', null
 * 'PromotionDetails',  // ['PromotionSummary', 'PromotionDetails', 'ShippingCharges']
 * 'PromotionSummary',  // When ResponseGroup equals
 * 'RelatedItems', // When ResponseGroup equals RelatedItems, RelationshipType must be present.
 * 'Request', (medium)
 * 'Reviews', // Restituisce CustomerReviews->IFrameURL (large)
 * 'SalesRank', // Numero di vendite del prodotto (medium/large)
 * 'SearchBins', null
 * 'SearchInside',  null
 * 'ShippingCharges',   // ResponseGroup in ['Offers', 'OfferFull', 'OfferListings', 'Large'] must be present.
 * 'ShippingOptions' // The identity contained in the request is not authorized to use this
 * 'Similarities', // Usato per "articoli simili" in (large) c'è SimilarProducts
 * 'Small', (medium)
 * 'Tracks', (large)
 * 'VariationMatrix',
 * 'VariationMinimum',
 * 'VariationOffers', (Variations)
 * 'Variations',
 * 'VariationSummary', (Variations)
 */

/**
 * Valid Sort values for ItemLookup requests include:
 * 'relevancerank', rilevanza, è quello di default di amazon
 * 'salesrank', numero di vendite
 * 'price', low to high
 * '-price', high to low
 * 'reviewrank', stelle?
 * 'reviewrank_authority' stelle autoritarie?
 */

/**
 * <ASIN>B00RD3X6IU</ASIN>
 * <ParentASIN>B00UXMFDLQ</ParentASIN>
 */
$params_ItemLookup = array(
	"Operation" => "ItemLookup",
	"IdType" => "ASIN",
	"ItemId" => "B00UXMFDLQ",
	"VariationPage" => "All",
	"ResponseGroup" => "Large, VariationMatrix"
);

$params_BrowseNodeLookup = array(
	"Operation" => "BrowseNodeLookup",
	"BrowseNodeId" => "2569674031",
	"ResponseGroup" => "BrowseNodeInfo"
);

$params = array_merge($params, $params_ItemLookup);
ksort($params); // Sort the parameters by key

$pairs = array();
foreach ($params as $key => $value) {
	array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
}

// Generate the canonical query
$canonical_query_string = join("&", $pairs);

// Generate the string to be signed
$string_to_sign = "GET\n".AWS_ENDPOINT."\n".AWS_URI."\n".$canonical_query_string;

$signature = base64_encode(hash_hmac("sha256", $string_to_sign, AWS_API_SECRET_KEY, true));

// Generate the signed URL
$request_url = 'http://'.AWS_ENDPOINT.AWS_URI.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);

//Catch the response in the $response object
$response = file_get_contents($request_url);

// DEBUG XML
$xml = new \DOMDocument('1.0', 'UTF-8');
$xml->loadXML($response);
header( "content-type: application/xml; charset=ISO-8859-15" );
print $xml->saveXML();
exit();

// PARSER XML
$parsed_xml = simplexml_load_string($response);
if($parsed_xml->OperationRequest->Errors) {
	foreach($parsed_xml->OperationRequest->Errors->Error as $error){
		echo "Error code: " . $error->Code . "\r\n";
		echo $error->Message . "\r\n";
		echo "\r\n";
	}
}else{
	printSearchResults($parsed_xml);
}

function printSearchResults($parsed_xml){
	$numOfItems = $parsed_xml->Items->TotalResults;
	if($numOfItems>0){
		print("<table>");
		foreach($parsed_xml->Items->Item as $current) {
			print("<td><font size='-1'><b>".$current->ItemAttributes->Title."</b>");
			if(isset($current->ItemAttributes->Publisher)) {
				print("<br>Publisher: ".$current->ItemAttributes->Publisher);
			}
			if(isset($current->Offers->Offer->OfferListing->Price->FormattedPrice)) {
				print("<br>Price: ".$current->Offers->Offer->OfferListing->Price->FormattedPrice);
				print(" from ".$current->Offers->Offer->Merchant->Name);
			}
		}
	}else{
		print("<center>No matches found.</center>");
	}
}

?>