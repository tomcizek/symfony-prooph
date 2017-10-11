# tomcizek/symfony-prooph

[![Build Status](https://img.shields.io/travis/tomcizek/symfony-prooph.svg?style=flat-square)](https://travis-ci.org/tomcizek/symfony-prooph)
[![Quality Score](https://img.shields.io/scrutinizer/g/tomcizek/symfony-prooph.svg?style=flat-square)](https://scrutinizer-ci.com/g/tomcizek/symfony-prooph)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/tomcizek/symfony-prooph.svg?style=flat-square)](https://scrutinizer-ci.com/g/tomcizek/symfony-prooph)

Symfony Bundle extension for <a href="https://github.com/prooph">prooph</a> toolbox family.

## Why bother?
<ol>
	<li>
		It allows you to 
		<a href="https://github.com/tomcizek/symfony-prooph/blob/master/docs/Configuration.md">
			configure prooph libraries through Symfony *.yml config
		</a>
	</li>
	<li>
		It allows you to
		<a href="https://github.com/tomcizek/symfony-prooph/blob/master/docs/AsynchronousMessaging.md">
			configure routes for asynchronous messaging
		</a> with simple bridge interface to adapt your infrastructure.
	</li>
</ol>

<a href="https://github.com/tomcizek/symfony-prooph/blob/master/docs/KeepLearning.md">
	New to Prooph, DDD, CQRS or Event Sourcing? Hunting for inspiration and learning sources?
</a>

# Quick start

### 1) Install this library through composer
`composer require tomcizek/symfony-prooph`

### 2) Register these Bundles in your kernel (app/AppKernel.php)
```php
public function registerBundles()
{
    $bundles = [
        // Other bundles...
        new TomCizek\SymfonyInteropContainer\SymfonyInteropContainerBundle()
        new TomCizek\SymfonyProoph\ProophBundle(),
    ];
}
```

### 3) Setup your configuration for prooph components in your symfony *.yml config!

## Documentation

<ol>
	<li>
		<a href="https://github.com/tomcizek/symfony-prooph/blob/master/docs/Configuration.md">
			Configuration
		</a>
	</li>
	<li>
		<a href="https://github.com/tomcizek/symfony-prooph/blob/master/docs/AsynchronousMessaging.md">
			Asynchronous messaging
		</a>
	</li>
</ol>

## Contribute

Please feel free to fork and extend existing or add new features and send a pull request with your changes! 
To establish a consistent code quality, please provide unit tests for all your changes and may adapt the documentation.
