<?php
require "./Controller/CoffeeController.php";
$title = "Manage Coffee Objects";
$coffeeController = new CoffeeController();

$content = $coffeeController->CreateOverviewTable();

//Prep to delete the object
if(isset($_GET["delete"]))
{
    $coffeeController->DeleteCoffee($_GET["delete"]);
}
include './Template.php';
