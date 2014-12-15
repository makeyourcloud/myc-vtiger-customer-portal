MYC Vtiger Customer Portal
============================================
Alternative vTiger Customer Portal - Bootstrap 3 Based - Modular Code


UPDATED VERSION 0.5 - NEW FEATURES & BUX FIXES:

[FIX] - Fixed a problem with the default index module permission, now it follow the order as you set in you CRM in the section customer portal settings
[FIX] - Fixed problems with the translation engine
[FIX] - Optimized attachment upload process
[FIX] - Other general bus fixes
[FIX] - Config files structure reimplemented
[FIX] - Page titles enhanced ( now dynamically generated )
[NEW FEATURE] - Implemented native compatibility with PDFMaker, you don’t need to apply any patch ( on the portal side )
[NEW FEATURE] - Added a New Dashboard view containing the most important modules summary info 
[NEW FEATURE] - Vtwsclib libraries integrated ( vtiger webservices )
[NEW FEATURE] - Fullcalendar javascript libraries integrated (javascript graphic calendar)
[NEW FEATURE] - Google maps API integration ( To show the Event location on map )
[NEW FEATURE] - Added module Events with calendar ( vtiger api credentials required )
[NEW FEATURE] - Added jstz library to help provide support for dynamic event time changing depending on browser timezone
[NEW FEATURE] - Added a new visual configuration tool to help you to set-up and customize your portal
[NEW FEATURE] - Added possibility to upload and set a portal logo from the configuration tool
[NEW FEATURE] - Theme manager with new theme store integrated in the configuration tool that will help you to upload your custom theme zip, set your default theme and discover new themes directly from the store.

NOTES:
To enable the new Event module you are required to set your vtiger api credentials, this is required to enable the Api-related features but not indispensable to make the customer portal working, if you don’t want to insert, or you insert incorrect credentials all the related functionalities will be disabled but the portal will still work as usual.
The same concept is applied to the google map api key, if you don’t provide an api key the map will be disabled and the address text will be displayed instead.

UPDATE INSTRUCTIONS:
This update make some fundamental changes to the base code of the precedent version, our advice is to make a new fresh installation with the new files then apply your  own customization ( copy your themes/modules folders ), we guarantee that the themes and any custom modules are still 100% compatibles.
If you did not make customizations to your theme, just download the updated version from our store and replace it in your portal.
If you made customizations you need just 1 modification to your theme to enable the logo functionality, just do the following:

1 ) In the themes/yourtheme/login.php file, between lines 10/11, before the string “<?php if(isset($loginerror)):  ?>” add the following:

<div class="text-center”>
    <img src="themes/default/assets/img/<?php echo $GLOBALS['portal_logo']?>" style="padding:20px;max-width:100%;”>
</div>

2 )  In the themes/yourtheme/menu.php file, around line 12 replace the string “<a class="navbar-brand" href="index.html">MYC Customer Portal</a>” with the following:

<a class="navbar-brand" href="index.html" style="padding: 5px 15px;”>
     <img src="themes/default/assets/img/<?php echo $GLOBALS['portal_logo']?>" style="max-height:40px;”>
</a>




VERSION 0.1 - PORTAL FEATURES:

-Modular MVC Pattern and Object Oriented Code
-Easily extensible and customizable
-Bootstrap 3 Based layouts and themes
-Support for multiple themes and instant theme preview
-Easy setup: just 3 step and you are under production!
-Easy themes customization without confusion!
-Mobile Ready and 100% Responsive.
-Compatible with vTiger 5.x and 6.x


You can find more info, tutorials and themes on our website:
http://makeyourcloud.com


Copyright 2014 Proseguo s.l. - MakeYourCloud