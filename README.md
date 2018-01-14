# Nomad

## About Nomad

Nomad gives you the power of Laravel's [database migrations](https://laravel.com/docs/5.5/migrations) without the need for a full Laravel installation.

This is particularly useful where you have multiple applications accessing a single database, but you aren't sure which should be responsible for managing the database schema. By extracting your migrations to a separate repository, you can maintain full version control over your database schema, without worrying about different applications trying to run the migrations on the same database.

## Installation

Nomad is built as a utility to support another repository. Learn more about this [here](https://github.com/michaeldyrynda/vagabond).

Should you choose to use the Nomad library directly, first install it using [Composer](https://getcomposer.org).

```
composer require dyrynda/nomad
```

A sample configuration file is provided in `config/database.php`, which you can change as needed for your database environment.

You may then run the `nomad` application and access the available commands.

## Usage

For information on the available commands and their functions, be sure to check out Laravel's [migration documentation](https://laravel.com/docs/5.5/migrations).

## Credits

Special thanks to [Nuno Maduro](https://twitter.com/enunomaduro) for the work he has done with [Laravel Zero](http://laravel-zero.com), which helped pave the way for me to finally bring this project to life.

## Support

If you are having general issues with this repository, feel free to contact me on [Twitter](https://twitter.com/michaeldyrynda).

If you believe you have found an issue, please report it using the [GitHub issue tracker](https://github.com/michaeldyrynda/nomad/issues), or better yet, fork the repository and submit a pull request.

If you're using this repository, I'd love to hear your thoughts. Thanks!
