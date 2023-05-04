# List J!4 cassiopeia / atumn standard icons (awesome v5.15.4)

This module enables to show the available icons in your own place for all developrs to have a fast search.

This is view is intended to be read by extension developers in the need of selecting an icon. so be free to use it as supporter of developers in your blog, hints or ...

## General info
In general, the available icons can be viewed in
https://docs.joomla.org/J4.x:Joomla_Standard_Font_Awesome_Fonts

Now this list is not styled very nice.
(This may be here too but change in the future hopefully)

Adressing the icons in our component has some pitfalls:

1) Joomla 4 has additional icons useful in the following style  ``` i class="fa fa-adjust"></i> ```
1) Joomla kept for compatibility the J3x style ```<span class="icon-image"> </span>```

* The J3x ico moon icons are not delivered with the installation. Instead the use of for example 'icon-image' is transfered to a matching awesome icon (character)
* Using icons in stadard joomla functions like
   ToolBarHelper::title('some title', 'cogs'); will use the icon 'cogs' and uses icon-cogs for the class to show the icon.
   Wanting to show an icon only available in awesome list and trying 'fas fa-camera-retro' as parameter will not help. In some cases 'none fas fa-camera-retro' will display the desired icon but. there may be sideeffects like empty space and wrong font afterwards

## Technical structure

To determine which icons are supported we may collect all ``` <glyph glyph-name ... ``` in svg files or list all css items with matching Names/IDs

### files fontawesome.css
/media/vendor/fontawesome-free/css/fontawesome.css

standard cassiopeia (site)
/media/system/css/joomla-fontawesome.css
standard atumn (backend)
/media/templates/administrator/atum/css/vendor/fontawesome-free/fontawesome.css

awesome definition
```css
.fa-image:before {
  content: "\f03e";
}
```

icomoon definition
```css
.icon-image:before {
  content: "\f03e";
}
```


### svg files in folder ../webfonts

/media/vendor/fontawesome-free/webfonts

fa-brands-400.svg

fa-regular-400.svg

fa-solid-900.svg


## Fontawesome version info

The following file tells about the version (Actual on writing: Font Awesome Free 5.15.4) and license
/media/vendor/fontawesome-free/css/fontawesome.css


## Pull request to include a icon view into joomla itself

This module derived heavily from following try to include a view of all available icons
into standard joomla CMS

pe7er Peter Martin
Pull Request to add an overview of all available Font Awesome Icons to the System Information tab.

https://github.com/joomla/joomla-cms/pull/37724/files

His pull request was rejected for J!4 as he added the code as feature under the System information, whereas those Icons are template (atum and cassiopeia) and not system related.
