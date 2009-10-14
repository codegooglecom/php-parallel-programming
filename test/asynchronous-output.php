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

//asynchronous-output.php
require_once("../Forker/Defines.inc.php");
require_once(FORKER_HOME_DIR . "/Forker/ForkerManager.inc.php");


$handler = ForkerManager::getHandler($_GET['GUID'], $outError);

$tries = 0;

while ($handler->runComplete() != true && $tries <= 10) {
	$tries++;
	flush();
	sleep(2);
}

$output = $handler->getAllOutputs();
$c3Output = $handler->getOutput("c4");

echo '<pre>';
print_r($output);
print_r($c3Output);
?>