<?php

namespace Seeder;
require_once 'autoloader.php';
class Seeder extends BaseSeeder
{

    /**
     * @var BaseSeeder[]
     */
    private array $seedersToRun;
    public function __construct()
    {
        parent::__construct();

        /** @var BaseSeeder $seeders */
        $this->seedersToRun = [
            new PermissionSeeder(),
            new UserSeeder(),
            new UserHasPermissionSeeder(),
            new UserProfileSeeder()
        ];
    }

    public function seed():void
    {
        foreach ($this->seedersToRun as $seeder) {
            $seeder->seed();
        }
    }
}

(new Seeder())->seed();