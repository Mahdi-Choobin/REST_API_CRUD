<?php

class Product
{
    // db stuff
    private $connect;
    private $table = "products";

    // product properties
    public $id;
    public $product_name;
    public $category_name;
    public $description;
    public $price;
    public $created_at;

    // constructor with db connection
    public function __construct($db)
    {
        $this->connect = $db;
    }
    // getting products from our database
    public function read()
    {
        // create query
        $query = 'SELECT * FROM ' . $this->table;

        // prepare statement
        $stmt = $this->connect->prepare($query);
        // execute query
        $stmt->execute();

        return $stmt;
    }

    public function read_single()
    {
        // create query
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ? LIMIT 1';

        // prepare statment
        $stmt = $this->connect->prepare($query);
        // binfing param
        $stmt->bindParam(1, $this->id);
        // execute the query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id            = $row['id'];
        $this->product_name  = $row['product_name'];
        $this->category_name = $row['category_name'];
        $this->description   = $row['description'];
        $this->price         = $row['price'];
        $this->created_at    = $row['created_at'];
    }

    public function create()
    {
        // create query
        $query = 'INSERT INTO ' . $this->table . ' SET product_name = :product_name, category_name = :category_name, description = :description, price = :price';
        // prepare statment
        $stmt = $this->connect->prepare($query);
        // clean data
        $this->product_name  = htmlspecialchars(strip_tags($this->product_name));
        $this->category_name = htmlspecialchars(strip_tags($this->category_name));
        $this->description   = htmlspecialchars(strip_tags($this->description));
        $this->price         = htmlspecialchars(strip_tags($this->price));
        // binding of parameters
        $stmt->bindparam(':product_name', $this->product_name);
        $stmt->bindparam(':category_name', $this->category_name);
        $stmt->bindparam(':description', $this->description);
        $stmt->bindparam(':price', $this->price);
        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        // print error if something goas wrong
        printf("Error %s. \n", $stmt->error);
        return false;
    }

    // update product function
    public function update()
    {
        // create query
        $query = 'UPDATE ' . $this->table . ' 
        SET product_name = :product_name, category_name = :category_name, description = :description, price = :price
        WHERE id = :id';
        // prepare statment
        $stmt = $this->connect->prepare($query);
        // clean data
        $this->id            = htmlspecialchars(strip_tags($this->id));
        $this->product_name  = htmlspecialchars(strip_tags($this->product_name));
        $this->category_name = htmlspecialchars(strip_tags($this->category_name));
        $this->description   = htmlspecialchars(strip_tags($this->description));
        $this->price         = htmlspecialchars(strip_tags($this->price));
        // binding of parameters
        $stmt->bindparam(':product_name', $this->product_name);
        $stmt->bindparam(':category_name', $this->category_name);
        $stmt->bindparam(':description', $this->description);
        $stmt->bindparam(':price', $this->price);
        $stmt->bindparam(':id', $this->id);
        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        // print error if something goas wrong
        printf("Error %s. \n", $stmt->error);
        return false;
    }
    // delete function
    public function delete()
    {
        // create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        // prepare statement
        $stmt = $this->connect->prepare($query);
        // clean the data
        $this->id = htmlspecialchars(strip_tags($this->id));
        // binding the id parameter
        $stmt->bindParam(':id', $this->id);
        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        // print error if something goas wrong
        printf("Error %s. \n", $stmt->error);
        return false;
    }
}
