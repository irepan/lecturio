<?php
   // PHP version 7.4 used here
    $mongo_hostname	= "mongo";
    $mongo_username	= getenv("MONGO_INITDB_ROOT_USERNAME");
    $mongo_password	= getenv("MONGO_INITDB_ROOT_PASSWORD");

    try {
        // connect to OVHcloud Public Cloud Databases for MongoDB (cluster in version 4.4, MongoDB PHP Extension in 1.8.1)
        $m = new MongoDB\Driver\Manager("mongodb://$mongo_username:$mongo_password@$mongo_hostname/?tls=true");
        echo "Connection to database successfully\n";
        // display the content of the driver, for diagnosis purpose
        //var_dump($m);
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->insert(['mydata' => 'alice']);
        $bulk->insert(['mydata' => 'bob']);
        $bulk->insert(['mydata' => 'bastien']);
        $m->executeBulkWrite('mydb.mycol', $bulk);

        $filter = ['mydata' => 'bob'];
        $options = [];

        // Query to find inserts in a specific collection
        $query = new MongoDB\Driver\Query($filter, $options);
        $cursor = $m->executeQuery('mydb.mycol', $query);

        foreach ($cursor as $document) {
            var_dump($document);
        }
    }
    catch (Throwable $e) {
        // catch throwables when the connection is not a success
        echo "Captured Throwable for connection : " . $e->getMessage() . PHP_EOL;
    }
?>