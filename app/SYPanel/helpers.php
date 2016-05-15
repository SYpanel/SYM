<?php
/**
 * Execute a command on system
 *
 * @param string $cmd       Commend to be executed E.g mkdir /foo/bar
 * @param bool   $sudo      If command needs root privileges, set to true
 * @param bool   $getOutput should we return what ever the command returned?
 *
 * @return string Output of the command
 */
function sy_exec($cmd, $sudo = true, $getOutput = true)
{
	$cmd = sprintf('nohup sh -c "%s" & disown', $cmd);

	if($sudo)
	{
		$cmd = 'sudo ' . ltrim($cmd, ' ');
	}
	$k = [];
	$c = [];
	if($getOutput)
	{
		exec($cmd, $output);

		return implode(PHP_EOL, $output);
	}
	proc_open($cmd, $k, $c, '/var/www');

	return implode(PHP_EOL, []);
}