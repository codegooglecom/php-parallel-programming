While working on PHP, on many occassions I come up with requirement where I need to run some processes in parallel.
But there wasnt any easier way to do parallel processing in PHP.
In PHP, we could use fork using pcntl\_fork() function but in unix variant platforms when PHP is not running as Apache module. Moreover this is not available on Windows platform.

There is a simpler way too, we can fake the forking by using the exec function and redirect STDOUT and STDERR to /dev/null and run the process in the background. But in this scenario, we cant catch the script output and dont have control on script flow.

**Features**:
  * Synchronous/asynchronous script execution

  * Control parallel PHP script executions and get the outputs from the scripts

  * Argument passing to the PHP scripts

  * Get output in HTML/PHP object from

You can connect to me on http://www.akashsharma.me

**Code assistance**

**_synchronous forking_**
```
<?php
//synchronous-forker.php
require_once("Forker/ForkerManager.inc.php");

$outError = false;
$asynchronous = false;

$handler = ForkerManager::createHandler('new', $outError, $asynchronous);

$name = "cmd 1";
$command = "/opt/lampp/htdocs/php-forker/sleep.php";
$args = array('name' => $name);

$handler->addCommand($name, $command, $args);

$name = "cmd 2";
$command = "/opt/lampp/htdocs/php-forker/output.php";
$args = array('name' => $name);

$handler->addCommand($name, $command, $args);

$name = "cmd 3";
$command = "/opt/lampp/htdocs/php-forker/print.php";
$args = array('name' => $name);

$handler->addCommand($name, $command, $args);


$handler->deleteCommand('cmd 2');

$handler->run();

$output = $handler->getAllOutputs();

$c3Output = $handler->getOutput("cmd 3");

-----
-----
-----
-----
?>
```


**_asynchronous forking_**

```
<?php
//asynchronous-forker.php
ob_start();
require_once("Forker/ForkerManager.inc.php");

$outError = false;
$asynchronous = true;

$handler = ForkerManager::createHandler('new', $outError, $asynchronous);

for($i = 0; $i < 10; $i++) {
	$name = "c$i";
	$command = "/opt/lampp/htdocs/php-forker/sleep.php";
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

$handler->run();

$GUID = $handler->getGUID();

header('Location: asynchronous-output.php?GUID=' . $GUID);
?>
```


```

<?php
//asynchronous-output.php
require_once("Forker/ForkerManager.inc.php");

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

-----
-----
-----
-----
-----
?>

```