#!/bin/bash
# Assemble SOPlanning.app — a no-admin, portable macOS app bundle.
# Bundles a self-contained static PHP, the SOPlanning code, and a launcher
# that starts the built-in server and opens the app. Nothing installs to the
# system; the .app runs entirely from user space.
#
# Usage:  build/build-mac-app.sh [output-dir]
set -e

REPO="$(cd "$(dirname "$0")/.." && pwd)"
PHP_BIN="$REPO/build/mac/php"
OUT="${1:-$REPO/build/dist}"
APP="$OUT/SOPlanning.app"

if [ ! -x "$PHP_BIN" ]; then
	echo "Static PHP not found at $PHP_BIN — download it first (see build/README-mac.md)." >&2
	exit 1
fi

echo "Building $APP ..."
rm -rf "$APP"
mkdir -p "$APP/Contents/MacOS" "$APP/Contents/Resources/app"

# 1. Static PHP runtime
cp "$PHP_BIN" "$APP/Contents/Resources/php"
chmod +x "$APP/Contents/Resources/php"

# 2. Application code (exclude dev-only and runtime files)
rsync -a \
	--exclude '.git' \
	--exclude 'build' \
	--exclude 'node_modules' \
	--exclude 'database.inc' \
	--exclude 'data-location.json' \
	--exclude 'debug.txt' \
	--exclude 'smarty/templates_c/*' \
	"$REPO"/ "$APP/Contents/Resources/app/"

# The portable bootstrap becomes database.inc inside the bundle.
cp "$REPO/database.inc.desktop" "$APP/Contents/Resources/app/database.inc"

# 3. Info.plist
cat > "$APP/Contents/Info.plist" <<'PLIST'
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<dict>
	<key>CFBundleName</key><string>SOPlanning</string>
	<key>CFBundleDisplayName</key><string>SOPlanning</string>
	<key>CFBundleIdentifier</key><string>org.soplanning.desktop</string>
	<key>CFBundleVersion</key><string>1.57.0</string>
	<key>CFBundleShortVersionString</key><string>1.57.0</string>
	<key>CFBundlePackageType</key><string>APPL</string>
	<key>CFBundleExecutable</key><string>SOPlanning</string>
	<key>LSMinimumSystemVersion</key><string>11.0</string>
	<key>LSUIElement</key><false/>
</dict>
</plist>
PLIST

# 4. Launcher
cat > "$APP/Contents/MacOS/SOPlanning" <<'LAUNCH'
#!/bin/bash
# SOPlanning launcher: start the bundled PHP server and open the app.
RES="$(cd "$(dirname "$0")/../Resources" && pwd)"
PHP="$RES/php"
CODE="$RES/app"
LOG="${TMPDIR:-/tmp}/soplanning-mac.log"

cd "$CODE"

# Pick a free port in a stable range.
PORT=8765
for try in $(seq 8765 8799); do
	if ! nc -z 127.0.0.1 "$try" 2>/dev/null; then PORT="$try"; break; fi
done

"$PHP" -S "127.0.0.1:$PORT" -t www dev-router.php >"$LOG" 2>&1 &
SERVER=$!

# Wait for it to come up.
for i in $(seq 1 30); do
	if curl -s -o /dev/null "http://127.0.0.1:$PORT/"; then break; fi
	sleep 0.3
done

open "http://127.0.0.1:$PORT/"

# Release the single-instance lock on quit (best effort).
cleanup() {
	kill "$SERVER" 2>/dev/null
	DBPATH=$("$PHP" -r '$j=@json_decode(@file_get_contents("data-location.json"),true); echo $j["sqlite_path"]??"";' 2>/dev/null)
	[ -n "$DBPATH" ] && rm -f "$DBPATH.lock"
}
trap cleanup EXIT INT TERM

wait "$SERVER"
LAUNCH
chmod +x "$APP/Contents/MacOS/SOPlanning"

echo "Done: $APP"
echo "Run with:  open \"$APP\"    (or double-click it in Finder)"
