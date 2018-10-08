<?php

namespace App\Repository;

interface RepositoryInterface
{
    /**
     * @return mixed
     */
    public function findAll();

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id);
}