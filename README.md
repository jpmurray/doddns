# doddns

A small PHP thigny to use one's domain added to Digital Ocean as a dynamic dns service make with [Laravel Zero](https://github.com/laravel-zero/laravel-zero).

It works. Might not be elegant, but it works!

## What is needed

- PHP 7.1.3+
- A Digital Ocean [Personal Access Token](https://www.digitalocean.com/docs/api/create-personal-access-token/). It needs to have `read` and `write` permission.
- Some domains added to your account.
- A `cname` or `A` records added to a domain for us to update.

## How to use

Depending on your mood, you can either [download the compiled version](https://github.com/jpmurray/doddns/raw/master/builds/doddns) or [build it yourself](https://laravel-zero.com/#/usage?id=building-a-standalone-application), then add it to your `$PATH` and run the setup command... And you're good to go!

### Updating?
If you've pulled or downloaded a new version, be sure to run `doddns setup` and choose the upgrade option to make sure your local database is up to date! You can also forgo the menu to upgrade directly using `doddns setup -U`.

### Crontab
If you want doddns to autoupdate with your current IP address, you should add an ntry to your cron tab like so: `* * * * * php /path-to-doddns/doddns schedule:run >> /dev/null 2>&1`.

After that, doddns will try to update every hours by itself.

### Available commands

You can then use the `doddns` command to see a list of possible actions:

- `doddns setup`: Shows a menu to either make first setup / start from cratch, or run upgrade commands after a version bump.
- `doddns set-token {token}`: will set your DO personal access token, overwriting any existing value.
- `doddns last-known-ip`: will output the last known IP that has been found / used.
- `doddns version`: output the installed and available version, and make a basic check if you are up to date or not.
- `doddns records:list`: list any added record that doddns tries to update.
- `doddns records:add`: add a record to update to the database from exiting DO domains.
- `doddns records:remove`: removes a record from doddns' database.
- `doddns records:update`: updates records in database with actual IP.

## PRs
Any help is appreciated, please PR to the develop branch.