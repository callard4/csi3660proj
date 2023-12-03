#!/bin/bash

current_dateandtime=$(date +"%Y%m%d_%H%M%S")

db_user="root"
db_password=""
db_name=""

backup_dir=""

mysqldump -u"$db_user" -p"$db_password" "$db_name" > "$backup_dir/backup_$current_datetime.sql"
