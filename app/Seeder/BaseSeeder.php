<?php

namespace Seeder;

use Database\DatabaseProvider;

abstract class BaseSeeder
{

    protected DatabaseProvider $database;
    public function __construct()
    {
        $this->database = DatabaseProvider::getInstance();
    }

    abstract public function seed():void;
}