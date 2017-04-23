<?php

/**
 * An example of what it is like to favorite a bad etsy site
 * @author Jabari Farrar<jfarrar1@cnm.edu>
 */
class Product implements  \JsonSerializable {

	//create state variables

	/**
	 * Id for this Product; this is the primary key
	 * @var int|null $productId
	 **/
	private $productId;

	/**
	 * Name for this Product
	 * @var string $productName
	 **/
	private $productName;

	/**
	 * Price of the product
	 * @var int $productPrice
	 **/
	private $productPrice;

	public function __construct(?int $newProductId, string $newProductName, float $newProductPrice) {
		try {
			$this->setProductId($newProductId);
			$this->setProductName($newProductName);
			$this->setProductPrice($newProductPrice);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	// accessors & mutators for each state variable]]]]

	/**
	 * accessor method for productId
	 * @return int|null value of productId*
	 **/
	public function getProductId():?int {
		return ($this->productId);
	}

	/**
	 * mutator method for productId
	 * @param int|null $newProductId new value of productId
	 * @throws \RangeException if $newProductId is not positive
	 * @throws \TypeError if $newProductId is not an integer *
	 **/
	public function setProductId(?int $newProductId) :
	// if profile id is null immediately return it if ($newProductId === null) {
	$this->productId = null;
	return;}
	//verify the product Id is postive
	if($newProductId <=0) throw (new \RangeException("profile id is not positive"));}
	//convert and store the product id
	$this->productId = $newProductId

	/**
	 * accessor method for productName
	 * @return string  value of productName
	 **/
	public function getProductName(): string {
		return ($this->productName);

	/**
	 * mutator method for productName
	 * @param string $newProductName new value of productName
	 * @throws \RangeException if $ProductName is >64 characters
	 * @throws \TypeError if $ProductName is not a string*
	 **/
	public function setProductName(string $newProductName): void {
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
	 * accessor method for productPrice
	 * @return int|null value of productPrice*
	 **/
	public function getProductPrice():?int {
		return ($this->productPrice);
	}

	/**
	 * mutator method for productPrice
	 * @param int|null $newProductPrice new value of productPrice
	 * @throws \RangeException if $newProductPrice is not positive
	 * @throws \TypeError if $newProductPrice is not an integer *
	 **/
	public function setProductPrice(?float $newProductPrice): void {
		// if productPrice is null immediately return it
		if($newProductPrice === null) {
			$this->productPrice = null;
			return;
		}
		//verify the productPrice is positive
		if($newProductPrice <= 0) {
			throw(new \RangeException ("productPrice is not positive"));
		}
		//convert and store productPrice
		$this->productPrice = $newProductPrice;
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
	}
}