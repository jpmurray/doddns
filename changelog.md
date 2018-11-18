# Changelog

# X (Next release)
- Nothing yet.

# 2.0.0
- Moved configuration files to the `.config` directory of the user's home. *Be sure to run the upgrade command*.

# 1.4.0
- Records the latest IP that has been found / use while running the update command.
- Adds a new command to see the latest known ip: `doddns last-known-ip`.
- Updates IP with Digital Ocean only when the current IP is different than the last known IP.
- Answering no to the database overwrite on setup actually stops the process.
- `doddns setup` now show a menu with different options: first time setup, start from scratch and upgrade.
- `doddns version` outputs installed and available version, and checks if you are up to date.

# 1.3.0
- Now with more dependency injection thanks to @victorlap !
- Added ASCII logo from latest version of Laravel Zero.

# 1.2.1
Updated readme to add notes on updating.

# 1.2.0
- Cleaning code a little
- Keeps a track of the lat update time of a record
- Shows the last update time when doing `doddns records:list`

# 1.1.0
- Hides unnecesary commands

# 1.0.0
- First release.