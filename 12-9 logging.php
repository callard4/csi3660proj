<?php

function logEvent($event_type, $message) {
    $log_file = "/var/www/html/all_logs.log";
    $log_message = date("Y-m-d H:i:s") . " [$event_type] $message\n";

    try {
        $result = file_put_contents($log_file, $log_message, FILE_APPEND | LOCK_EX);
        if ($result === false) {
            throw new Exception('Failed to write to log file.');
        }
    } catch (Exception $e) {
        error_log("Error in logEvent: " . $e->getMessage());
    }
}

              
