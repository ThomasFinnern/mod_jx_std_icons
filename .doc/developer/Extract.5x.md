# J! 6.2++: How to extract font awesome nd icomoon icons from joomla files 

Three files, two used 

Used file:
* JPATH_ROOT . '/media/vendor/fontawesome-free/scss/_variables.scss';
* JPATH_ROOT . '/media/system/css/joomla-fontawesome.css';

Other files:
* JPATH_ROOT . '/media/vendor/fontawesome-free/scss/fontawesome.css';

=======================================================

## _variables.scss

#### Style of single icon:

```
$fa-var-envelope-open: \f2b6;
```

Value as hex `\f27a`

At the end is a variable to name section

```
$fa-icons: (

...
   "bars": $fa-var-bars,
...
}

$fa-brand-icons: (

...
"envelope-open-text": $fa-var-envelope-open-text,
...
}
```

The name text to be used ?may? differ from the variable name


#### Feature: ? 

* **Destinct section for brand icons** 
* Brand icons start after empty line / with line `$fa-var-monero: \f3d0;`
* Text to varible association list

### Method: 

General: Find `$fa-var-` and the text to next `:`is the name. 
The line ends with the font value and additional `;` 
? use assoc list to display icon name
Joomla-icomoon icons: icons can **not** be collected


=======================================================

## fontawesome.css

% not documented yet

=======================================================

## joomla-fontawesome.css

% not documented yet


