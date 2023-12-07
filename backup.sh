#!/bin/bash


backup_dir="/usr/local/CSI3660ProjectBackup"
backup_filename="backup_$(date +"%Y%m%d_%H%M%S").tar.gz"
tar -czvf "$backup_dir/$backup_filename" /var/www/html


find "${backup_dir}" -name "backup_*.tar.gz" -type f -mtime +7 -exec rm {} \;
