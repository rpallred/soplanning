#!/bin/bash
# Start SOPlanning locally: MySQL (via Homebrew services) + PHP dev server.
#
# By default the server binds to all interfaces (0.0.0.0) so it is reachable
# from any device on the local network at http://<this-mac-ip>:8080/.
# To restrict it back to this machine only, run:  SPL_HOST=127.0.0.1 ./start-local.sh
set -e
cd "$(dirname "$0")"

HOST="${SPL_HOST:-0.0.0.0}"
PORT="${SPL_PORT:-8080}"

if ! mysqladmin -uroot ping >/dev/null 2>&1; then
    echo "Starting MySQL..."
    brew services start mysql
    for i in $(seq 1 15); do
        mysqladmin -uroot ping >/dev/null 2>&1 && break
        sleep 2
    done
fi

if curl -s -o /dev/null "http://127.0.0.1:$PORT/"; then
    echo "SOPlanning is already running on port $PORT"
    exit 0
fi

echo "Starting PHP dev server on $HOST:$PORT ..."
nohup php -S "$HOST:$PORT" -t www dev-router.php > /tmp/soplanning-server.log 2>&1 &
sleep 1

LANIP=$(ipconfig getifaddr en0 2>/dev/null || ipconfig getifaddr en1 2>/dev/null)
echo "SOPlanning is running:"
echo "  - this machine:   http://127.0.0.1:$PORT/"
if [ "$HOST" = "0.0.0.0" ] && [ -n "$LANIP" ]; then
    echo "  - on the network: http://$LANIP:$PORT/   (reachable from any device on your LAN)"
fi
echo "  (log: /tmp/soplanning-server.log)"
