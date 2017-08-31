# Fanoe

**Contributors:** Florian Brinkmann  
**Requires at least:** WordPress 4.7  
**Tested up to:** WordPress 4.8.1  
**Version:** 2.0.0  
**License:** GPLv2 or later  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  

## Description

The Fanoe theme is a fully responsive theme with a off canvas sidebar. The post formats are highlighted with different background colors. In the customizer you can change things like the design color, background-image for the header text and so on.

## Copyright

Fanoe WordPress Theme, Copyright 2017 Florian Brinkmann
Fanoe is distributed under the terms of the GNU GPL

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

**Fanoe bundles the following third-party resources:**

ally.js v1.4.1, Copyright Rodney Rehm  
License: MIT License  
Source: https://github.com/medialize/ally.js 

normalize.css v5.0.0, Copyright Nicolas Gallagher  
License: MIT License  
Source: https://github.com/necolas/normalize.css 

## Changelog

### 2.0.0 – 31.08.2017

**This release requires WordPress 4.7 or higher**

#### Added
* Support for custom logo feature.

#### Changed
* Code refactoring.
* Doc improvements.
* Use HTML5 markup for galleries.
* moved functions from functions.php to various files inside the inc folder.
* moved template partials (content- files) inside partials folder.
* use @version comment for each PHP file, so you can use the »Child Theme Check« plugin (https://wordpress.org/plugins/child-theme-check/).
* no longer include Source Code Pro as code font.
* use get_theme_file_uri() to enqueue scripts and styles.

#### Removed
* Social media widget. Use a plugin instead (for example https://wordpress.org/plugins/svg-social-menu/).
* Social share button feature. Use a plugin instead, so you also have them after switching the theme.
* matchmedia.js, HTML5 shiv, and styles for browsers lower than IE7.
* menu position for sidebar. You are more flexible with using the menu widget for displaying menus.
* Copyright customizer setting. You can use a text widget to add that.
* Header image and background image support.
* background colors for post formats (a few colors did not look very well…).
* support for various post formats (do not need them after removing background colors).
* Option to set text for sidebar button.

### 1.4.9 – 30.05.2016
* removed deprecated tags from style.css

### 1.4.8 – 09.12.2015
* removed http protocol from google font url

### 1.4.7 – 17.04.2015
* added missing string in german and french translation

### 1.4.6 – 16.04.2015
* small css fix

### 1.4.5 – 16.04.2015
* fixed wrong text colors for some elements in post formats
* optimized sanitizing of custom css (https://themes.trac.wordpress.org/ticket/23796#comment:2) 
* added parameter id to register_sidebar() in functions.php (shown as Deprecated Call from the Deprecated Call Plugin)

### 1.4.4 – 18.03.2015
* small corrections in the css
* added sanitize callbacks to the add_setting functions in the Customizer
* added rel="nofollow" to the link to my homepage (in the sidebar)
* removed the title tag from header.php and added add_theme_support( 'title-tag' ); in functions.php

### 1.4.3 – 06.07.2014
* reduced a few margins for small displays
* now the name of the author is displayed in the blogview
* bigger font-size for small displays

### 1.4.2 – 17.05.2014
* fixed a problem with formats from date and time at articles and comments – now you can change the format in the backend at the point „Settings > General“. For german, dutch and france the format was „j F Y“ in the „Custom“-Input from „Date Format“ and „h:i“ in the Custom-Field „Time Format“. Its automatically separated by an „@“.

### 1.4.1 – 13.05.2014
* added a few translations in german, french and dutch

### 1.4 – 12.05.2014
* added a Sharing-Button for LinkedIn
* reduced the sidebar – less wide
* added a print-button and a print-stylesheet
* now the sharing-buttons in the single view appear directly under the content

### 1.3.1 – 19.02.2014
* fixed a Problem with the captions, if the Featured-Image is used for more than one article.

### 1.3 – 18.02.2014
* the Featured Images are now linking to the full article
* You can add a description to the Featured Image, using the field "Caption" in the Featured-Image-Dialog
* updated the french translation

### 1.2.18 – 31.01.2014
* centered the spinner-image from infinite scroll

### 1.2.17 – 31.01.2014
* added the "responsive-layout" Tag to the style.css

### 1.2.16 – 31.01.2014
* changed the line-height and margins for h1 Headings
* supports ininite scroll from Jetpack

### 1.2.15 – 12.09.2013
* now you can replace the Sidebar Button (the stripes) with your own Text in the Theme Customizer
* replaced the Sharing Buttons in the Single View, so they are displayed next the Sharing-Text

### 1.2.14 – 07.09.2013
* removed the smooth effect from the sidebar button

### 1.2.13 – 05.09.2013
* updated the readme.txt for 1.2.12

### 1.2.12 – 05.09.2013
* fixed a little problem in the style.css

### 1.2.11 – 05.09.2013
* added smooth hover
* replaced the screenshot.png

### 1.2.10 – 14.08.2013
* fixed the problem, that the rss-icon wasn't displayed

### 1.2.9 – 13.08.2013
* added more social media channels to the "social media" widget
* changed the icon font

### 1.2.8 – 12.08.2013
* dutch Translation, thanks to Pauline van der Sluijs
* fixed a little problem with the option "Design Color" in the Theme Customizer (left-border color of the sidebar and active/hover/focus color of the title weren't changed

### 1.2.7 – 11.08.2013
* fixed a problem with the theme-customizer. The checkboxes in the "content" section were defect

### 1.2.6 – 11.08.2013
* Fixed a Problem with HTML in the Copyright-Field

### 1.2.5 – 10.08.2013
* Theme supports custom backgrounds

### 1.2.4 – 10.08.2013
* french Translation, thanks to François Charlet
* fixed the Problem, that the Header Text couldn't be hidden in the Theme Customizer
* fixed a PHP Error, displayed with older PHP Versions
* if the Header-Text is not visible, but an background-image for the Header is set, a link to the Homepage is set

### 1.2.3 – 08.08.2013
* fixed a PHP warning

### 1.2.2 – 08.08.2013
* fixed a little problem with floating images on small displays

### 1.2.1 – 08.08.2013
* now the size of the background-Image can be changed in the Theme Customizer. You can choose, that the Image is displayes normal, or it fills out the whole header, or it has a 100% height and a auto width.
* changed a few things in the style.css

### 1.2 – 06.08.2013
* Replaced the Theme Options Page with the WordPress Theme Customizer. All Changes, which were possible at the Theme Options Page, can now be done over the "Customize" Link under the Theme on the Theme-Page
* now a background-image can be placed in the header (go to "Design>Header")

### 1.1.2 – 04.08.2013
* Set a margin-left for ul and ol, which are children from ul/ol

### 1.1.1 – 31.07.2013
* Set the Font Size to .9em when the viewport is smaller then 452px
* Fixed a little problem with the Author Description

### 1.1 – 30.07.2013
* changed the Font to Libre Baskerville
* changed the Main-Color to a darker green
* set the site-width to 800px
* changed the line-heights and margins for text-elements

### 1.0.6 – 28.07.2013
* replaced jQuery from Google with one from WordPress

### 1.0.5 – 19.07.2013
* replaced the Menu Link
* fixed a problem with the Comment Form

### 1.0.4 – 18.07.2013
* created a function for wp_title

### 1.0.3 – 15.07.2013
* enqueue all stylesheets and scripts from the functions.php, have forgotten a few in ### 1.0.2

### 1.0.2 – 09.07.2013
* Fixed a few Problems, so the Theme can be approved in the WordPress Theme Directory.
	* PHP Warnings and Notices
	* enqueue all stylesheets and scripts from the functions.php
	* enqueue the fonts (Source Sans Pro and Source Code Pro) from the functions.php
	* document the license for the js and font in the readme.txt
	* a few lines were not translation ready

### 1.0.1 – 02.06.2013
Some Changes in the style.css. Removed the Small-Caps Letters

### 1.0 – 01.06.2013
* Initial release
