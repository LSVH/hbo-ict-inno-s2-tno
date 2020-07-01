# eSSIF-Lab for WordPress

> This plugin is current in development, **we recommend not to use this in production!**

![Development Workflow](https://github.com/LSVH/hbo-ict-inno-s2-tno/workflows/Development%20Workflow/badge.svg)
![Deployment Workflow](https://github.com/LSVH/hbo-ict-inno-s2-tno/workflows/Deployment%20Workflow/badge.svg)
![StyleCI](https://github.styleci.io/repos/238925389/shield)
![Codecov](https://codecov.io/gh/LSVH/hbo-ict-inno-s2-tno/branch/master/graph/badge.svg)
![Repository size](https://img.shields.io/github/repo-size/LSVH/hbo-ict-inno-s2-tno)
![Latest release](https://img.shields.io/github/v/release/LSVH/hbo-ict-inno-s2-tno)

Allow users of your WordPress website to use your website with their Personal Data Store (PDS).

<details>
<summary>Table of content</summary>

## Table of content

- [Demo](#demo)
- [How it works?](#how-it-works)
- [Installation for WordPress admin's](#installation-for-wordpress-admins)
    - [Download plugins from this repository](#download-plugins-from-this-repository) 
    - [Download and install from within WordPress](#download-and-install-from-within-wordpress)
- [Plugin index](#plugin-index)
    - [Main plugin](#main-plugin)
    - [Sub plugins](#sub-plugins)
- [Features](#features)
- [Roadmap](#roadmap)

</details>

## Demo

Just here to check it out? Have a look at the [demo environment](http://52.207.254.225).

> Username: admin  
> Password: My_secret123

## How it works?

This plugin interacts with the eSSIF-Lab's API service in order to get the data from all sorts of PDS's. This plugin
connects the users of PDS to WordPress websites. With this plugin WordPress website admins can create a validation
policy to customize the functionality of the plugin to their business process. The users of a PDS can leverage from
these WordPress websites and load their credentials in to the web-page by the graphical components coming from this
plugin.

To learn more about what this software is capable of, have a look at our [features](#features). For more information
about future plans for this software have a look at the [roadmap](#roadmap). 

_As written above, the plugin currently only supports the retrieval of data from a PDS. Have a look at [the roadmap
](#roadmap) for future plans regarding data issuance._


## Installation for WordPress admin's

Please select the option what suits your needs to help install one of our plugins. 

- [Download plugins from this repository](#download-plugins-from-this-repository)
- [Download and install from within WordPress](#download-and-install-from-within-wordpress)

### Download plugins from this repository

Each release what also will be uploaded to WordPress's plugin repository will also be released here on this
repository. Consider the following steps:

1. Go to [the page with all the releases](/LSVH/hbo-ict-inno-s2-tno/releases/latest).
2. Download the [main plugin](#main-plugin) zip.
3. Download one of the [sub plugins](#sub-plugins).
4. Upload the downloaded zip files to your WordPress server and move them to the `wp-content/plugins` directory.
5. Now you can activate them after installation.

### Download and install from within WordPress

**Note**: _These instructions might not work as expected, since our plugin isn't available on WordPress's repository
 yet._
 
To download and install our plugins directly from within WordPress, consider the following steps:

1. Go to the WordPress plugins page.
2. In the search bar enter `essif-lab`.
3. Install the main plugin.

To enable a [sub plugin](#sub-plugins) for example with _Contact Form 7_ you also need to install the appropriate plugin
for that. In this case that would be the plugin named `essif-lab_contactform7`.
 
## Installation for contributors

If you want to contribute to one of then our plugins please consider the following steps:

1. Clone this repository (or your fork) locally.
2. Install docker if you didn't do so already.
3. In a terminal go to the directory of the cloned repository.
4. Run `cp .env.example .env` and adjust the .env to your needs.
5. Run `docker-compose up -d` to start the WordPress development environment.

Some notes:

- Please use the php cli binary from the `app` service, for example:
  ```
  docker-compose run app \
    php -r 'echo "hello world\n";'
  ```
- To run tests locally use the phpunit binary `vendor/bin/phpunit` located in each plugin directory, for example:
  ```
  docker-compose run app \
    php wp-content/plugins/essif-lab/vendor/bin/phpunit \
        -c wp-content/plugins/essif-lab/phpunit.xml
  ```

## Plugin index

To bring SSI to the world of WordPress we need to make dedicated plugins for various third plugins in order to
support all features of the main plugin introduces.
 
### Main plugin

In order to keep the integrating sub plugins small and especially important capable of adapting changes quickly, we
decided to develop a plugin what serves as the base for all the [sub plugins](#sub-plugins). This plugin
includes all the business logic to make the whole process work.
  
[Check out the source](plugins/essif-lab) of the main plugin.

### Sub plugins

The table below shows for what plugins we made integrations thus far. The table also shows whenever the plugin
supports the validation (VE) and/or the issuance engine (IE) of the eSSIF-Lab API.
 
| Sub plugin name | Integrations for | VE | IE
|-----------------|------------------|----|---
| [essif-lab_contactform7](plugins/essif-lab_contactform7) | [Contact Form 7](https://wordpress.org/plugins/contact-form-7/) | :heavy_check_mark: | :white_check_mark:

## Features

The plugins support the following features:

- Send a request to an API in the form of a JWT token.
- Load a single value from a credential into a web-page.
- Offer graphic components to configure:
    - A validation policy to capture a certain business process.
    - A credential to configure what should be retrieved. 
    - An issuer to determine the origin of a credential.
- Tag generator to ease the implementation of our plugin in the Contact Form 7 form editor.


## Roadmap

The following features should be implemented in the near future:

- Load multiple values from a credential into a web-page.
- Temporary persist the retrieved credential(s) so more can be loaded into the web-page.
- Allow admin users to customize what API service to use, basically a field with an URL. 
- Improvements to the User Experience, reduce the amount of graphical components and clicks necessary.
- Adjust the domain to the now known eSSIF-Lab API service and refactor the code accordingly.
- Integrate with other software, these seem to be the most important to us:
    - WordPress its user management system. When signing up users need to enter a bunch of personal information. 
      Everything except the username and password could be retrieved from a PDS through our plugin.
    - WooCommerce a webshop plugin. This plugin is quite big and there are probably multiple processes that we can
      capture into our main plugin. But one in particular is the order form, where you have to enter address, payment
      credentials and such.
- At some point the implementations should be ready for production and then we should consider adding an
 implementation to the issuance process. By adding support for issuance policies.
