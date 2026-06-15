# SOPlanning 1.56.00 — Hardened

This instance is based on the official SOPlanning 1.56.00 release with the
following local security fixes applied (see git log for full details).
The running version is displayed as **1.57.00-hardened.1** on the login page.
(The `1.57` line adds the program features — completion tracking, book
checkout/check-in, and supervision functions + coverage — on top of the
hardened 1.56 base; see `sql/update/update-1-57-*.txt`.)

| Fix | Files | Commit |
|---|---|---|
| CSRF token required for project-group delete (GET) and save (POST) | `www/process/groupe_save.php`, group templates | `a43a011` |
| Password-reset tokens: HMAC-SHA256 + `hash_equals`, strict same-day expiry. (Upstream 1.56.00 generation/validation used mismatched separator bytes — reset links could never validate.) | `www/change_password.php`, `includes/class_user.inc` | `0d85602` |
| Per-user `cle` secret and session CSRF token now from a CSPRNG (was `MD5(RAND())` / `md5(uniqid(mt_rand()))`) | `www/process/xajax_server.php`, `config.inc`, `includes/demo_data.inc` | `9bf1c21`, `13002ee` |
| Timing-safe (`hash_equals`) comparison of API key, public-access key, and iCal export hash; mobile API rejects empty-`cle` users | `www/api/endpoint.php`, `www/api/endpoint_mobile.php`, `includes/header.inc`, `www/export_ical.php` | `143991b` |
| Session cookie `secure` flag under HTTPS | `config.inc` | `143991b` |
| DB seed: `SECURE_KEY` generated with `SHA2()` over more entropy (also required: MySQL 9.6 removed the SQL `MD5()` function) | `sql/planning_mysql.sql` | `13002ee` |

## Versioning convention

`version.txt` and the `CURRENT_VERSION` row in `planning_config` must always
match exactly (the app string-compares them and otherwise triggers its upgrade
flow). Bump the `-hardened.N` suffix in both places together when adding local
security changes.

When upgrading to a future upstream release, diff these patches against the new
code before overwriting — re-apply any the upstream version has not fixed, then
set the version to `<new-version>-hardened.1`.

## Deployment checklist (production)

- Serve only `www/` as the web root; app code and `database.inc` stay outside it.
- HTTPS only.
- Public-access mode off unless intentionally enabled (and then with key).
- Upload-directory protections are Apache `.htaccess` files; on nginx/Caddy,
  add equivalent rules (no PHP execution, no listing under `www/upload/`).
- Restrict the API CORS header (`Access-Control-Allow-Origin: *` in
  `www/api/endpoint*.php`) to your own domain.
