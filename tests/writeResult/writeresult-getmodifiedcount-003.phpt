--TEST--
MongoDB\Driver\WriteResult::getModifiedCount() not available for legacy writes
--SKIPIF--
<?php require __DIR__ . "/../utils/basic-skipif.inc"; ?>
<?php NEEDS('STANDALONE_24'); CLEANUP(STANDALONE_24); ?>
--FILE--
<?php
require_once __DIR__ . "/../utils/basic.inc";

$manager = new MongoDB\Driver\Manager(STANDALONE_24);

$bulk = new MongoDB\Driver\BulkWrite;
$bulk->insert(['x' => 1]);
$bulk->update(['x' => 1], ['$set' => ['y' => 3]]);
$bulk->update(['x' => 2], ['$set' => ['y' => 1]], ['upsert' => true]);
$bulk->update(['x' => 3], ['$set' => ['y' => 2]], ['upsert' => true]);
$bulk->delete(['x' => 1]);

$result = $manager->executeBulkWrite(NS, $bulk);

var_dump($result->getModifiedCount());

?>
===DONE===
<?php exit(0); ?>
--EXPECT--
NULL
===DONE===
