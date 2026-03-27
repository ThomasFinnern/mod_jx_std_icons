# List Joomla! standard icons available in templates cassiopeia/atum

This module enables to display the available Joomla! icons with names in your own site so other developers may find and search for these icons.

This view is intended to be read by extension developers in the need of selecting an icon. So be free to use it as supporter of developers in your blog, hints or ...

## General info
In general, the available icons can be viewed in
[Joomla_Standard_Font_Awesome_Fonts](https://docs.joomla.org/J4.x:Joomla_Standard_Font_Awesome_Fonts).
Now this list is not formatted very nicely.

## Generated views

Any icon is displayed in a box with name below
Each icon table has a short introduction how to use this type of icon
1) Short introduction text about the technical side of joomla icons
1) Icon list for class 'icon-[Name]' icons (**icomoon* replacements)
1) Icon list for fontawesome **standard** class 'fa fa-[name]' icons
1) Icon list for fontawesome **brand** class 'fa fa-[name]' icons

## Parameter

The setting page enables to switch on(off each of the lists )

## The origin of the idea

I missed the display of available template icons. I saw a 
[pull request from 'pe7er' Peter Martin](https://github.com/joomla/joomla-cms/pull/37724) 
which gave me the starting point and some code

## Technical structure

Available for J5x/J6x the code reads following files
* /media/system/css/joomla-fontawesome.css  
* /media/vendor/fontawesome-free/scss/_variables.scss

### Extraction by file joomla-fontawesome.css

template cassiopeia (site): ```media/system/css/joomla-fontawesome.css```  
template atum (backend):  ```media\templates\administrator\atum\css\vendor\fontawesome-free\fontawesome.css```

The file can divided into segments (lines) 'icon.!name', 'standard icons' and 'brand icons' in this order.
Following lines were found and used to collect the names:

icon-!name! definition lines:
```css
.fa-down-left-and-up-right-to-center, .fa-compress-alt {
  --fa: "";
}
```

font awesome definition lines:
```css
.fa.fa-envelope-o {
  --fa: "";
  font-family: "Font Awesome 6 Free";
  font-weight: 400;
}
```

fontawesome brand icon can be determined like above. The section starts after ```font-family: "Font Awesome 6 Brands";``` line.


### Extraction by file _variables.scss

The file can divided into segments 'standard icons' and 'brand icons' in this order.
Following lines were found and used to collect the names 

The file defines in the first section the 'char' values of each icon.
The indicator for standard section is: ```$fa-icons: (``` and for brand icon section ```$fa-brand-icons:``` .

scss fontawesome name definition lines:
```
  "envelope-open": $fa-var-envelope-open,
```

## Fontawesome version info

The version info is taken from file ```media/system/css/joomla-fontawesome.css``` in first section
