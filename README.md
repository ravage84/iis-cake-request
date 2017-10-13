# An IIS compatible CakeRequest

This plugin fixes a problem with IIS (7.x) when users access a URL path with the wrong casing.
IIS does not handle this correctly.
The solution is to make CakePHP handle the URL paths cake insensitive.
Thus the [IISCakeRequest class](Lib/IISCakeRequest.php) replaces the
problematic code in CakePHP's CakeRequest.
This is necessary as the core developers didn't want to change the way
CakePHP handles this as it is a problem with IIS but not with CakePHP.

Read the [backstory on GitHub](https://github.com/cakephp/cakephp/pull/1359).

## Installation

Follow the
[CakePHP plugins installation guide](http://book.cakephp.org/2.0/en/plugins/how-to-install-plugins.html)
in the Cookbook.

### Requirements

- PHP >= 5.4
- CakePHP 2.x

## CakePHP Version Support

This plugin only supports CakePHP 2.x.

## Versioning

The releases of this plugin are versioned using [SemVer](http://semver.org/).

## Configuration

This plugin provides or needs no configuration.

## How to use

Replace your ``app/webroot/index.php`` by the one from this plugin at [webroot/index.php](webroot/index.php).

## Contributing

See the [contribution guide](CONTRIBUTING.md).

## TODOs

- Unit Tests
- Add Travis batch
- Add Coveralls batch
- Add Scrutinizer batch

## License

This plugin is licensed under the [MIT License](LICENSE.txt).
