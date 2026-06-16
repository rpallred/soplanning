// SOPlanning native macOS launcher.
//
// Starts the bundled static PHP server, shows a native window containing a
// WKWebView pointed at it, and tears the server down (releasing the
// single-instance lock) when the app quits. No browser, no extra runtime.

import Cocoa
import WebKit
import Darwin

final class AppDelegate: NSObject, NSApplicationDelegate, WKNavigationDelegate {
    var window: NSWindow!
    var webView: WKWebView!
    var server: Process?
    var port: Int = 8765
    var appCode: String = ""

    func applicationDidFinishLaunching(_ note: Notification) {
        let exe = Bundle.main.executablePath ?? CommandLine.arguments[0]
        let macOSDir = (exe as NSString).deletingLastPathComponent           // .../Contents/MacOS
        let contents = (macOSDir as NSString).deletingLastPathComponent      // .../Contents
        let resources = contents + "/Resources"
        appCode = resources + "/app"
        let php = resources + "/php"

        port = firstFreePort(from: 8765, to: 8799)
        startServer(php: php, port: port)
        _ = waitForServer(port: port, timeoutSec: 12)

        let frame = NSRect(x: 0, y: 0, width: 1200, height: 820)
        window = NSWindow(contentRect: frame,
                          styleMask: [.titled, .closable, .miniaturizable, .resizable],
                          backing: .buffered, defer: false)
        window.title = "SOPlanning"
        window.center()
        window.setFrameAutosaveName("SOPlanningMain")

        webView = WKWebView(frame: frame, configuration: WKWebViewConfiguration())
        webView.navigationDelegate = self
        webView.autoresizingMask = [.width, .height]
        window.contentView = webView

        loadApp()
        window.makeKeyAndOrderFront(nil)
        NSApp.activate(ignoringOtherApps: true)
    }

    func loadApp() {
        if let url = URL(string: "http://127.0.0.1:\(port)/") {
            webView.load(URLRequest(url: url))
        }
    }

    // Retry once if the first navigation beats the server coming up.
    func webView(_ webView: WKWebView, didFail navigation: WKNavigation!, withError error: Error) {
        retryLoadSoon()
    }
    func webView(_ webView: WKWebView, didFailProvisionalNavigation navigation: WKNavigation!, withError error: Error) {
        retryLoadSoon()
    }
    func retryLoadSoon() {
        DispatchQueue.main.asyncAfter(deadline: .now() + 0.6) { [weak self] in self?.loadApp() }
    }

    func startServer(php: String, port: Int) {
        let p = Process()
        p.executableURL = URL(fileURLWithPath: php)
        p.arguments = ["-S", "127.0.0.1:\(port)", "-t", "www", "dev-router.php"]
        p.currentDirectoryURL = URL(fileURLWithPath: appCode)
        let null = FileHandle.nullDevice
        p.standardOutput = null
        p.standardError = null
        try? p.run()
        server = p
    }

    func applicationShouldTerminateAfterLastWindowClosed(_ s: NSApplication) -> Bool { true }

    func applicationWillTerminate(_ note: Notification) {
        server?.terminate()
        releaseLock()
    }

    // Delete the lock beside the data file so another machine can open it promptly.
    func releaseLock() {
        let cfg = appCode + "/data-location.json"
        guard let data = FileManager.default.contents(atPath: cfg),
              let obj = try? JSONSerialization.jsonObject(with: data) as? [String: Any],
              let path = obj["sqlite_path"] as? String, !path.isEmpty else { return }
        try? FileManager.default.removeItem(atPath: path + ".lock")
    }

    // MARK: - tiny socket helpers

    func firstFreePort(from lo: Int, to hi: Int) -> Int {
        for p in lo...hi where isPortFree(p) { return p }
        return lo
    }

    func isPortFree(_ port: Int) -> Bool {
        let fd = socket(AF_INET, SOCK_STREAM, 0)
        if fd < 0 { return true }
        defer { close(fd) }
        var yes: Int32 = 1
        setsockopt(fd, SOL_SOCKET, SO_REUSEADDR, &yes, socklen_t(MemoryLayout<Int32>.size))
        var addr = sockaddr_in()
        addr.sin_family = sa_family_t(AF_INET)
        addr.sin_port = in_port_t(UInt16(port).bigEndian)
        addr.sin_addr.s_addr = inet_addr("127.0.0.1")
        let bound = withUnsafePointer(to: &addr) {
            $0.withMemoryRebound(to: sockaddr.self, capacity: 1) {
                Darwin.bind(fd, $0, socklen_t(MemoryLayout<sockaddr_in>.size))
            }
        }
        return bound == 0
    }

    func waitForServer(port: Int, timeoutSec: Int) -> Bool {
        let deadline = Date().addingTimeInterval(TimeInterval(timeoutSec))
        while Date() < deadline {
            if canConnect(port: port) { return true }
            usleep(250_000)
        }
        return false
    }

    func canConnect(port: Int) -> Bool {
        let fd = socket(AF_INET, SOCK_STREAM, 0)
        if fd < 0 { return false }
        defer { close(fd) }
        var addr = sockaddr_in()
        addr.sin_family = sa_family_t(AF_INET)
        addr.sin_port = in_port_t(UInt16(port).bigEndian)
        addr.sin_addr.s_addr = inet_addr("127.0.0.1")
        let ok = withUnsafePointer(to: &addr) {
            $0.withMemoryRebound(to: sockaddr.self, capacity: 1) {
                Darwin.connect(fd, $0, socklen_t(MemoryLayout<sockaddr_in>.size))
            }
        }
        return ok == 0
    }
}

// Minimal menu so Cmd-Q / standard shortcuts work.
func buildMenu() {
    let mainMenu = NSMenu()
    let appItem = NSMenuItem()
    mainMenu.addItem(appItem)
    let appMenu = NSMenu()
    appMenu.addItem(withTitle: "Quit SOPlanning", action: #selector(NSApplication.terminate(_:)), keyEquivalent: "q")
    appItem.submenu = appMenu

    let editItem = NSMenuItem()
    mainMenu.addItem(editItem)
    let editMenu = NSMenu(title: "Edit")
    editMenu.addItem(withTitle: "Cut", action: #selector(NSText.cut(_:)), keyEquivalent: "x")
    editMenu.addItem(withTitle: "Copy", action: #selector(NSText.copy(_:)), keyEquivalent: "c")
    editMenu.addItem(withTitle: "Paste", action: #selector(NSText.paste(_:)), keyEquivalent: "v")
    editMenu.addItem(withTitle: "Select All", action: #selector(NSText.selectAll(_:)), keyEquivalent: "a")
    editItem.submenu = editMenu
    NSApp.mainMenu = mainMenu
}

let app = NSApplication.shared
let delegate = AppDelegate()
app.delegate = delegate
app.setActivationPolicy(.regular)
buildMenu()
app.run()
