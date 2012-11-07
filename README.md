Contao DependentMandatoryFormField Extension
============================================

Provides an additional option for form field to be defined as dependent mandatory. Field is mendatory if another field is filled / or not.


Installation
------------

The extension is not published in contao extension repository.
Install it manually.


Tracker
-------

https://github.com/cliffparnitzky/DependentMandatoryFormField/issues


Compatibility
-------------

- min. version: Contao 2.9.5
- max. version: Contao 2.11.6
- for compatibility with Contao 3.0.x read [here](https://github.com/cliffparnitzky/DependentMandatoryFormField/issues/6#issuecomment-10151430)


CSS Tip
-------

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