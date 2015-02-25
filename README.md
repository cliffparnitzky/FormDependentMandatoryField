[![Latest Version on Packagist](http://img.shields.io/packagist/v/cliffparnitzky/form-dependent-mandatory-field.svg?style=flat)](https://packagist.org/packages/cliffparnitzky/form-dependent-mandatory-field)
[![Installations via composer per month](http://img.shields.io/packagist/dm/cliffparnitzky/form-dependent-mandatory-field.svg?style=flat)](https://packagist.org/packages/cliffparnitzky/form-dependent-mandatory-field)
[![Installations via composer total](http://img.shields.io/packagist/dt/cliffparnitzky/form-dependent-mandatory-field.svg?style=flat)](https://packagist.org/packages/cliffparnitzky/form-dependent-mandatory-field)

Contao Extension: FormDependentMandatoryField
=============================================

Provides an additional option for form field to be defined as dependent mandatory. Field is mandatory if another field (or more) is filled / or not.


Installation
------------

Install the extension via composer: [cliffparnitzky/form-dependent-mandatory-field](https://packagist.org/packages/cliffparnitzky/form-dependent-mandatory-field).

If you prefer to install it manually, download the latest release here: https://github.com/cliffparnitzky/FormDependentMandatoryField/releases


Tracker
-------

https://github.com/cliffparnitzky/FormDependentMandatoryField/issues


Compatibility
-------------

- min. Contao version: >= 3.2.0
- max. Contao version: <  3.5.0


Dependency
----------

- This extension is dependent on the following extensions: [[menatwork/contao-multicolumnwizard]](https://packagist.org/packages/menatwork/contao-multicolumnwizard)


Screenshot
----------

![Screenshot 1](screenshot1.jpg)
![Screenshot 2](screenshot2.jpg)


Additional information
----------------------

### CSS Tip

Adding special css, will show the difference between **mandatory** and **dependent mandatory** form fields.

This is only an example:

````
label.dependent.mandatory:after {
	content: '(*)';
	font-size: 9px;
	vertical-align: super;
	color: #FF7777;
}
````

With the css above, a form like the following will be created:

![Screenshot 3](screenshot3.jpg)