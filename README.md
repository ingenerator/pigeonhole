# Pigeonhole - clean flash message management for Kohana

[![License](https://poser.pugx.org/ingenerator/pigeonhole/license.svg)](https://packagist.org/packages/ingenerator/pigeonhole)

[![Latest Stable Version](https://poser.pugx.org/ingenerator/pigeonhole/v/stable.svg)](https://packagist.org/packages/ingenerator/pigeonhole)
[![Total Downloads](https://poser.pugx.org/ingenerator/pigeonhole/downloads.svg)](https://packagist.org/packages/ingenerator/pigeonhole)
[![Latest Unstable Version](https://poser.pugx.org/ingenerator/pigeonhole/v/unstable.svg)](https://packagist.org/packages/ingenerator/pigeonhole)

Pigeonhole is a simple flash messaging library for Kohana.

## Installation

Add config to your composer.json and run `composer update` to install it. Note that we recommend forcing all
kohana modules into your standard composer vendor directory. If you want to use the old-style MODPATH, then
don't use the "extra" composer config option.

```json
{
  "require": {"ingenerator/pigeonhole": "^1.0"},
  "extra":   {"installer-paths":{"vendor/{$vendor}/{$name}":["type:kohana-module"]}}
}
```

In your bootstrap, add it to your modules list:
```php
    Kohana::modules(array(
        'pigeonhole' => BASEDIR.'vendor/ingenerator/pigeonhole' 
        // Or MODPATH.'pigeonhole' if using old-style kohana paths
    );
```

## Basic Usage

To set a simple string message:

```php
class Controller_Something {
    public function action_message() {
        $message    = new \Ingenerator\Pigenohole\Message(
            'Look Out!', 
            'There\'s a monster behind you', 
            \Ingenerator\Pigeonhole\Message::DANGER
        );
        $pigeonhole = new \Ingenerator\Pigeonhole\Pigeonhole(Session::instance());
        $pigeonhole->add($message);
        $this->redirect('/');
    }
}
```

For the simplest way to render messages using Kohana's native view rendering:
```php
/// views/template/global.php
<html>
<head>
  <link rel="stylesheet" 
        href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
</head>
<body>
    <?=View::factory(
        'pigeonhole/messages', 
        array('pigeonhole' => new \Ingenerator\Pigeonhole\Pigeonhole(Session::instance()))
    )->render();?>
</body>
```

Note that we actually recommend you use view models and manage the pigeonhole class and nested view outside the template.
It's obviously easy to render the messages to support any CSS setup, we render for bootstrap by default.

## Message types

In addition to simple string messages, we provide built-in handling for some additional common message types.

### Validation messages

Formats the output of kohana validation errors with a given message file:

```php
$validation = Validation::factory($post)->rule('email', 'not_empty');
$message = new \Ingenerator\Pigeonhole\Message\ValidationMessage(
    $validation, 
    'forms/login'
);
```

### Kohana messages

Looks up the title and message in a kohana messages file and replaces any provided parameters:

```php
/// APPPATH/messages/actions.php
return array(
    'signed_in' => array(
      'title'   => 'Welcome',
      'message' => ':email, you are now logged in'
    )
);

/// Controller
$message = new \Ingenerator\Pigeonhole\Message\KohanaMessage(
    'actions', 
    'signed_in', 
    array(':email' => $email), 
    \Ingenerator\Pigeonhole\Message::SUCCESS
);
```

## Testing and developing

pigeonhole has a suite of [PhpSpec](http://phpspec.net) specifications. You'll need a skeleton Kohana application to 
run them, you can use [koharness](https://github.com/ingenerator/koharness) to create one. See [test.yml](.github/workflows/test.yml) for 
the build steps required.

Contributions will only be accepted if they are accompanied by well structured specs. Installing with composer should
get you everything you need to work on the project.

## License

pigeonhole is copyright 2014 inGenerator Ltd and released under the [BSD license](LICENSE).
