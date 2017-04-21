<?php

/**
 * An example of what it is like to favorite a bad etsy site
 * @author Jabari Farrar<jfarrar1@cnm.edu>
 */
class Profile {

	//create state variables

	/**
	 * Id for this Profile; this is the primary key
	 * @var int|null $profileId
	 **/
	private $profileId;

	/**
	 * Activation Token for this Profile;
	 * @var string $profileActivationToken
	 **/
	private $profileActivationToken;

	/**
	 * Email for this Profile
	 * @var string $ProfileEmail
	 **/
	private $profileEmail;

	/**
	 * Hash for this Profile
	 * @var string $ProfileHash
	 **/
	private $profileHash;

	/**
	 * Phone for this Profile
	 * @var string $profilePhone
	 **/
	private $profilePhone;

	/**
	 * Salt for this Profile
	 * @var string $profileSalt
	 **/
	private $profileSalt;

	public function __construct(?int $newProfileId, string $newProfileActivationToken, string $newProfileHash, string $newProfilePhone, string $newProfileSalt) {
		try {
			$this->setProfileId($newProfileId);
			$this->setprofileActivationToken($newProfileActivationToken);
			$this->setProfileHash($newProfileHash);
			$this->setProfilePhone($newProfilePhone);
			$this->setProfileSalt($newProfileSalt);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	// accessors & mutators for each state variable]]]]

	/**
	 * accessor method for profileId
	 * @return int|null value of profileId*
	 **/
	public function getProfileId():?int {
		return ($this->profileId);
	}

	/**
	 * mutator method for profileId
	 * @param int|null $newProfileId new value of profileId
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer *
	 **/
	public function setProfileId(?int $newProfileId): void {
		// if profileId is null immediately return it
		if($newProfileId === null) {
			$this->profileId = null;
			return;
		}
		//verfy the profileID is positive
		if($newProfileId <= 0) {
			throw(new\RangeException ("profileId is not positive"));
		}
		// convert and store profileId
		$this->profileId = $newProfileId;
	}

	/**
	 * accessor method for profileActivationToken
	 * @return string  value of ActivationToken
	 **/
	public function getActivationToken(): string {
		return ($this->profileActivationToken);
	}

	/**
	 * mutator method for activationToken
	 * @param string $newActivationToken new value of activationToken
	 * @throws \RangeException if $ActivationToken is >32 characters
	 * @throws \TypeError if $ActivationToken is not a string*
	 **/
	public function setActivationToken(string $newProfileActivationToken): void {
		// verify the productName is secure
		$newProductName = trim($newProductName);
		$newProductName = filter_var($newProductName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProductName) === true) {
			throw (new \InvalidArguementException ("productName content is empty or insecure"));
		}
		//verify the productName will fit in the database
		if(strlen($newProductName) > 64) {
			throw(new \RangeException("productName too large"));
		}
		// store the productName
		$this->productName = $newProductName;
	}

	/**
	 * accessor method for profileEmail
	 * @return string  value of profileEmail
	 **/
	public function getProfileEmail(): string {
		return ($this->profileEmail);
	}

	/**
	 * mutator method for profileEmail
	 * @param string $newProfileEmail new value of profileEmail
	 * @throws \RangeException if $ProfileEmail is >128 characters
	 * @throws \TypeError if $ProfileEmail is not a string*
	 **/
	public function setProfileEmail(string $newProfileEmail): void {
		// verify the productName is secure
		$newProductName = trim($newProductName);
		$newProductName = filter_var($newProductName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProductName) === true) {
			throw (new \InvalidArguementException ("productName content is empty or insecure"));
		}
		//verify the productName will fit in the database
		if(strlen($newProductName) > 64) {
			throw(new \RangeException("productName too large"));
		}
		// store the productName
		$this->productName = $newProductName;
	}

	/**
	 * accessor method for profileHash
	 * @return string  value of profileHash
	 **/
	public function getProfileHash(): string {
		return ($this->ProfileHash);
	}

	/**
	 * mutator method for profileHash
	 * @param string $newProfileHash new value of profileHash
	 * @throws \RangeException if $ProfileHash is >128 characters
	 * @throws \TypeError if $ProfileHash is not a string*
	 **/
	public function setProfileHash(string $newProfileHash): void {
		// verify the productName is secure
		$newProductName = trim($newProductName);
		$newProductName = filter_var($newProductName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProductName) === true) {
			throw (new \InvalidArguementException ("productName content is empty or insecure"));
		}
		//verify the productName will fit in the database
		if(strlen($newProductName) > 64) {
			throw(new \RangeException("productName too large"));
		}
		// store the productName
		$this->productName = $newProductName;
	}

	/**
	 * accessor method for profilePhone
	 * @return string  value of profilePhone
	 **/
	public function getProfilePhone(): string {
		return ($this->ProfilePhone);
	}

	/**
	 * mutator method for profilePhone
	 * @param string $newProfilePhone new value of profilePhone
	 * @throws \RangeException if $ProfilePhone is >32 characters
	 * @throws \TypeError if $ProfilePhone is not a string*
	 **/
	public function setProfilePhone(string $newProfilePhone): void {
		// verify the productName is secure
		$newProductName = trim($newProductName);
		$newProductName = filter_var($newProductName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProductName) === true) {
			throw (new \InvalidArguementException ("productName content is empty or insecure"));
		}
		//verify the productName will fit in the database
		if(strlen($newProductName) > 64) {
			throw(new \RangeException("productName too large"));
		}
		// store the productName
		$this->productName = $newProductName;
	}

	/**
	 * accessor method for profileSalt
	 * @return string  value of profileSalt
	 **/
	public function getProfileSalt(): string {
		return ($this->ProfileSalt);
	}

	/**
	 * mutator method for profileSalt
	 * @param string $newProfileSalt new value of profileSalt
	 * @throws \RangeException if $ProfileSalt is >64 characters
	 * @throws \TypeError if $ProfileSalt is not a string*
	 **/
	public function setProfileSalt(string $newProfileSalt): void {
		// verify the productName is secure
		$newProductName = trim($newProductName);
		$newProductName = filter_var($newProductName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProductName) === true) {
			throw (new \InvalidArguementException ("productName content is empty or insecure"));
		}
		//verify the productName will fit in the database
		if(strlen($newProductName) > 64) {
			throw(new \RangeException("productName too large"));
		}
		// store the productName
		$this->productName = $newProductName;
	}
}
/**
 * accessor method for favorite date
 *
 * @return \DateTime value of favorite date
 **/
public function getFavoriteDate() : \DateTime {
	return($this->favoriteDate);
}

/**
 * mutator method for favorite date
 *
 * @param \DateTime|string|null $newFavoriteDate date as a DateTime object or string (or null to load the current time)
 * @throws \InvalidArgumentException if $newFavoriteDate is not a valid object or string
 * @throws \RangeException if $newFavoriteDate is a date that does not exist
 **/
public function setFavoriteDate($newFavoriteDate = null) : void {
	// base case: if the date is null, use the current date and time
	if($newFavoriteDate === null) {
		$this->FavoriteDate = new \DateTime();
		return;
	}
	// store the like date using the ValidateDate trait
	try {
		$newFavoriteDate = self::validateDateTime($newFavoriteDate);
	} catch(\InvalidArgumentException | \RangeException $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
	$this->tweetDate = $newFavoriteDate;
}

