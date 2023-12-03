backup_dir="/usr/local/CSI3660ProjectBackup"

# Create the backup filename with the current date
backup_filename="backup_$(date '+%Y_%m_%d').tar.gz"

# Create the backup archive
tar -czvf "$backup_dir/$backup_filename" /var/www/html

# Create or update the README file in the backup directory
echo "Backup Strategy for CSI3660 Project" > "$backup_dir/README.md"
echo "===================================" >> "$backup_dir/README.md"
echo "" >> "$backup_dir/README.md"
echo "This backup is created using a scheduled script." >> "$backup_dir/README.md"
echo "Files backed up:" >> "$backup_dir/README.md"
echo "- /path/to/your/files" >> "$backup_dir/README.md"
echo "" >> "$backup_dir/README.md"
echo "Backup filename format: backup_YYYY_MM_DD.tar.gz" >> "$backup_dir/README.md"
echo "" >> "$backup_dir/README.md"
echo "This README file is automatically updated during each backup." >> "$backup_dir/README.md"

# Optional: Remove old backups (adjust retention as needed)
find "$backup_dir" -name 'backup_*' -type f -mtime +7 -exec rm {} \;

# Optional: Display a message indicating successful backup
echo "Backup completed successfully: $backup_dir/$backup_filename"
