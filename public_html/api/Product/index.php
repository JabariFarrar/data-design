<?php

require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
//require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\DataDesign\{Profile};

/** api for the Product Class
 *
 * @author Jabari Farrar <jofarrar@gmail.com>
 */
//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/ddctwitter.ini");
	// mock a logged in user by mocking the session and assigning a specific user to it.
	// this is only for testing purposes and should not be in the live code.
	$_SESSION["product"] = Product::getProductByProductId($pdo, 732);
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	var_dump($method);
	//sanitize the search parameters
	$ProductId = filter_input(INPUT_GET, "ProductId", FILTER_VALIDATE_INT);
	$ProductName = filter_input(INPUT_GET, "ProductName", FILTER_VALIDATE_INT);
	var_dump($ProudctId);
	var_dump($ProductName);
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//gets  a specific like associated based on its composite key
		if ($ProductId !== null && $ProductName !== null) {
			$product = Product::getProductByProductIdAndProductName($pdo, $ProductId, $ProductName);
			if($product!== null) {
				$reply->data = $product;
			}
			//if none of the search parameters are met throw an exception
		} else if(empty($ProductId) === false) {
			$product = Product::getProductByProductId($pdo, $ProductId)->toArray();
			if($product !== null) {
				$reply->data = $product;
			}
			//get all the products associated with the productName
		} else if(empty($productName) === false) {
			$product = Product::getProfuctByProductName($pdo, $ProductName)->toArray();
			if($product!== null) {
				$reply->data = $product;
			}
		} else {
			throw new InvalidArgumentException("incorrect search parameters ", 404);
		}
	} else if($method === "POST" || $method === "PUT") {
		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		if(empty($requestObject->ProductId) === true) {
			throw (new \InvalidArgumentException("No Product Id linked to product", 405));
		}
		if(empty($requestObject->ProductName) === true) {
			throw (new \InvalidArgumentException("No product name linked to the product", 405));
		}

		if($method === "POST") {
			// enforce the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to buy a product", 403));
			}
			$product = new Product($requestObject->productId, $requestObject->productName);
			$product->insert($pdo);
			$reply->message = "added product successfuly";
		}
		else if($method === "PUT") {
			//enforce that the end user has a XSRF token.
			verifyXsrf();
			//grab the like by its composite key
			$product = Product::getProductByProductIdAndLikeProductName($pdo, $requestObject->productId, $requestObject->productName);
			if($like === null) {
				throw (new RuntimeException("Like does not exist"));
			}
			//enforce the user is signed in and only trying to edit their own like
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $product->getLikeProfileId()) {
				throw(new \InvalidArgumentException("You are not allowed to delete this product", 403));
			}
			//preform the actual delete
			$like->delete($pdo);
			//update the message
			$reply->message = "Product successfully deleted";
		}
		// if any other HTTP request is sent throw an exception
	} else {
		throw new \InvalidArgumentException("invalid http request", 400);
	}
	//catch any exceptions that is thrown and update the reply status and message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);