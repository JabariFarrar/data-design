<?php

require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
//require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\DataDesign\{Profile};

/** api for the Profile Class
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
			//grab the mySQL connection
			$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/jfarrar1.ini");

			//mock a logged in user by mocking the session and assigning a specific user to it.
			//this is only for testing purposes and should not be used in the live code.
			//$_SESSION["profile"] = Profile::getProfileBYProfileId($pdo, 732);


			//determine which HTTP method was used
			$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

			//sanitize input
			$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
			$profileId = filter_input(INPUT_GET, "profileId", FILTER_VALIDATE_INT);
			$profilePhone = filter_input(INPUT_GET, "profilePhone", FILTER_VALIDATE_INT);
			$profileActivationToken = filter_input(INPUT_GET, "profileActivationToken", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			$profilePassword = filter_input(INPUT_GET, "profilePassword", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

			//make sure the id is valid for methods that require it
			if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
				throw(new InvalidArgumentException("id cannot be empty or negative", 405));
			}

// handle GET request - if id is present, that profile is returned, otherwise all profiles are returned
			if($method === "GET") {
				//set XSRF cookie
				setXsrfCookie();
				//get a specific profile or all profile and update reply
				if(empty($id) === false) {
					$profile = Profile::getProfileByProfileId($pdo, $id);
					if($profile !== null) {
						$reply->data = $profile;
					}
				} else if(empty($profileId) === false) {
					$profile = Profile::getProfileByProfilePhone($pdo, $profilePhone)->toArray();
					if($profile !== null) {
						$reply->data = $profile;
					}
				} else if(empty($profileActivationToken) === false) {
					$profile = Profile::getProfileByProfileActivationToken($pdo, $profileActivationToken)->toArray();
					if($profile !== null) {
						$reply->data = $profile;
					}
				} else if(empty($profileEmail) === false) {
					$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail)->toArray();
					if($profile !== null) {
						$reply->data = $profile;
					}
				} else {
					$profile = Profile::getAllProfiles($pdo)->toArray();
					if($profile !== null) {
						$reply->data = $profiles;
					}
				}
			} else if($method === "PUT" || $method === "POST") {
				verifyXsrf();
				$requestContent = file_get_contents("php://input");
				// Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
				$requestObject = json_decode($requestContent);
				// This Line Then decodes the JSON package and stores that result in $requestObject
				//make sure tweet content is available (required field)

				if(empty($requestObject->profileId) === true) {
					throw(new \InvalidArgumentException ("No content for Profile.", 405));
				}

				//  make sure profileId is available
				if(empty($requestObject->profileId) === true) {
					throw(new \InvalidArgumentException ("No Profile ID.", 405));
				}
				//perform the actual put or post
				if($method === "PUT") {
					//enforce that the end user has a XSRF token.
					verifyXsrf();
					// retrieve the profile to update
					$profile = Profile::getProfileByProfileId($pdo, $id);
					if($profile === null) {
						throw(new RuntimeException("Profile does not exist", 404));
					}
					//enforce the user is signed in and only trying to edit their own profile
					if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $profile->getProfileId()) {
						throw(new \InvalidArgumentException("You are not allowed to edit this profile", 403));
					}
					// update all attributes
					$profile->setProfileEmail($requestObject->profileEmail);
					$profile->setProfileHash($requestObject->profileHash);
					$profile->setProfilePhone($requestObject->profilePhone);
					$profile->setProfileSalt($requestObject->profileSalt);
					$profile->update($pdo);
					// update reply
					$reply->message = "Profile updated OK";
				} else if($method === "POST") {
					//enforce that the end user has a XSRF token.
					verifyXsrf();
					// enforce the user is signed in
					if(!empty($_SESSION["profile"]) === true) {
						throw(new \InvalidArgumentException("you already have an account", 403));
					}
					if(!empty(Profile::getProfileByProfileEmail($pdo, $requestObject->profileEmail))){
						throw(new \InvalidArgumentException("this e-mail already exists", 403));
					}
					//Refrenced from Sprout-swap
					$salt = bin2hex(random_bytes(128));
					$hash = hash_pbkdf2("sha512", $profilePassword, $salt, 262144);
					$profileActivationToken = bin2hex(random_bytes(32));
					// create new profile and insert into the database
					$profile = new Profile (null,  $profileActivationToken,$requestObject->profileEmail, $hash, $requestObject->profilePhone, $salt);
					$profile->insert($pdo);
					// update reply
					$reply->message = "Profile created OK";
				}
			} else if($method === "DELETE") {
				//enforce that the end user has a XSRF token.
				verifyXsrf();
				// retrieve the Profile to be deleted
				$profile = Profile::getProfileByProfileId($pdo, $id);
				if($profile === null) {
					throw(new RuntimeException("Profile does not exist", 404));
				}
				//enforce the user is signed in and only trying to edit their own profile
				if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $profile->getProfileId()) {
					throw(new \InvalidArgumentException("You are not allowed to delete this profile", 403));
				}
				// delete profile
				$profile->delete($pdo);
				// update reply
				$reply->message = "Profile deleted OK";
			} else {
				throw (new InvalidArgumentException("Invalid HTTP method request"));
			}
// update the $reply->status $reply->message
		} catch(\Exception | \TypeError $exception) {
			$reply->status = $exception->getCode();
			$reply->message = $exception->getMessage();
		}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
		}
