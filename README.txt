=== Matomo Tracker ===
Contributors: nir0ma
Donate link: https://www.niroma.net/
Tags: matomo, piwik, analytics, tracking code
Requires at least: 3.0.1
Tested up to: 5.2
Requires PHP: 5.6.0
Stable tag: 1.4.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Matomo tracker adds matomo (formerly piwik) tracking code to your website while hiding your matomo installation url

== Description ==

Matomo tracker adds matomo (formerly piwik) tracking code to your website while hiding your matomo installation url. You can choose between php and javascript tracking.
Javascript tracking returns more details about your visitors while php tracking is more robust.

You first need to :

* Have a matomo script running on a custom domain name
* Have a valid token (more info here : https://matomo.org/faq/general/faq_114/)
* Create the website you want to track in Matomo admin to retrieve your website Id

Features :

* Easy to install
* Lightweight
* Hide your matomo domain url

== Installation ==

* Upload `matomo-tracker` to the `/wp-content/plugins/` directory
* Activate the plugin through the 'Plugins' menu in WordPress
* Visit Settings >> Matomo Tracker to add you matomo url and id 
* Check your matomo installation to track your pageviews

== Screenshot ==

1. Matomo Tracker admin page

== Changelog ==

= 1.0.0 =
* Working like a charm :)

= 1.0.1 =
* Fix Minor issue causing google to index plugin folder

= 1.0.2 =
* Fix javascript error from 1.0.1

= 1.0.3 =
* Caching added for js tracker (avoid google pagespeed message)

= 1.1.0 =
* Tracking Mode selection added : You can now choose between Javscript or Php tracking Mode

= 1.2.0 =
* JS Tracking Mode is no more including inline javascript and now calls a JS File 
* JS Tracking file loading mode is now customizable (defer, async or nothing)
* JS Tracking file can be disallowed in robots.txt

= 1.2.1 =
* Added new settings to inline javascript as in previous version
* Workaround to solve js tracking reported issue (https://wordpress.org/support/topic/js-tracking-mode-doesnt-work-since-v-1-2-0/)

= 1.2.2 =
* Now uses enqueue script to enqueue external JS File (No more defer or async option)
* Added an option to disable logged-in users tracking

= 1.3.0 =
* Fixed track.js loading in header

= 1.4.0 =
* Fixed tracking issue for subfolder install