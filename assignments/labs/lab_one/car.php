<?php
// make strict
declare(strict_types=1);
// database
require_once "connect.php";
class Car {
    public string $make;
    public string $model; 
    public string $year; 
    
    public function __construct(string $make, string $model, string $year) {
        $this->make = $make; 
        $this->model = $model; 
        $this->year = $year;
    }

    public function getBadge(): string {
        $role = $this->isInstructor ? "Instructor" : "Student"; 
        return "Name : {$this->name} | Age: {$this->age} | Role : $role";
    }
}

//create an instance of the object 

$car = new Car("Huyndai", "Elantra", "2025"); 

echo $car->getBadge(); 