<?php

/**
 * An example of what it is like to favorite a bad etsy site
 * @author Jabari Farrar<jfarrar1@cnm.edu>
 */
namespace Edu\Cnm\DataDesign;
class Profile implements \JsonSerialize {

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

	public function __construct(?int $newProfileId,  string $newProfileActivationToken, string $newprofileEmail, string $newProfileHash, string $newProfilePhone, string $newProfileSalt) {
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
	 * mutator method for profile id
	 *
	 * @param int $newProfileId new value of  profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 **/
	public function setProfileId(int $newProfileId): void {
		// verify the profile id is positive
		if($newProfileId <= 0) {
			throw(new \RangeException("profile id is not positive"));
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
	 * @param string $newpProfileActivationToken new value of profileActivationToken
	 * @throws \RangeException if $newProfileActivationToken is >32 characters
	 * @throws \TypeError if $newProfileActivationToken is not a string*
	 **/
	public function setProfileActivationToken(string $newProfileActivationToken): void {
		// verify the ProfileActivationToken is secure
		$newProfileActivationToken = trim($newProfileActivationToken);
		$newProfileActivationToken = filter_var($newProfileActivationToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileActivationToken) === true) {
			throw (new \InvalidArgumentException ("Profile Activation Token is empty or insecure"));
		}
		//verify the profile Activation Token will fit in the database
		if(strlen($newProfileActivationToken) > 32) {
			throw(new \RangeException("Profile Activation Token too large"));
		}
		// store the profileActivationToken
		$this->profileActivationToken = $newProfileActivationToken;
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
	 * @throws \TypeError if $ProfileEmail is not a string
	 **/
	public function setProfileEmail(string $newProfileEmail): void {
		// verify the profileEmail is secure
		$newProfileEmail = trim($newProfileEmail);
		$newProfilePhone = filter_var($newProfileEmail, FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
		if(empty($newProfileEmail) === true) {
			throw (new \InvalidArgumentException ("profile Email content is empty or insecure"));
		}
		//verify the profilePhone will fit in the database
		if(strlen($newProfileEmail) > 128) {
			throw(new \RangeException("profile Email too long"));
		}
		// store the profile email
		$this->profileEmail = $newProfileEmail;
	}

		/**
		 * accessor method for profileHash
		 * @return string  value of profileHash
		 **/
		public function getProfileHash(): string {
			return ($this->profileHash);
		}

		/**
		 * mutator method for profileHash
		 * @param string $newProfileHash new value of profileHash
		 * @throws \RangeException if $ProfileHash is >128 characters
		 * @throws \TypeError if $ProfileHash is not a string*
		 * @throws \InvalidArgumentException if $newProfileHash is empty or insecure
		 **/
		public function setProfileHash(string $newProfileHash): void {
			// verify the profileHash is secure
			$newProfileHash = trim($newProfileHash);
			$newProfileHash = filter_var($newProfileHash, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newProfileHash) === true) {
				throw (new \InvalidArgumentException ("profile hash content is empty or insecure"));
			}
			//verify the productName will fit in the database
			if(strlen($newProfileHash) !== 128) {
				throw(new \RangeException("productName too large"));
			}
			if(!ctype_xdigit($newProfileHash)) {
				throw(new \InvalidArgumentException("profile salt is empty or insecure"));
			}
			// store the productName
			$this->profileHash = $newProfileHash;
		}

		/**
		 * accessor method for profilePhone
		 * @return string  value of profilePhone
		 **/
		public function getProfilePhone(): string {
			return ($this->profilePhone);
		}

		/**
		 * mutator method for profilePhone
		 * @param int|null $newprofilePhone new value of profile phone
		 * @throws \RangeException if $newProfilePhone is not positive
		 * @throws \TypeError if $newProfilePhone is not an integer
		 **/
		public function setProfilePhone(?int $newProfilePhone): void {
			//if profile phone is null immediately return it
			$newProfilePhone = trim($newProfilePhone);
			$newProfilePhone = filter_var($newProfilePhone, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newProfilePhone) === true) {
				throw (new \InvalidArgumentException ("profile phone content is empty or insecure"));
			}
			//verify the profilePhone will fit in the database
			if(strlen($newProfilePhone) > 32) {
				throw(new \RangeException("profile phone is too large"));
			}
			// convert and store the profile phone
			$this->profilePhone = $newProfilePhone;
		}


		/**
		 * accessor method for profileSalt
		 * @return string  value of profileSalt
		 **/
		public function getProfileSalt(): string {
			return($this->profileSalt);
		}

		/**
		 * mutator method for profileSalt
		 * @param string $newProfileSalt new value of profileSalt
		 * @throws \RangeException if $ProfileSalt is >64 characters
		 * @throws \TypeError if $ProfileSalt is not a string
		 * @throws \InvalidArgumentException if proifleSalt is hexidecimal digits
		 **/
		public
		function setProfileSalt(string $newProfileSalt): void {
			// verify the profileSalt is secure
			$newProfileSalt = trim($newProfileSalt);
			$newProfileSalt = filter_var($newProfileSalt, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newProfileSalt) === true) {
				throw (new \InvalidArgumentException ("profileSalt content is empty or insecure"));
			}
			//verify the profileSalt will fit in the database
			if(strlen($newProfileSalt) !== 64) {
				throw(new \RangeException("profile Salt too large"));
			}
			if(!ctype_xdigit($newProfileSalt)) {
				throw(new \InvalidArgumentException("profile salt is empty or insecure"));
			}
			// store the profileSalt
			$this->profileSalt = $newProfileSalt;
		}


	/**
	 * inserts this Profile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		// enforce the profile Id is null (i.e., don't insert a profile that already exists)
		if($this->profileId !== null) {
			throw(new \PDOException("not a new profile"));
		}
		// create query template
		$query = "INSERT INTO profile(profileId, profileActivationToken, profileEmail, profileHash, profilePhone, profileSalt) VALUES(:profileId, :profileActivationToken, :profileEmail, :profileHash, :profilePhone, :profileSalt)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template

		$parameters = ["profileId" => $this->profileId, "profileActivationToken" => $this->profileActivationToken, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profilePhone" => $this->profilePhone, "profileSalt" => $this->profileSalt];
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
	public function delete(\PDO $pdo): void {
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
	public function update(\PDO $pdo): void {
		// enforce the profileId is not null (i.e., don't update a profile that hasn't been inserted)
		if($this->profileId === null) {
			throw(new \PDOException("unable to update a profile that does not exist"));
		}
		// create query template
		$query = "UPDATE profile SET profileId = :profileId, profileActivationToken = :profileActivationTokent, profileEmail = : WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["profileId" => $this->profileId, "profileActivationToken" => $this->profileActivationToken, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profilePhone" => $this->profilePhone, "profileSalt" => $this->profileSalt];
		$statement->execute($parameters);
	}

	/**
	 * gets the Profile by Profile Email
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileEmailto search for
	 * @return \SplFixedArray array of Products found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileEmail(\PDO $pdo, string $profileEmail): ?Profile {
		$profileEmail = trim($profileEmail);
		// sanitize the profile id
		$profileEmail = filter_var($profileEmail, FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);

		// create query template
		$query = "SELECT profileId, profileActivationToken, profileEmail, profileHash, profilePhone, profileSalt FROM profile WHERE profileEmail = :profileEmail";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["profileEmail" => $profileEmail];
		$statement->execute($parameters);
		//binding profile to variable
		try{
				$profile = null;
				$statement->getFetchMode(\PDO::FETCH_ASSOC);
				$row =$statement->fetch();
				if($row !== false) {
					$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileEmail"], $row["profileHash"], $row["profilePhone"], $row["profileSalt"]);
				}
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}

		return($profile);
	}
	/**
	 * gets the Profile by Profile Phone
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param INT $profilePhone to search for
	 * @return \SplFixedArray array of profile found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfilePhone(\PDO $pdo, string $profilePhone): ?Profile {
		$profilePhone = trim($profilePhone);
		// sanitize the profile id
		$profilePhone = filter_var($profilePhone, FILTER_SANITIZE_NUMBER_INT);

		// create query template
		$query = "SELECT profileId, profileActivationToken, profileEmail, profileHash, profilePhone, profileSalt FROM profile WHERE profileEmail = :profileEmail";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["profilePhone" => $profilePhone];
		$statement->execute($parameters);
		//binding profile to variable
		try{
			$profile = null;
			$statement->getFetchMode(\PDO::FETCH_ASSOC);
			$row =$statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileEmail"], $row["profileHash"], $row["profilePhone"], $row["profileSalt"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		return($profile);
	}
	/**
	 * gets the Profile by ProfileId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param INT $profileId to search for
	 * @return \SplFixedArray array of profile found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileId(\PDO $pdo, string $profileId): ?Profile {
		$profileId = trim($profileId);
		// sanitize the profile id
		$profileId = filter_var($profileId, FILTER_SANITIZE_NUMBER_INT);

		// create query template
		$query = "SELECT profileId, profileActivationToken, profileEmail, profileHash, profilePhone, profileSalt FROM profile WHERE profileEmail = :profileEmail";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["profileId" => $profileId];
		$statement->execute($parameters);
		//binding profile to variable
		try{
			$profile = null;
			$statement->getFetchMode(\PDO::FETCH_ASSOC);
			$row =$statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileEmail"], $row["profileHash"], $row["profilePhone"], $row["profileSalt"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		return($profile);
	}
	/**
	 * gets the Profile by ProfileActivationToken
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileActivationToken to search for
	 * @return \SplFixedArray array of profile found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileActivationToken(\PDO $pdo, string $profileActivationToken): ?Profile {
		$profileActivationToken = trim($profileActivationToken);
		// sanitize the profile id
		$profileId = filter_var($profileActivationToken, FILTER_SANITIZE_STRING);

		// create query template
		$query = "SELECT profileId, profileActivationToken, profileEmail, profileHash, profilePhone, profileSalt FROM profile WHERE profileEmail = :profileEmail";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["profileActivationToken" => $profileActivationToken];
		$statement->execute($parameters);
		//binding profile to variable
		try{
			$profile = null;
			$statement->getFetchMode(\PDO::FETCH_ASSOC);
			$row =$statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileEmail"], $row["profileHash"], $row["profilePhone"], $row["profileSalt"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		return($profile);
	}


	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}
}


