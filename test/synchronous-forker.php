<?php
/*
Licensed to the Apache Software Foundation (ASF) under one
or more contributor license agreements.  See the NOTICE file
distributed with this work for additional information
regarding copyright ownership.  The ASF licenses this file
to you under the Apache License, Version 2.0 (the
"License"); you may not use this file except in compliance
with the License.  You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing,
software distributed under the License is distributed on an
"AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
KIND, either express or implied.  See the License for the
specific language governing permissions and limitations
under the License.
*/

require_once("../Forker/Defines.inc.php");
require_once(FORKER_HOME_DIR . "/Forker/ForkerManager.inc.php");

$outError = false;
$asynchronous = false;

$handler = ForkerManager::createHandler('new', $outError, $asynchronous);

for($i = 0; $i < 10; $i++) {
	$name = "c$i";
	$command = FORKER_HOME_DIR . "/test/sleep.php";
	$args = array('name' => $name);

	list($usec, $sec) = explode(" ", microtime());
	srand((int)($usec*10000));

	$rand = rand(1,5);

	for ($k = 0; $k < $rand; $k++) {
		list($usec, $sec) = explode(" ", microtime());
		srand((int)($usec*10000));

		$r = rand(1,100);

		$args["cmd$k"] = $r;		
	}

	$handler->addCommand($name, $command, $args);
}

$handler->deleteCommand('c3');

echo '<pre>';
$handler->run();

$output = $handler->getAllOutputs();

print_r($output);

?>