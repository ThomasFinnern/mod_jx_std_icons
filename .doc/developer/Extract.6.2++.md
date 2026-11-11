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
* Joomla-icomoon icons: icons can be collected

### Method: 

General: Find `$fa-var-` and the text to next `:`is the name. 
The line ends with the font value and additional `;` 
? use assoc list to display icon name
Joomla-icomoon icons: icons can **not** be collected


=======================================================

## fontawesome.css

#### Style of single icon:

```
.fa-comment-alt {
  --fa: "\f27a"; }
```

Value as hex `"\f27a"`

#### Features: 

* **Destinct section for brand icons**
* All icons have a single line even on same font hex number
* The last '}' is now on the same line as the hex code

```
:root, :host {
  --fa-style-family-brands: 'Font Awesome 6 Brands';
  --fa-font-brands: normal 400 1em/1 'Font Awesome 6 Brands'; }
  
  font-family: 'Font Awesome 6 Brands';
```

### Method:

General: Find `--fa: "` and the outer object tells the name and the found line tells the value.  

Order :
1) Find first `--fa: "` and collect them as standard icon values until brand section is indicated 
2) Collect all further `--fa..` as brand values.
* ? icomoon...


=======================================================

## joomla-fontawesome.css

#### Style of single icon(s):

```
.fa.fa-thermometer-4, .fa.fa-thermometer {
  --fa: "ï‹‡";
}
```

Value as unicode ??  `"ï‹‡"`

Mixed brand and standard icons. <br>
New: Section moved below brand icons compared to 6.1 not brand

joomla icomooon replacement:

```
.icon-add:before {
  content: "+";
}
```

#### Features: 


* **Destinct section for brand icons**
* Individual icons are sometimes grouped together in a single row.
* Joomla-icomoon icons: icons can be collected

Info: '.fa.fa ... ' icon section objects are moved since 6.1, but should still be ignored

### Method: 

General: Find `--fa: "` and the outer object `.fa-envelopes-bulk, .fa-mail-bulk` tells the name and the found line tells the value.  

Order :
1) Find first `--fa: "` and collect them as standard icon values until brand section is indicated ``
2) Collect all further `--fa..` as brand values.
3) Joomla-icomoon icons: Look for line starting with `.icon-' and ending with `:before {`. The text between tells the name and in following line the font vlaue can be fetched behind `content: ` 


