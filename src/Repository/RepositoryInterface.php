<?php

namespace App\Repository;

interface RepositoryInterface
{
    public function findAll();

    public function getById(int $id);
}