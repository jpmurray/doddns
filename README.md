# doddns

A small PHP thigny to use one's domain added to Digital Ocean as a dynamic dns service make with [Laravel Zero](https://github.com/laravel-zero/laravel-zero).

## What is needed

- A Digital Ocean [Personal Access Token](https://www.digitalocean.com/docs/api/create-personal-access-token/).
- Some domains added to your account.
- A `cname` or `A` records added to a domain for us to update.

## How to use

Depending on your mood, you can either [download the compiled version](https://github.com/jpmurray/doddns/raw/master/builds/doddns) or [build it yourself](https://laravel-zero.com/#/usage?id=building-a-standalone-application), then add it to your `$PATH` and run the setup command... And you're good to go!

### Available commands

You can then use the `doddns` command to see a list of possible actions:

- `doddns setup`: will create local database and asks for DO personal acces token.
- `doddns set-token {token}`: will set your DO personal access token, overwriting any existing value.
- `doddns records:list`: list any added record that doddns tries to update.
- `doddns records:add`: add a record to update to the database from exiting DO domains.
- `doddns records:remove`: removes a record from doddns' database.
- `doddns records:update`: updates records in database with actual IP.