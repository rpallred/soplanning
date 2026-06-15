# Building the macOS app (no-admin, portable)

`SOPlanning.app` is a self-contained macOS application: it bundles a static
PHP runtime and the SOPlanning code, runs entirely from user space (no admin,
no installer), and stores its data in a SQLite file you choose on first run
(e.g. a OneDrive folder). Keep the app anywhere — Applications, Desktop, a USB
stick.

## Build steps

1. **Download the static PHP runtime** (once). It is self-contained — links
   only against macOS system libraries, includes `pdo_sqlite`, `mbstring`,
   `gd`, etc.:

   ```sh
   mkdir -p build/mac && cd build/mac
   curl -L -o php-static.tar.gz \
     https://dl.static-php.dev/static-php-cli/common/php-8.4.22-cli-macos-aarch64.tar.gz
   tar xzf php-static.tar.gz        # produces ./php
   cd ../..
   ```
   (Apple Silicon = `aarch64`. For an Intel Mac use the `x86_64` build.)

2. **Assemble the app:**

   ```sh
   bash build/build-mac-app.sh
   ```
   Produces `build/dist/SOPlanning.app`.

## First run

- Double-click `SOPlanning.app`. Because it is not code-signed, macOS Gatekeeper
  blocks it the first time — **right-click the app → Open → Open** once to
  approve it (subsequent launches are normal). Alternatively:
  `xattr -dr com.apple.quarantine SOPlanning.app`.
- The app opens a **Data Location** page. Point it at a folder (your OneDrive
  folder) and click **Create database here** — it creates `soplanning.sqlite`
  there and shows your one-time admin password (login `admin`).
- To reuse the same data on another Mac, install the app there too and choose
  **Use an existing database** pointing at the same synced file.

## Behaviour

- On launch the app starts a local server (127.0.0.1, a free port 8765–8799),
  opens your browser to it, and writes a timestamped **backup** into a
  `backups/` folder beside the data file.
- A **single-instance lock** sits beside the data file. If the file is already
  open on another machine, the app refuses to launch and tells you to close it
  there first — this prevents corrupting a cloud-synced database.
- Quit from the Dock to stop the server (the lock is released on quit).

## Notes / future polish

- The current launcher opens the system browser. A native app window
  (WKWebView) is a possible upgrade for a more "app-like" feel.
- For distribution beyond your own machines, the app would need Apple code
  signing + notarization to avoid the Gatekeeper prompt.
- To migrate your existing data instead of starting fresh, run
  `tools/mysql2sqlite.php` against your MySQL database to produce the
  `soplanning.sqlite`, then choose **Use an existing database**.
