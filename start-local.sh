#!/bin/bash
# Start SOPlanning locally: MySQL (via Homebrew services) + PHP dev server.
set -e
cd "$(dirname "$0")"

if ! mysqladmin -uroot ping >/dev/null 2>&1; then
    echo "Starting MySQL..."
    brew services start mysql
    for i in $(seq 1 15); do
        mysqladmin -uroot ping >/dev/null 2>&1 && break
        sleep 2
    done
fi

if curl -s -o /dev/null http://127.0.0.1:8080/; then
    echo "SOPlanning is already running at http://127.0.0.1:8080/"
    exit 0
fi

echo "Starting PHP dev server..."
nohup php -S 127.0.0.1:8080 -t www dev-router.php > /tmp/soplanning-server.log 2>&1 &
sleep 1
echo "SOPlanning is running at http://127.0.0.1:8080/  (log: /tmp/soplanning-server.log)"
