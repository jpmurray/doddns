# Changelog

## X (Next release)

## 3.3.2

-   Fixed typos.

## 3.3.1

-   Added Docker image (use at your own risk, we're at a testing phase with this).

## 3.3.0

-   Changed path to build code in `composer.json`.
-   Updated packages and framework to latest version.
-   PHP minimum version was updated to `7.2.5`.

## 3.2.1

-   Fixing app not loading from CLI because source wasn't built. Sorry!

## 3.2.0

-   Added a command to toggle on or off desktop notifications.
-   If desktop notifications are enabled, DODDNS will notify on successful update of domain when IP changes.

## 3.1.0

-   Moved to a custom solution (ipcheck.doddns.com)[https://ipcheck.doddns.com] to find current IP addresses.

## 3.0.1

-   Prepared for Packagist distribution.

## 3.0.0

-   Refactored application so it uses a single config file (in json format) rather than a SQLite database.

## 2.1.0

-   Stores the installed version to the `settings` table when installing / upgrading for the first time (defaults to current).
-   Updated installed version field in `settings` table when upgrading.
-   Added new informations to the `doddns version` command.
-   Changed conditions for upgrade from versiob `1.*` to `2.*`.

## 2.0.0

-   Moved configuration files to the `.config` directory of the user's home. _Be sure to run the upgrade command_.

## 1.4.0

-   Records the latest IP that has been found / use while running the update command.
-   Adds a new command to see the latest known ip: `doddns last-known-ip`.
-   Updates IP with Digital Ocean only when the current IP is different than the last known IP.
-   Answering no to the database overwrite on setup actually stops the process.
-   `doddns setup` now show a menu with different options: first time setup, start from scratch and upgrade.
-   `doddns version` outputs installed and available version, and checks if you are up to date.

## 1.3.0

-   Now with more dependency injection thanks to @victorlap !
-   Added ASCII logo from latest version of Laravel Zero.

## 1.2.1

Updated readme to add notes on updating.

## 1.2.0

-   Cleaning code a little
-   Keeps a track of the lat update time of a record
-   Shows the last update time when doing `doddns records:list`

## 1.1.0

-   Hides unnecesary commands

## 1.0.0

-   First release.
