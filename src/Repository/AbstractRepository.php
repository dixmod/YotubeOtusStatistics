<?php

namespace App\Repository;

use App\Service\Config;
use MongoCollection;
use MongoDB;
use MongoDB\Client;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Cursor;
use MongoDB\Driver\Exception\Exception;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;
use stdClass;

abstract class AbstractRepository
{
    /** @var MongoDB */
    protected $db;

    /** @var Client */
    protected $client;

    protected $collection;

    /**
     * AbstractRepository constructor.
     */
    public function __construct()
    {
        $this->client = new Manager();
        $this->db = Config::getOptions('db')['db'];
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
        //TODO: Реализовать
    }

    /**
     * @param int $id
     * @return array
     * @throws Exception
     */
    public function getById($id)
    {
        $query = new Query(
            [
                'id' => [
                    '$eq' => $id
                ]
            ]
        );

        $result = $this->client->executeQuery(
            $this->db . '.' . $this->collection,
            $query
        )->toArray();

        $result = array_shift($result);

        return (array)$result;
    }

    /**
     * @param array $pipeline
     * @return Cursor
     * @throws Exception
     */
    public function Aggregate(array $pipeline)
    {
        $command = new MongoDB\Driver\Command([
            'aggregate' => $this->collection,
            'pipeline' => $pipeline,
            'cursor' => new stdClass,
        ]);

        return $this->client->executeCommand($this->db, $command);
    }

    /**
     * @param array $data
     * @return bool|mixed
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