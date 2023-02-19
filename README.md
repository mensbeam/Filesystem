# Filesystem #

This is a fork of Symfony's Filesystem component which simplifies php's built-in filesystem functions. A common painpoint in using Symfony's component is that it is unnecessarily instantiated:

```php
use Symfony\Component\Filesystem;
$fs = new Filesystem();
$fs->chmod('/path/to/file', 0600);
```

This is awkward because there isn't a reason to instantiate it. There's nothing within Filesystem to create an instance of. There's no defined constructor and no properties to set. In fact only a single static property exists within the class to store the last encountered error. It simply doesn't make any sense. It's especially curious considering the `Path` class that's included with `Filesystem` is itself a static class.

This fork eliminates that nonsense by making everything static:

```php
use MensBeam\Filesystem as Fs;
Fs::chmod('/path/to/file', 0600);
```

## Note ##

This library uses polyfills for `ext-ctype` and `ext-mbstring`. If you have these extensions installed the polyfills won't run. However, if you don't want the polyfills needlessly installed you can do this in your `composer.json`:

```json
{
    "require": {
        "ext-ctype": "*",
        "ext-mbstring": "*"
    },
    "provide": {
        "symfony/polyfill-ctype": "*",
        "symfony/polyfill-mbstring": "*"
    }
}
```