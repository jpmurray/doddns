# doddns

A small utility to use Digital Ocean as a Dynamic DNS (DDNS) service, built with [Laravel Zero](https://github.com/laravel-zero/laravel-zero).

It'll regularly check your IP address and update a selected Digital Ocean domain record with it, if the address changed.

## Requirement

- PHP >= 7.3 and Composer installed.
- A Digital Ocean [Personal Access Token](https://www.digitalocean.com/docs/api/create-personal-access-token/) that has the `read` and `write` permission.
- At least one domain name added to your account.
- At least a `cname` or an `A` record added to a domain that DODDNS will try to update.

## Installation / Usage

Using composer, you will need to run the following command to install DODDNS into the global space:

```
composer global require jpmurray/doddns
```

For DODDNS to work correctly you will have to make sure composer vendor's bin folder is added to your system's `$PATH`. You can test it by typing `doddns` in your terminal of choice: if it is installed correctly, you should be seeing commands usage instructions.

Next, you will have to add your DigitalOcean API token with the `token:add` command and then select which record you want to update with the `record:select` command.

Once it's done, you're good to go!

## Available commands

You can then use the doddns command to see a list of possible actions:

- `ip:last`: will output the last known IP that has been found / used and the timestamp of last update.
- `ip:current`: will query ipcheck.doddns.com to get your current IP address.
- `notifications:toggle`: turn desktop notification on or off (default is off).
- `record:delete`: removes saved record from the config file.
- `record:select`: Display a list of domains and records found with your DigitalOcean token to choose which to update with your current IP address.
- `record:update`: updates the selected record in config file with current IP.
- `token:add {token}`: will set your DigitalOcean personal access token, overwriting any existing value.

### Automatic updates

If you want DODDNS to update your selected domain record automatically with your current IP address, you will have to add entry to your cron tab like so:

```
* * * * * php /path-to-doddns/doddns schedule:run >> /dev/null 2>&1.
```

After that, DODDNS will try to update every hours by itself.

## Updating DODDNS

### Version 3.0.0 and after

Version 3.0.0 changed a lot in term of workflow. If you install DODDNS from before 3.0.0, it is suggested that you remove the doddns folder entirely from the .config folder located in your home directory then start back from scratch so everything is clean.

### Before 3.0.0

If you've pulled or downloaded a new version, be sure to run doddns setup and choose the upgrade option to make sure your local database is up to date! You can also forgo the menu to upgrade directly using `doddns setup -U`.

## PRs
Any help is appreciated, please PR to the develop branch.
