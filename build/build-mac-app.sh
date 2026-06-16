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

# 4. Native launcher (Swift WKWebView window that owns the PHP server lifecycle)
LAUNCHER_SRC="$REPO/build/mac-launcher/SOPlanning.swift"
if command -v swiftc >/dev/null 2>&1 && [ -f "$LAUNCHER_SRC" ]; then
	echo "Compiling native launcher ..."
	swiftc -O -o "$APP/Contents/MacOS/SOPlanning" "$LAUNCHER_SRC"
else
	echo "swiftc not found — falling back to a browser-opening launcher." >&2
	cat > "$APP/Contents/MacOS/SOPlanning" <<'LAUNCH'
#!/bin/bash
RES="$(cd "$(dirname "$0")/../Resources" && pwd)"
cd "$RES/app"
PORT=8765; for t in $(seq 8765 8799); do nc -z 127.0.0.1 "$t" 2>/dev/null || { PORT="$t"; break; }; done
"$RES/php" -S "127.0.0.1:$PORT" -t www dev-router.php >"${TMPDIR:-/tmp}/soplanning-mac.log" 2>&1 &
SERVER=$!
for i in $(seq 1 30); do curl -s -o /dev/null "http://127.0.0.1:$PORT/" && break; sleep 0.3; done
open "http://127.0.0.1:$PORT/"
trap "kill $SERVER 2>/dev/null" EXIT INT TERM
wait "$SERVER"
LAUNCH
fi
chmod +x "$APP/Contents/MacOS/SOPlanning"

echo "Done: $APP"
echo "Run with:  open \"$APP\"    (or double-click it in Finder)"
