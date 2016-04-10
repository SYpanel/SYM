<?php
function sy_exec($cmd)
{
	exec('sudo ' . $cmd, $output);

	return implode(PHP_EOL, $output);
}