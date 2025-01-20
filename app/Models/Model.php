<?php

namespace Models;

abstract class Model
{

    public abstract function toApiResponse(): array;
}