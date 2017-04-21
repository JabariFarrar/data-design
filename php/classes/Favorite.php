<?php

/**
 * An example of what it is like to favorite a bad etsy site
 * @author Jabari Farrar<jfarrar1@cnm.edu>
 */
class Favorite {

	//create state variables

	/**
	 * favoriteId for this Profile;
	 * @var int|null $favoriteProfileId
	 **/
	private $favoriteProfileId;

	/**
	 * FavoriteId for this Product
	 * @var int|null $favoriteProductId
	 **/
	private $favoriteProductId;

	/**
	 * favoriteDate of this product
	 * @var \DateTime $favoriteDate
	 **/
	private $favoriteDate;

	public function __construct(?int $newfavoriteProfileId, int $newfavoriteProductId, float $newfavoriteDate = null) {
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
		return ($this->productId);
	}
	/**
	 * mutator method for favoriteProfileId
	 * @param int|null $newfavoriteProfileId new value of favoriteProfileId
	 * @throws \RangeException if $newfavoriteProfileId is not positive
	 * @throws \TypeError if $newfavoriteProfileId is not an integer *
	 **/
	public function setfavoriteProfileId(?int $newfavoriteProfileId) :void {
		// if FavoritProfileId is null immediately return it
		if($newfavoriteProfileId === null) {
			$this->ProfileId = null;
			return;
		}
		//verfy the ProfileID is positive
		if($newfavoriteProfileId <= 0) {
			throw(new\RangeException ("favoriteProfileId is not positive"));
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
	public function setfavoriteProductId(?int $newfavoriteProductId) :void {
		// if FavoritProductId is null immediately return it
		if($newfavoriteProductId === null) {
			$this->ProducteId = null;
			return;
		}
		//verfy the ProductID is positive
		if($newfavoriteProductId <= 0) {
			throw(new\RangeException ("favoriteProductId is not positive"));
		}
		// convert and store favoriteProductId
		$this->favoriteProductId = $newfavoriteProductId;
	}