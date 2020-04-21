<?php
require ("Entities/CoffeeEntity.php");
//Contains db related code for the Coffee page
class CoffeeModule 
{
    //Get all coffee types from the db and return them in an array
    function GetCoffeeTypes()
    {
        require 'Credentials.php';
        //open connection and select db
        $con=mysqli_connect($host,$user,$passwd,$database) or die(mysql_error());
        //mysql_select_db($database);
        $result = mysqli_query($con,"SELECT DISTINCT type FROM coffee") or die(mysqli_error($con));
        $types = array();
        
        //Get data from the database.
        while($row = mysqli_fetch_array($result))
        {
        array_push($types, $row[0]);
        }
        //Cloce connection and return result
        mysqli_close($con);
        return $types;
    }
    //Get coffeeEntity objects from the db and return them in an array.
    function GetCoffeeByType($type)
    {
        require 'Credentials.php';
        
        //Open connection and select db.
        $con=mysqli_connect($host, $user, $passwd, $database) or die(mysql_error());
        //mysql_select_db($database);
        
        $query = "SELECT * FROM coffee WHERE type LIKE '$type'";
        $result = mysqli_query($con,$query) or die(mysqli_error($con));
        $coffeeArray = array();
        
        //Get data from db
        while($row = mysqli_fetch_array($result))
        {
            $id = $row[0];
            $name = $row[1];
            $type = $row[2];
            $price = $row[3];
            $roast = $row[4];
            $country = $row[5];
            $image = $row[6];
            $review = $row[7];
            
            //Create coffee objects adn store them in a array.
            $coffee = new CoffeeEntity($id, $name, $type, $price, $roast, $country, $image, $review);
            array_push($coffeeArray, $coffee);
        }
        
        //Cloce connection and return result
        mysqli_close($con);
        return $coffeeArray;
    }
    
    function GetCoffeeById($id)
    {
        require 'Credentials.php';
        
        //Open connection and select db.
        $con=mysqli_connect($host, $user, $passwd, $database) or die(mysql_error());
        //mysql_select_db($database);
        
        $query = "SELECT * FROM coffee WHERE id = $id";
        $result = mysqli_query($con,$query) or die(mysqli_error($con));
      
        
        //Get data from db
        while($row = mysqli_fetch_array($result))
        {
            $name = $row[1];
            $type = $row[2];
            $price = $row[3];
            $roast = $row[4];
            $country = $row[5];
            $image = $row[6];
            $review = $row[7];
            
            //Create coffee objects.
            $coffee = new CoffeeEntity($id, $name, $type, $price, $roast, $country, $image, $review);
     
        }
        
        //Cloce connection and return result
        mysqli_close($con);
        return $coffee;
    }
    
    function InsertCoffee(CoffeeEntity $coffee)
    {
        
        require 'Credentials.php';
        
        //Open connection and select db.
        $con=mysqli_connect($host, $user, $passwd, $database) or die(mysql_error());
        $query = sprintf("INSERT INTO coffee (name, type, price, roast, country, image,review ) 
                VALUES ('%s','%s','%s','%s','%s','%s','%s')",
                mysqli_real_escape_string($con, $coffee->name),
                mysqli_real_escape_string($con, $coffee->type),
                mysqli_real_escape_string($con, $coffee->price),
                mysqli_real_escape_string($con, $coffee->roast),
                mysqli_real_escape_string($con, $coffee->country),
                mysqli_real_escape_string($con, "Images/Coffee/". $coffee->image),
                mysqli_real_escape_string($con, $coffee->review));
        //Execute query and close connection
        mysqli_query($con,$query) or die(mysqli_error($con));
        mysqli_close($con);
    }
    
    function UpdateCoffee($id, CoffeeEntity $coffee)
    {
        require 'Credentials.php';
        
        //Open connection and select db.
        $con=mysqli_connect($host, $user, $passwd, $database) or die(mysql_error());
        $query = sprintf("UPDATE coffee SET name = '%s', type = '%s', price = '%s', roast = '%s', country = '%s', image = '%s', review = '%s' WHERE id = $id",
                mysqli_real_escape_string($con, $coffee->name),
                mysqli_real_escape_string($con, $coffee->type),
                mysqli_real_escape_string($con, $coffee->price),
                mysqli_real_escape_string($con, $coffee->roast),
                mysqli_real_escape_string($con, $coffee->country),
                mysqli_real_escape_string($con, "Images/Coffee/". $coffee->image),
                mysqli_real_escape_string($con, $coffee->review));
        //Execute query and close connection
        mysqli_query($con,$query) or die(mysqli_error($con));
        mysqli_close($con);
    }
    
    function DeleteCoffee($id)
    {
        require 'Credentials.php';
        
        //Open connection and select db.
        $con=mysqli_connect($host, $user, $passwd, $database) or die(mysql_error());
        $query = "DELETE FROM coffee WHERE id = $id";
        //Execute query and close connection
        mysqli_query($con,$query) or die(mysqli_error($con));
        mysqli_close($con);
    }
}
