# Yii2 User Auth
> Custom User Auth Yii2 Extension ported from User Auth Project

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-coveralls]][link-coveralls]
[![Total Downloads][ico-downloads]][link-downloads]

# Features
* User registration
* User authentication
* Automatic Password Generation

## Install

Via Composer

``` bash
$ composer require cottacush/yii2-user-auth
```

## Requirements

The following versions of PHP are supported by this version.

* PHP 5.5
* PHP 5.6


to the require section of your `composer.json` file.


Usage
-----
```bash
 APPLICATION_ENV=development ./yii migrate install --migrationPath=@vendor/cottacush/yii2-user-auth/migrations
```

## Security

If you discover any security related issues, please email <developers@cottacush.com> instead of using the issue tracker.

## Credits

- [Adeyemi Olaoye][link-author]
- [Tega Oghenekohwo][link-tega]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/cottacush/yii2-user-auth.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/CottaCush/yii2-user-auth/master.svg?style=flat-square
[ico-coveralls]: https://coveralls.io/repos/github/CottaCush/yii2-user-auth/badge.svg?branch=master
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/cottacush/yii2-user-auth.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/cottacush/yii2-user-auth.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/cottacush/yii2-user-auth.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/cottacush/yii2-user-auth
[link-travis]: https://travis-ci.org/CottaCush/yii2-user-auth
[link-coveralls]: https://coveralls.io/github/CottaCush/yii2-user-auth?branch=master
[link-scrutinizer]: https://scrutinizer-ci.com/g/cottacush/yii2-user-auth/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/cottacush/yii2-user-auth
[link-downloads]: https://packagist.org/packages/cottacush/yii2-user-auth
[link-author]: https://github.com/yemexx1
[link-tega]: https://github.com/tegaphilip
[link-contributors]: ../../contributors