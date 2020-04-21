<script>
// Display a confirmation box when trying to delete an object
function showConfirm(id)
{
    //build the confirmation box
    var c = confirm("Are you sure you wish to delete this item?");
    
    //if true, delete this item and refresh
    if(c)
        window.location = "CoffeeOverview.php?delete=" + id;
    
}
</script>

<?php
require ("Module/CoffeeModule.php");

//Contains non-db related function for the Coffee Page
class CoffeeController 
{
    function CreateOverviewTable()
    {
        $result = "
              <table class='overviewtable'>
                <tr>
                    <td></td>
                    <td></td>
                    <td><b>Id</b></td>
                    <td><b>Name</b></td>
                    <td><b>Type</b></td>
                    <td><b>Price</b></td>
                    <td><b>Roast</b></td>
                    <td><b>Country</b></td>
                </tr>"; 
        $coffeeArray = $this->GetCoffeeByType('%');
        
        foreach($coffeeArray as $key => $value)
        {
            $result = $result .
                    "<tr>
                        <td><a href='CoffeeAdd.php?update=$value->id'>Update</a></td>
                        <td><a href='#' onclick=showConfirm($value->id)>Delete</a></td>
                        <td>$value->id</td>
                        <td>$value->name</td>
                        <td>$value->type</td>
                        <td>$value->price</td>
                        <td>$value->roast</td>
                        <td>$value->country</td>
                    </tr>"; 
        }
        $result = $result . "</table>";
        return $result;
    }
    function CreateCoffeeDropDownList()
    {
        $coffeeModule = new CoffeeModule();
        $result = "<form action = '' method = 'post' width ='200px'>
                    Please select a type:
                    <select name = 'types' >
                        <option value = '%' >All</option>
                        ".$this->CreateOptionValues($coffeeModule->GetCoffeeTypes()).
                    "</select>
                    <input type = 'submit' value = 'Search'/>
                    </form>";
        
        return $result;
        
    }
    
    function CreateOptionValues(array $valueArray)
    {
        $result = "";
        
        foreach ($valueArray as $value)
        {
            $result = $result . "<option value='$value'>$value</option>";
        }
        
        return $result;
    }
    function CreateCoffeeTables($types)
    {
        $coffeeModule = new CoffeeModule();
        $coffeeArray = $coffeeModule->GetCoffeeByType($types);
        $result = "";
        
        //Generate a coffeeTable for each coffeeEntity in array
        foreach ($coffeeArray as $key => $coffee)
        {
            $result = $result .
                    "<table class = 'coffeeTable'>
                        <tr>
                            <th rowspan='6' width='150px'><img runat = 'server' src = '$coffee->image' /></th>
                            <th width= '75px'>Name: </th>
                            <td>$coffee->name</td>
                        </tr
                        
                        <tr>
                            <th>Type: </th>
                            <td>$coffee->type</td>
                        </tr>
                        
                        <tr>
                            <th>Price: </th>
                            <td>$coffee->price</td>
                        </tr>
                        
                        <tr>
                            <th>Roast: </th>
                            <td>$coffee->roast</td>
                        </tr>
                        
                        <tr>
                            <th>Origin: </th>
                            <td>$coffee->country</td>
                        </tr>
                        
                        <tr>
                            <td colspan='2'>$coffee->review</td>
                        </tr>
                    </table>";
                        
        }
        return $result;
            
    }
    //Returns list of files in a folder
    function GetImages()
    {
        //Select folder to scan
        $handle = opendir("Images/Coffee");
        
        //Read all the files and store names in an array
        while($image = readdir($handle))
        {
            $images[] = $image;
        }
        closedir($handle);
        
        //Exclude all the filenames where length < 3
        $imageArray = array();
        foreach($images as $image)
        {
            if(strlen($image) > 2)
            {
                array_push($imageArray, $image);
            }
        }
        
        //Create <select><option> Values and return Result
        $result = $this->CreateOptionValues($imageArray);
        return $result;
    }
    
    //<editor-fold desc="Set Methods">
    function InsertCoffee() 
    {
        $name = $_POST["txtName"];
        $type = $_POST["ddlType"];
        $price = $_POST["txtPrice"];
        $roast = $_POST["txtRoast"];
        $country = $_POST["txtCountry"];
        $image = $_POST["ddlImage"];
        $review = $_POST["txtReview"];
        
        $coffee = new CoffeeEntity(-1, $name, $type, $price, $roast, $country, $image, $review);
        $coffeeModule = new CoffeeModule();
        $coffeeModule->InsertCoffee($coffee);
    }
    
    function UpdateCoffee($id) 
    {
        $name = $_POST["txtName"];
        $type = $_POST["ddlType"];
        $price = $_POST["txtPrice"];
        $roast = $_POST["txtRoast"];
        $country = $_POST["txtCountry"];
        $image = $_POST["ddlImage"];
        $review = $_POST["txtReview"];
        
        $coffee = new CoffeeEntity($id, $name, $type, $price, $roast, $country, $image, $review);
        $coffeeModule = new CoffeeModule();
        $coffeeModule->UpdateCoffee($id , $coffee);
    }
    
    function DeleteCoffee($id) 
    {
        $coffeeModule = new CoffeeModule();
        $coffeeModule->DeleteCoffee($id);
    }
    //</editor-fold>
    //<editor-fold desc="Get Methods">
    function GetCoffeeById($id) 
    {
        $coffeeModule = new CoffeeModule();
        return $coffeeModule->GetCoffeeById($id);
    }
    
    function GetCoffeeByType($type) 
    {
        $coffeeModule = new CoffeeModule();
        return $coffeeModule->GetCoffeeByType($type);
    }
    
    function GetCoffeeTypes() 
    {
        $coffeeModule = new CoffeeModule();
        return $coffeeModule->GetCoffeeTypes();
    }
    //</editor-fold>
    
}
