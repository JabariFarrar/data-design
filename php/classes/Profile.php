<?php

/**
 * An example of what it is like to favorite a bad etsy site
 * @author Jabari Farrar<jfarrar1@cnm.edu>
 */
class Profile implements \JsonSerializable{

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

	public function __construct(?int $newProfileId, string $newprofileEmail, string $newProfileActivationToken, string $newProfileHash, string $newProfilePhone, string $newProfileSalt) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileEmail($newprofileEmail);
			$this->setProfileHash($newProfileHash);
			$this->setProfilePhone($newProfilePhone);
			$this->setProfileSalt($newProfileSalt);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}


	/**
	 * accessor method for profileId
	 * @return int|null value of profileId*
	 **/
	public function getProfileId():?int {
		return ($this->profileId);
	}
	/**
	 * mutator method for  profile id
	 *
	 * @param int $newProfileId new value of  profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 **/
	public function setProfileId(int $newProfileId) : void {
		// verify the profile id is positive
		if($newProfileId <= 0) {
			throw(new \RangeException(" profile id is not positive"));
		}
		// convert and store the profile id
		$this->ProfileId = $newProfileId;
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
	public function setProductName(string $newProfileEmail): void {
		// verify the productPhone is secure
		$newProfilePhone = trim($newProductEmail);
		$newProfilePhone= filter_var($newProductEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileEmail) === true) {
			throw (new \InvalidArguementException ("profileEmail content is empty or insecure"));
		}
		//verify the profilePhone will fit in the database
		if(strlen($newProfileEmail) > 128) {
			throw(new \RangeException("profileEmail too long"));
		}
		// store the profile email
		$this->profileEmail = $newProfileEmail;

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
	 * @param int|null $newprofilePhone new value of profile phone
	 * @throws \RangeException if $newProfilePhone is not positive
	 * @throws \TypeError if $newProfilePhone is not an integer
	 **/
		public function setProfilePhone(?int $newProfilePhone) : void {
			//if profile id is null immediately return it
			if($newProfilePhone === null) {
				$this->profilePhone = null;
				return;
			}
			// verify the profile phone is positive
			if($newProfilePhone <= 0) {
				throw(new \RangeException("profile phone is not positive"));
			}
			// convert and store the profile phone
			$this->profilePhone = $newProfilePhone;
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
		// verify the profileSalt is secure
		$newProfileSalt = trim($newProfileSalt);
		$newProfileSalt = filter_var($newProfileSalt, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileSalt) === true) {
			throw (new \InvalidArguementException ("profileSalt content is empty or insecure"));
		}
		//verify the profileSalt will fit in the database
		if(strlen($newProfileSalt) > 64) {
			throw(new \RangeException("profileSalt too large"));
		}
		// store the profileSalt
		$this->profileSalt = $newProfileSalt;
	}
}
	/**
	 * inserts this Profile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		// enforce the profile Id is null (i.e., don't insert a profile that already exists)
		if($this->profileId !== null) {
			throw(new \PDOException("not a new profile"));
		}
		// create query template
		$query = "INSERT INTO profile(profileId, profileActivationToken, profileEmail, profileHash, profilePhone, profileSalt) VALUES(:profileId, :profileActivationToken, :profileEmail, :profileHash, :profilePhone, :profileSalt)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template

		$parameters = ["ProfileId" => $this->ProfileId, "profileActivationToken" => $this->profileActivationToken, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash,"profilePhone" => $this->profilePhone, "profileSalt" => $this->profileSalt];
		$statement->execute($parameters);
		// update the null profileId with what mySQL just gave us
		$this->profileId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// enforce the profileId is not null (i.e., don't delete a profile that hasn't been inserted)
		if($this->profileId === null) {
			throw(new \PDOException("unable to delete a profile that does not exist"));
		}
		// create query template
		$query = "DELETE FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["ProfileId" => $this->ProfileId];
		$statement->execute($parameters);
	}

	/**
	 * updates this Profile in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		// enforce the profileId is not null (i.e., don't update a profile that hasn't been inserted)
		if($this->profileId === null) {
			throw(new \PDOException("unable to update a profile that does not exist"));
		}
		// create query template
		$query = "UPDATE profile SET ProfileId = :ProfileId, profileActivationToken = :profileActivationTokent, profileEmail = : WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["ProfileId" => $this->ProfileId, "profileActivationToken" => $this->profileActivationToken, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash,"profilePhone" => $this->profilePhone, "profileSalt" => $this->profileSalt];
		$statement->execute($parameters);
	}
	/**
	 * gets the profileEmail by ProfileID
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $productId to search for
	 * @return \SplFixedArray array of Products found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getprofileIdByprofileEmail(\PDO $pdo, int $profileId) : \SplFixedArray {
		// sanitize the profile id
		$ProfileId = filter_var($profileId, FILTER_VALIDATE_INT);
		if($profileId <= 0) {
			throw(new \PDOException("profile id is not positive"));
		}
		// create query template
		$query = "SELECT profileId, profileEmail, profilePhone FROM `product WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["profileId" => $profileId];
		$statement->execute($parameters);
		// build the array of products
		$proudct = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profileId = new profileId($row["profileID"], $row["profilePhone"], $row["profileEmail"]);
				$profileIdId[$profileId->key()] = $profileId;
				$profileId->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profileID);

/**
 * formats the state variables for JSON serialization
 *
 * @return array resulting state variables to serialize
 **/
public function jsonSerialize() {
	$fields = get_object_vars($this);
}
}

