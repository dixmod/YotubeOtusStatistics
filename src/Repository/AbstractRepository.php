<?php

namespace Dixmod\Repository;

use Dixmod\Services\Config;
use MongoDB\Driver\{BulkWrite, Manager};

abstract class AbstractRepository
{
    /** @var MongoDB */
    protected $db;

    /** @var \MongoDB\Client */
    protected $client;

    protected $collection;
    private $bulk;

    public function __construct()
    {
        $this->client = new Manager();
        $this->db = Config::getOptions('db')['db'];

//        $this->client->selectCollection(
//            ,
//            $this->getCollection()
//        );
    }

    /**
     * @return MongoCollection
     */
    public function getCollection(): string
    {
        return $this->collection;
    }

    /**
     * @param array $filters
     * @return array
     */
    public function findAll(array $filters = []): array
    {

    }

    /**
     * @param int $id
     * @return array
     */
    public function getById(int $id): array
    {

    }

    /**
     * @param array $data
     * @return bool|mixed
     * @throws \MongoCursorException
     * @throws \MongoCursorTimeoutException
     * @throws \MongoException
     */
    public function Save($data)
    {
        $bulk = new BulkWrite;
        $bulk->update(
            $data,
            [
                '$set' => [
                    'id' => $data['id']
                ]
            ],
            [
                'upsert' => true
            ]
        );
        return $this->client->executeBulkWrite(
            $this->db . '.' . $this->collection,
            $bulk
        );
    }


}