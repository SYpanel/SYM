<?php
/**
 * Execute a command on system
 * @param string $cmd Commend to be executed E.g mkdir /foo/bar
 * @param bool $sudo If command needs root privileges, set to true
 * @return string Output of the command
 */
function sy_exec($cmd, $sudo = true)
{
    if ($sudo) {
        $cmd = 'sudo ' . $cmd;
    }
    
    exec($cmd, $output);

    return implode(PHP_EOL, $output);
}