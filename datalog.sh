#!/bin/bash

[ $# -ne 1 ] && {echo "Usage : $0 input file "; exit 1; }
input_file=$1

TIMESTAMP='date "+%Y-%m-%d"'
touch /home/$USER/logs/${TIMESTAMP}.success_log
touch /home/$USER/logs/${TIMESTAMP}.fail_log
success_logs=/home/$USER/logs/${TIMESTAMP}.success_log
fail_logs=/home/$USER/logs/${TIMESTAMP}.fail_log

function log_status
{
        status=$1
        message=$2
        if [ "$status" -ne 0 ]; then
                echo "date +\"%Y-%m-%d %H:%M:%S\" [ERROR] $message [Status]"

                else
                        echo "date +\"%Y-%m-%d %H:%M:%S\" [INFO] $message [Status]"
                fi
}

while read table ;do
        sqoop job --exec $table > /home/$USER/logging/"${table}_log" 2>&1
        g_STATUS=$?
        log_status $g_STATUS "Sqoop job ${table}"

        done < ${input_file}
