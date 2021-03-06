<?php

/**
 * An example of what it is like to favorite a bad etsy site
 * @author Jabari Farrar<jfarrar1@cnm.edu>
 */
namespace Edu\Cnm\DataDesign;
class Product implements  \JsonSerialize {

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

	public function __construct(?int $newProductId, ?string $newProductName, ?float $newProductPrice) {
		try {
			$this->setProductId($newProductId);
			$this->setProductName($newProductName);
			$this->setProductPrice($newProductPrice);
		}
		//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for productId
	 * @return int|null value of productId
	 **/
	public function getProductId(): int {
		return ($this->productId);
	}

	/**
	 * mutator method for productId
	 * @param int|null $newProductId new value of productId
	 * @throws \RangeException if $newProductId is not positive
	 * @throws \TypeError if $newProductId is not an integer
	 **/
	public function setProductId(?int $newProductId) : void {
	 if ($newProductId === null) {
	$this->productId = null;
	return;
	}
	//verify the productId is postive
	if($newProductId <= 0) {
	 	throw(new \RangeException("product id is not positive"));
	}
	//convert and store the product id
	$this->productId = $newProductId;
}

	/**
	 * accessor method for productName
	 * @return string  value of productName
	 **/
	public function getProductName(): string {
	return ($this->productName);
}

	/**
	 * mutator method for productName
	 * @param string $newProductName new value of productName
	 * @throws \RangeException if $ProductName is >64 characters
	 * @throws \TypeError if $ProductName is not a string*
	 **/
	public function setProductName(?string $newProductName): void {
		// verify the productName is secure
		$newProductName = trim($newProductName);
		$newProductName = filter_var($newProductName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProductName) === true) {
			throw (new \InvalidArgumentException ("productName content is empty or insecure"));
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
	 * @param float|null $newProductPrice new value of productPrice
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
	 * inserts this product into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		// enforce the productId is null (i.e., don't insert a productID that already exists)
		if($this->productId !== null) {
			throw(new \PDOException("not a new productId"));
		}
		// create query template
		$query = "INSERT INTO product(productId, productName, productPrice) VALUES(:productId, :productName, :productPrice)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["productId" => $this->productId, "productName" => $this->productName, "productPrice" => "productPrice"];
		$statement->execute($parameters);
		// update the null ProductId with what mySQL just gave us
		$this->productId = intval($pdo->lastInsertId());
	}
	/**
	 * deletes from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// enforce the productId is not null (i.e., don't delete a product that hasn't been inserted)
		if($this->productId === null) {
			throw(new \PDOException("unable to delete a product that does not exist"));
		}
		// create query template
		$query = "DELETE FROM product WHERE productId = :productId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["productId" => $this->productId];
		$statement->execute($parameters);
	}
		/**
		 * updates this Product in mySQL
		 *
		 * @param \PDO $pdo PDO connection object
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError if $pdo is not a PDO connection object
		 **/
		public function update(\PDO $pdo) : void {
			// enforce the ProductId is not null (i.e., don't update a ProductId that hasn't been inserted)
			if($this->productId === null) {
				throw(new \PDOException("unable to update a product ID that does not exist"));
			}
			// create query template
			$query = "UPDATE Product SET productId = :productId, productName = :productName, productPrice = :productPrice WHERE productId = :productId";
			$statement = $pdo->prepare($query);
			// bind the member variables to the place holders in the template
			$parameters = ["productId" => $this->productId, "productName" => $this->productName, "productPrice" => $this->productPrice];
			$statement->execute($parameters);
		}
	/**
	 * gets the Product by ProductId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param INT $productId to search for
	 * @return \SplFixedArray array of profile found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProductByProductId(\PDO $pdo, string $productId): ?Product {
		$productId = trim($productId);
		// sanitize the profile id
		$productId = filter_var($productId, FILTER_SANITIZE_NUMBER_INT);

		// create query template
		$query = "SELECT productId, productName, productPrice FROM product WHERE productId = :productId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["productId" => $productId];
		$statement->execute($parameters);
		//binding profile to variable
		try{
			$profile = null;
			$statement->getFetchMode(\PDO::FETCH_ASSOC);
			$row =$statement->fetch();
			if($row !== false) {
				$product = new Product($row["productId"], $row["productName"], $row["productPrice"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		return($profile);
	}
	/**
	 * gets the Product by ProductName
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param INT $productName to search for
	 * @return \SplFixedArray array of profile found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProductByProductName(\PDO $pdo, string $productName): ?Product {
		$productName = trim($productName);
		// sanitize the profile name
		$productName = filter_var($productName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// create query template
		$query = "SELECT productId, productName, productPrice FROM product WHERE productName = :productName";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["productName" => $productName];
		$statement->execute($parameters);
		//binding profile to variable
		try{
			$profile = null;
			$statement->getFetchMode(\PDO::FETCH_ASSOC);
			$row =$statement->fetch();
			if($row !== false) {
				$product = new Product($row["productId"], $row["productName"], $row["productPrice"]);
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