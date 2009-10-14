<?
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
require_once(FORKER_HOME_DIR . "/Forker/ForkerInit.inc.php");


$a = $ARGV['name'];

if ($argv[2] % 2 == 0) {
	echo "just html print:  ";
}
else {	
	$forker = ForkerInit::getInstance();
	$forker->setOutputType(FORKER_OUTPUT_OBJECT_TYPE);
}
echo serialize($ARGV);

for ($i = 0; $i<10; $i++) {
	$date = date('d-m h:i:s');
	$f = fopen(FORKER_HOME_DIR . '/test/log.txt', 'a+');	
	fwrite( $f,"$date $a: $i\n");
	fclose($f);
	sleep(1);
}
