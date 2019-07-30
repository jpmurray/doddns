# doddns

Small tool to use Digital Ocean as a Dynamic DNS (DDNS) service made with [Laravel Zero](https://github.com/laravel-zero/laravel-zero).

DODDNS will regularly check your IP address and updated a selected Digital Ocean domain record with it, if the address changed.

## What is needed

- PHP 7.1.3+
- A Digital Ocean [Personal Access Token](https://www.digitalocean.com/docs/api/create-personal-access-token/). It needs to have `read` and `write` permission.
- A domain added to your account.
- A `cname` or `A` record added to the domain for DODDNS to update.

## How to use

Using composer, you will need to run the following command:

```ssh
composer global require jpmurray/doddns
```

This will install DODDNS globally on your machine. For DODDNS to work correctly you will have to make sure composer is added to your `$PATH`. You can test it by typing `doddns` in your terminal of choice, you should be seeing commands usage instructions.

Next, you will have to add your DigitalOcean API token with the `token:add` command and then select which record you want to update with the `record:select` command. After that, you're good to go!

### Updating
#### Version 3.0.0
Version 3.0.0 changed a lot in term of workflow. If you install DODDNS from `< 3.0.0`, it is suggested that you remove the `doddns` folder from the `.config` folder in your home directory entirely then add your token and choose the domain to record back again so everything is clean.

#### Before 3.0.0
If you've pulled or downloaded a new version, be sure to run `doddns setup` and choose the upgrade option to make sure your local database is up to date! You can also forgo the menu to upgrade directly using `doddns setup -U`.

### Crontab
If you want doddns to update your records automatically with your current IP address, you should add an entry to your cron tab like so: `* * * * * php /path-to-doddns/doddns schedule:run >> /dev/null 2>&1`.

After that, doddns will try to update every hours by itself.

### Available commands

You can then use the `doddns` command to see a list of possible actions:

- `ip:last`: will output the last known IP that has been found / used and the timestamp of last update.
- `ip:current`: will query ipcheck.doddns.com to get your current IP address.
- `record:delete`: removes saved record from the config file.
- `record:select`: Display a list of domains and records found with your DigitalOcean token to choose which to update with your current IP address.
- `record:update`: updates the selected record in config file with current IP.
- `token:add {token}`: will set your DigitalOcean personal access token, overwriting any existing value.

## PRs
Any help is appreciated, please PR to the develop branch.