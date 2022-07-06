<?php

    echo "<table style='border: solid 1px black;'>";
    echo "<tr><th>Name</th></tr>";//<th>Email</th><th>Password</th><th>Level</th><th>Completed</th><th>In Progress</th></tr>";

   // PHP version 7.4 used here
    $mongo_hostname	= "mongo";
    $mongo_username	= getenv("MONGO_INITDB_ROOT_USERNAME");
    $mongo_password	= getenv("MONGO_INITDB_ROOT_PASSWORD");

    try {
        // connect to OVHcloud Public Cloud Databases for MongoDB (cluster in version 4.4, MongoDB PHP Extension in 1.8.1)
        $m = new MongoDB\Driver\Manager("mongodb://$mongo_username:$mongo_password@$mongo_hostname/?tls=true");
        // echo "Connection to database successfully\n";
        // display the content of the driver, for diagnosis purpose
        //var_dump($m);
    }
    catch (Throwable $e) {
        // catch throwables when the connection is not a success
        echo "Captured Throwable for connection : " . $e->getMessage() . PHP_EOL;
    }
    try {
        $filter = [];
        $options = [];

        if (!$cursor->next){
            $bulk = new MongoDB\Driver\BulkWrite;
            $bulk->insert(['name' => 'alice']);
            $bulk->insert(['name' => 'bob']);
            $bulk->insert(['name' => 'bastien']);
            $m->executeBulkWrite('mydb.mycol', $bulk);
        }

        // Query to find inserts in a specific collection
        $query = new MongoDB\Driver\Query($filter, $options);
        $cursor = $m->executeQuery('mydb.mycol', $query);

        foreach ($cursor as $document) {
            echo "<tr><td style='width:150px;border:1px solid black;'>" . $document->name . "</td></tr>";
        }
    }
    catch (Throwable $e) {
        // catch throwables when the connection is not a success
        echo "Captured Throwable for connection : " . $e->getMessage() . PHP_EOL;
    }
    echo "</table>";
?>