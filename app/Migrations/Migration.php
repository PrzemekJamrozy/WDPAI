<?php

namespace Migrations;

interface Migration
{
    public function migrate(): void;
}