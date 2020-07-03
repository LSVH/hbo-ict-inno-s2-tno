# eSSIF-Lab for WordPress

> This plugin is current in development, **we recommend not to use this in production!**

![Development Workflow](https://github.com/LSVH/hbo-ict-inno-s2-tno/workflows/Development%20Workflow/badge.svg)
![Deployment Workflow](https://github.com/LSVH/hbo-ict-inno-s2-tno/workflows/Deployment%20Workflow/badge.svg)
![StyleCI](https://github.styleci.io/repos/238925389/shield)
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
    - [Define credentials in the eSSIF-Lab API](#define-credentials-in-the-eSSIF-Lab-API)
    - [Configure the main plugin for use](#configure-the-main-plugin-for-use)
    - [Configure a sub plugin for use](#configure-a-sub-plugin-for-use)
- [Plugin index](#plugin-index)
    - [Main plugin](#main-plugin)
    - [Sub plugins](#sub-plugins)
- [Features](#features)
- [Roadmap](#roadmap)

</details>

## Demo

Just here to check it out? Have a look at the [demo environment](http://essif-lab.ddns.net/wp-login.php).

> Username: admin  
> Password: My_secret123

## How it works?

This plugin interacts with the eSSIF-Lab API service to get the data from all sorts of PDS's. This plugin
connects the users of PDS to WordPress websites. With this plugin WordPress website admins can create a validation
policy to customize the functionality of the plugin to their business process. The users of a PDS can leverage from
these WordPress websites and load their credentials into the web page by the graphical components coming from this
plugin.

To learn more about what this software is capable of, have a look at our [features](#features). For more information
about future plans for this software have a look at the [roadmap](#roadmap). 

_As written above, the plugin currently only supports the retrieval of data from a PDS. Have a look at [the roadmap
](#roadmap) for future plans regarding data issuance._


## Installation for WordPress admin's

### Download plugins from this repository

To install the plugins in this repository consider the following steps:

1. Go to [the page with all the releases](https://github.com/LSVH/hbo-ict-inno-s2-tno/releases/latest).
2. Download the [source code .zip](https://github.com/LSVH/hbo-ict-inno-s2-tno/archive/v1.0.zip).
3. Extract the files from the downloaded zip file and upload the plugins to your WordPress server and move them to the `wp-content/plugins` directory.
4. Before activating any of the sub plugins ensure you have the [required plugins](#sub-plugins) installed.
5. Now you can activate them after installation.

### Define credentials in the eSSIF-Lab API

Before the plugins can be used, you need to define at least one credential in the eSSIF-Lab API. How to do this is described in the [documentation](#TODO add API documentation link when it is available) of this API.

### Configure the main plugin for use

After activating the plugins, they need to be configured for them to work. Perform the following steps:

1. Go to the settings for our plugins at eSSIF-Lab>Settings on the admin page.
2. Enter the relevant details which you received when defining the credentials in the eSSIF Glue API (specifically the URL of the API, the organization signature and the shared secret).
3. Configure the sub plugin you want to use (see [Configure a sub plugin for use](#configure-a-sub-plugin-for-use))
4. Create a Credential Type at eSSIF-Lab>Credential Types on the admin page using the name of the credential you defined in the eSSIF-Lab API.
5. Create a Credential at eSSIF-Lab>Credential on the admin page and add a relation to the Credential Type and to the Inputs that you want the Credential to fill.
   * Optionally you can make the Credential immutable, which means that after it has been loaded the values cannot be changed manually, they can only be deleted via the provided delete button.

### Configure a sub plugin for use
#### Contact Form 7
To configure the Contact Form 7 sub plugin, follow these steps:

1. Change the permalink type to Post name at Settings>Permalinks on the admin page.
2. Create a contact form at Contact>Add New on the admin page.
3. Add the custom shortcode (essif_lab) to create a button which will retrieve credentials.
4. Give the button the name of the input you want to retrieve a credential for.
5. Add the contact form to a page via the shortcode that Contact Form 7 provides for every form.
6. Deactivate and reactivate the Contact Form 7 sub plugin at Plugins on the admin page.

## Installation for contributors

If you want to contribute to one of our plugins, please consider the following steps:

1. Clone this repository (or your fork) locally.
2. Install docker if you have not done so already.
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

To bring SSI to the world of WordPress we need to make dedicated plugins for various third-party plugins to
support all features that the main plugin introduces.
 
### Main plugin

To keep the integrating sub plugins small and (especially important) capable of adapting to changes quickly, we
decided to develop a plugin that serves as the base for all the [sub plugins](#sub-plugins). This plugin
includes all the business logic to make the whole process work.
  
[Check out the source](plugins/essif-lab) of the main plugin.

### Sub plugins

The table below shows for what plugins we have made integrations thus far. The table also shows whether the plugin
supports the validation (VE) and/or the issuance engine (IE) of the eSSIF-Lab API.
 
| Sub plugin name | Integrations for | VE | IE
|-----------------|------------------|----|---
| [essif-lab_contactform7](plugins/essif-lab_contactform7) | [Contact Form 7](https://wordpress.org/plugins/contact-form-7/) | :heavy_check_mark: | :x:

## Features

The plugins support the following features:

- Send a request to an API in the form of a JWT token.
- Load a single value from a credential into a web page.
- Load multiple values from a credential into a web page.
- Temporary persist the retrieved credential(s) so more can be loaded into the web page.
- Offer graphic components to configure:
    - A validation policy to capture a certain business process.
    - A credential to configure what should be retrieved. 
    - An issuer to determine the origin of a credential.
- Tag generator to ease the implementation of our plugin in the Contact Form 7 form editor.
- Allow admin users to customize what API service to use, basically a field with an URL. 

## Roadmap

The following features should be implemented in the near future:

- Improvements to the User Experience, reduce the number of graphical components and clicks necessary.
- Integrate with other software, these seem to be the most important to us:
    - WordPress user management system. When signing up, users need to enter a bunch of personal information. 
      Everything except the username and password could be retrieved from a PDS through our plugin.
    - WooCommerce (a webshop plugin). This plugin is quite big and there are probably multiple processes that we can
      facilitate with our main plugin. One in particular is the order form, where you must enter your address, payment
      credentials and such.
- At some point the implementations should be ready for production and then we should consider adding an
 implementation for the issuance process, by adding support for issuance policies.
