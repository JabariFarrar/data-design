<?php

/**
 * An example of what it is like to favorite a bad Etsy site
 * @author Jabari Farrar<jfarrar1@cnm.edu>
 */

class Favorite implements \JsonSerialize {
	use validateDate;


	/**
	 * favoriteId for this Profile;
	 * @var int|null $favoriteProfileId
	 **/
	private $favoriteProfileId;

	/**
	 * favoriteProductId for this Product
	 * @var int|null $favoriteProductId
	 **/
	private $favoriteProductId;

	/**
	 * favoriteDate of this product
	 * @var \DateTime $favoriteDate
	 **/
	private $favoriteDate;

	/**
	 * Constructor for this favorite
	 * @param int $favoriteProfileId of the parent profile
	 * @param int $favoriteProductId of the parent profile
	 * @param \ $favoriteDate | null $newfavoriteDate date the product was liked
	 * @throws \Exception if some other exception occurs
	 **/

	publicfunction __construct(int $newfavoriteProfileId, int $newfavoriteProductId, $newfavoriteDate = null) {
		try {
			$this->setfavoriteProfileId($newfavoriteProfileId);
			$this->setfavoriteProductId($newfavoriteProductId);
			$this->setfavoriteDate($newfavoriteDate);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	// accessors & mutators for each state variable]]]]
	/**
	 * accessor method for favoriteProfileId
	 * @return int|null value of favoriteProfileId*
	 **/

	public function getFavoriteProfileId():?int {
		return ($this->profileId);
	}

	/**
	 * mutator method for favoriteProfileId
	 * @param int|null $newfavoriteProfileId new value of favoriteProfileId
	 * @throws \RangeException if $newfavoriteProfileId is not positive
	 * @throws \TypeError if $newfavoriteProfileId is not an integer *
	 **/
	public function setfavoriteProfileId(?int $newfavoriteProfileId): void {

		//verfy the favoriteProfileID is positive
		if($newfavoriteProfileId <= 0) {
			throw(new\RangeException ("favorite ProfileId is not positive"));
		}
		// convert and store favoriteProfileId
		$this->favoriteProfileId = $newfavoriteProfileId;
	}

	/**
	 * accessor method for favoriteProductId
	 * @return int|null value of favoriteProductId*
	 **/
	public function getFavoriteProductId():?int {
		return ($this->productId);
	}

	/**
	 * mutator method for favoriteProductId
	 * @param int|null $newfavoriteProductId new value of favoriteProductId
	 * @throws \RangeException if $newfavoriteProductId is not positive
	 * @throws \TypeError if $newfavoriteProductId is not an integer *
	 **/
	public
	function setFavoriteProductId(?int $newfavoriteProductId): void {
		// if FavoritProductId is null immediately return it
		if($newfavoriteProductId === null) {
			$this->ProducteId = null;
			return;
		}
		//verfy the ProductID is positive
		if($newfavoriteProductId <= 0) {
			throw(new\RangeException ("favorite ProductId is not positive"));
		}
		// convert and store favoriteProductId
		$this->favoriteProductId = $newfavoriteProductId;
	}

	/**
	 * accessor method for favorite date
	 *
	 * @return \DateTime value of favorite date
	 **/
	public function getfavoriteDate(): \DateTime {
		return ($this->favoriteDate);
	}

	/**
	 * mutator method for favorite date
	 *
	 * @param \DateTime|string|null $newfavoriteDate favorite date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newfavoriteDate is not a valid object or string
	 * @throws \RangeException if $newfavoriteDate is a date that does not exist
	 **/
	// base case: if the date is null, use the current date and time
	if($newfavoriteDate === null) {
		$this->favoritetDate = new \DateTime();
		return;
	}
	// store the like date using the ValidateDate trait
	try {
		$newfavoriteDate = self::validateDateTime($newfavoriteDate);
	} catch(\InvalidArgumentException | \RangeException $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
	$this->favoriteDate = $newfavoriteDate;

	/**
	 * inserts this favorites into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		// enforce the favoriteId is null (i.e., don't insert a favorite that already exists)
		if($this->favoriteId !== null) {
			throw(new \PDOException("not a new favorite"));
		}
		// create query template
		$query = "INSERT INTO favorite(favoriteProfileId, favoriteProductId, favoriteDate) VALUES(:favoriteProfileId, :favoriteProductId, :favoriteDate)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->favoriteDate->format("Y-m-d H:i:s:u");
		$parameters = ["favoriteProfileId" => $this->favoriteProfileId, "favoriteProductId" => $this->favoriteProductId, "favoriteDate" => $formattedDate];
		$statement->execute($parameters);
		// update the null favoriteProfileId with what mySQL just gave us
		$this->favoriteProfileId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this favorite from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// enforce the favoriteProfileId is not null (i.e., don't delete a favorite that hasn't been inserted)
		if($this->favoriteProfileId === null) {
			throw(new \PDOException("unable to delete a favorite that does not exist"));
		}
		// create query template
		$query = "DELETE FROM favorite WHERE favoriteProfileId = :favoriteProfileId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["favoriteProfileId" => $this->favoriteProfileId];
		$statement->execute($parameters);
	}

	/**
 * gets the Like by favoriteProductID and favoriteProfileID
 *
 * @param \PDO $pdo PDO connection object
 * @param int $favoriteProfileId profile id to search for
 * @param int $favoriteProductId  id to search for
 * @return Like|null Like found or null if not found
 */
	public static function getfavoriteByLikefavoriteProductIdAndfavoriteProfileId(\PDO $pdo, int $favoriteProfileId, int $favoriteProductId) : ?Like {
		// sanitize the profile id and product id before searching
		if($favoriteProfileId <= 0) {
			throw(new \PDOException("profile id is not positive"));
		}
		if($favoriteProductId <= 0) {
			throw(new \PDOException("product id is not positive"));
		}
		// create query template
		$query = "SELECT favoriteProfileId, favoriteProductId, favoriteDate FROM `favorite` WHERE favoriteProfileId = :favoriteProfileId AND favoriteProductId = :favoriteProductId";
		$statement = $pdo->prepare($query);
		// bind the product Id and profile id to the place holder in the template
		$parameters = ["favoriteProfileId" => $favoriteProfileId, "favoriteProductId" => $favoriteProductId];
		$statement->execute($parameters);
		// grab the favorite from mySQL
		try {
			$favorite = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$like = new Favorite($row["favoriteProfileId"], $row["favoriteProductId"], $row["favoriteDate"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($favorite);
	}

/**
 * updates this Favorite in mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
	public function update(\PDO $pdo) : void {
		// enforce the favoriteProfileId is not null (i.e., don't update a tweet that hasn't been inserted)
		if($this->favoriteProfileId === null) {
			throw(new \PDOException("unable to update a tweet that does not exist"));
		}
		// create query template
		$query = "UPDATE Favorite SET favoriteProfileId = : favoriteProfileId, favoriteProductId = :favoriteProductID, favoriteDate = :favoritetDate WHERE favoriteProfileId = :favoriteProfileId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->favoritetDate->format("Y-m-d H:i:s:u");
		$parameters = ["favoriteProfileId" => $this->favoriteProfileId, "favoriteProductId" => $this->favoriteProductId, "tweetDate" => $formattedDate, "favoriteProfileId" => $this->favoriteProfileIdId];
		$statement->execute($parameters);
	}

/**
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
