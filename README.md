Contao DependentMandatoryFormField Extension
============================================

Provides an additional option for form field to be defined as dependent mandatory. Field is mendatory if another field (or more) is filled / or not.


Installation
------------

The extension is not published in contao extension repository.
Install it manually.


Tracker
-------

https://github.com/cliffparnitzky/DependentMandatoryFormField/issues


Screenshot
----------

![Screenshot](https://raw.github.com/cliffparnitzky/DependentMandatoryFormField/master/screenshot.jpg)


Compatibility
-------------

- min. version: Contao 2.9.5
- max. version: Contao 3.0.0


Dependency
----------

- There are not dependent extensions, that have to be installed.


Additional information
----------------------

### CSS Tip

Adding special css, will show the difference between **mandatory** and **dependent mandatory** form fields.

This is only an example:

	.dependent span.mandatory:after {
			content: ')';
	}
	.dependent span.mandatory:before {
			content: '(';
	}
	.dependent span.mandatory {
			font-size: 8px;
			vertical-align: super;
			color: orange;
	}