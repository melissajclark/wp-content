=== Unsplash WP ===
Contributors: dcooney
Donate link: http://connekthq.com/donate/
Tags: stock photo, photos, stock, upload, media library, media, library, ajax, image upload, direct upload, wp media uploader, free stock photos, unsplash, high res, high resolution
Requires at least: 3.6
Tested up to: 4.1
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

One click uploads of unsplash.com stock photos directly to your media library.

== Description ==

**Unsplash WP** is the fastest way to upload high quality stock photos from [unsplash.com](http://unsplash.com) directly to your media library — **all without ever leaving WordPress**! 


= Features =

* Easily upload stock photos without ever leaving the comfort of your WordPress admin.
* Great for rapid devlopment and prototyping with real world imagery.
* Add photos from the plugin page or while editing your posts and pages.


***

= Tested Browsers =

* Firefox (mac + pc)
* Chrome (mac + pc)
* Safari (mac)
* IE 11 & 10

***

= Website =
http://connekthq.com/unsplashwp/

***



== Frequently Asked Questions ==


= Are the images upload to the Media Library? =
Yes, once clicked, the images are processed on the server then uploaded to the Media Library into the various sizes set in your functions.php file.

= Are there server requirements? =

Yes, this plugin needs to be able to write temporary images into wp-content/plugins/unsplash-stock-photo-library directory for image processing prior to being uploaded to the media library. 

Some hosts lock down their servers and you may be required to update your php.ini or .htaccess in order to use this plugin


== Installation ==

How to install Ajax Load More.

= Using The WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'Unsplash Stock Photos'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `ajax-load-more.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download `unsplash-stock-photo-library.zip`
2. Extract the `unsplash-stock-photo-library` directory to your computer
3. Upload the `unsplash-stock-photo-library` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard


== Screenshots ==

1. Plugin Settings and photo listing screen.
2. Edit Post/Page Screen - Launch Unsplash from Add Unsplash button.
3. Unsplash images in a lightbox on your post edit/new/post pages.

== Changelog ==

= 1.1 =
* Improved error and success handling
* Replacing file_get_contents with cURL for image handling.

= 1.0 =
* Initial Commit


== Upgrade Notice ==

* None 


