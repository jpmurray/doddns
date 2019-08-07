# doddns

A small utility to use Digital Ocean as a Dynamic DNS (DDNS) service, built with [Laravel Zero](https://github.com/laravel-zero/laravel-zero).

It'll regularly check your IP address and update a selected Digital Ocean domain record with it, if the address changed.

## Requirement

- PHP >= 7.1.3 and Composer installed.
- A Digital Ocean [Personal Access Token](https://www.digitalocean.com/docs/api/create-personal-access-token/) that has the `read` and `write` permission.
- At least one domain name added to your account.
- At least a `cname` or an `A` record added to a domain that DODDNS will try toupdate.

# Docs

You can see installation instruction, usage and other things [in the documentation](https://atomescrochus.gitbook.io/doddns/).

## PRs
Any help is appreciated, please PR to the develop branch.