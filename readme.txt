=== Terms to Links ===
Contributors: William P. Davis
Tags: tag,term,category,post,link,automatic
Requires at least: 3.0
Tested up to: 3.1
Stable tag: 0.6
Author URI: http://wpdavis.com

This plugin will automatically link term names in your content to that term's detail page.

== Description ==

This plugin will automatically links to terms in your content to that term's page. Can be used for tags, categories and custom taxonomies. Based on Chen Ju's Automatic Tag Links.

The plugin will only match full words, so if you have a term called "World" and use the word "worldwide" it will link not link world. Furthermore, if you have the term Worldwide Imports it will link the longer term first.

== Installation ==

1. Download the plugin.
3. Upload it to your plugins folder.
4. Activate if from the plugins page.
5. Select the taxonomies to link. 

== Changelog ==
= 0.6 =
* Use set_transient to cache the terms, increase performance.
= 0.5 =
* Auto-select tags and categories as the default links, so the site doesn't break.

== Upcoming features ==
* A better way to store terms in order to ensure better performance and more consistent linking.
* Only link terms with more than x posts.