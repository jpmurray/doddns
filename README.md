# doddns

A small PHP thigny to use one's domain added to Digital Ocean as a dynamic dns service make with [Laravel Zero](https://github.com/laravel-zero/laravel-zero).

It works. Might not be elegant, but it works!

## What is needed

- PHP 7.1.3+
- A Digital Ocean [Personal Access Token](https://www.digitalocean.com/docs/api/create-personal-access-token/). It needs to have `read` and `write` permission.
- Some domains added to your account.
- A `cname` or `A` records added to a domain for us to update.

## How to use

Depending on your mood, you can either [download the compiled version](https://github.com/jpmurray/doddns/raw/master/builds/doddns) or [build it yourself](https://laravel-zero.com/#/usage?id=building-a-standalone-application), then add it to your `$PATH`.

You will have to add your DigitalOcean API token with the `token:add` command and then select which record you want to update with the `record:select` command. Then you're good to go!.

### Updating
#### Version 3.0.0
Version 3.0.0 changed a lot in term of workflow. It is suggested that you remove the `doddns` folder entirely from the `.config` folder in your home directory entirely then add your token and choose the domain to record back again so everything is clean.

#### Before 3.0.0
If you've pulled or downloaded a new version, be sure to run `doddns setup` and choose the upgrade option to make sure your local database is up to date! You can also forgo the menu to upgrade directly using `doddns setup -U`.

### Crontab
If you want doddns to autoupdate your records with your current IP address, you should add an entry to your cron tab like so: `* * * * * php /path-to-doddns/doddns schedule:run >> /dev/null 2>&1`.

After that, doddns will try to update every hours by itself.

### Available commands

You can then use the `doddns` command to see a list of possible actions:

- `ip:last`: will output the last known IP that has been found / used and the timestamp of last update.
- `record:delete`: removes saved record from the config file.
- `record:select`: Display a list of domains and records found with your DigitalOcean token to choose which to update with your current IP address.
- `record:update`: updates the selected record in config file with current IP.
- `token:add {token}`: will set your DigitalOcean personal access token, overwriting any existing value.

## PRs
Any help is appreciated, please PR to the develop branch.