<?php
class Database
{

    public $connection;
    public $statement;

    public function __construct($config, $username = 'postgres', $password = 'root')
    {
        //$dsn = 'pgsql:host=localhost;dbname=myapp;port=5432'; hardcoded
        //$dsn= 'pgsql:host='.$config['database']['host'].';dbname='.$config['database']['database'].';port='.$config['database']['port']; // dynamic way

        $dsn = 'pgsql:' . http_build_query($config, '', ';'); // better way

        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }


    public function query($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($params);
        return  $this;;
    }

    public function get()
    {
        return $this->statement->fetchAll();
    }


    public function find()
    {
        return $this->statement->fetch();
    }


    public function findOrFail()
    {
        $result = $this->find();
        if (!$result) {
            abort();
        }
        return $result;
    }
}
