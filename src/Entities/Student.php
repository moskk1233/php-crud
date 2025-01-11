<?php

namespace Entities;

class Student
{
  function __construct(
    public string $id,
    public string $prefix,
    public string $first_name,
    public string $last_name,
    public int $year,
    public int $gpa,
    public string $birthdate
  ) {}
}
