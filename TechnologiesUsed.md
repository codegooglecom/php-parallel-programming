# PHP/C++ #

PHP and C++ together make the multiple script execution possible.


# Details #

PHP will handle the code level interaction in PHP scripts. PHP creates a commands XML, and run the C++ engine. C++ engine reads the commands from XML and create the forks for all the commands passing required parameters. The calling script can execute in parallel in different processes.

The script can process independent logic or can use the forking handler that redirects the script output to specific output files.

# Future Roadmap #

There is scope of refinement, making C++ code efficient and standardizing the C++ engine and PHP communication.
Some of the feature in future roadmap:
  * controlling the child processes to limit the memory use
  * security issue, only caller has privileges to read output
  * PHP extension - creating the PHP extension so no PHP code is needed
  * passing $