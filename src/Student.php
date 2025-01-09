<?php
class Student {
  public $id;
  public $prefix;
  public $first_name;
  public $last_name;
  public $year;
  public $gpa;
  public $birthdate;

  function __construct(
    $id,
    $prefix,
    $first_name,
    $last_name,
    $year,
    $gpa,
    $birthdate
  ) {
    $this->id = $id;
    $this->prefix = $prefix;
    $this->first_name = $first_name;
    $this->last_name = $last_name;
    $this->year = $year;
    $this->gpa = $gpa;
    $this->birthdate = $birthdate;
  }

}

function generateFirstName() {
  $firstNames = ['John', 'Jane', 'Alex', 'Emily', 'Chris', 'Katie', 'Michael', 'Sarah', 'Daniel', 'Laura'];
  $firstName = $firstNames[array_rand($firstNames)];

  return $firstName;
}

function generateLastName() {
  $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez'];
  $lastName = $lastNames[array_rand($lastNames)];
  
  return $lastName;
}

function randomNumber(int $min, int $max) {
  return rand($min, $max);
}

function randomPrefix() {
  $prefixs = ['นาย', 'นางสาว'];
  $prefix = $prefixs[array_rand($prefixs)];

  return $prefix;
}

function guidv4($data = null) {
  // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
  $data = $data ?? random_bytes(16);
  assert(strlen($data) == 16);

  // Set version to 0100
  $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
  // Set bits 6-7 to 10
  $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

  // Output the 36 character UUID.
  return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function genData() {
  return new Student(guidv4(), randomPrefix(), generateFirstName(), generateLastName(), randomNumber(1, 4), randomNumber(1, 4), "2024-01-25");
}