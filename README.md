Inchoo-Flickr-Gallery
=====================

Inchoo Flick Gallery is an easy-to-use Magento module that will integrate any Flickr gallery into your Magetno website. It is fully customizable using a simple Magento back-end configuration page and it uses Flickr API to get all the required information and data.
Module is tested on Magento 1.6 and 1.7

Features
---------------
  * Automatically gets all the photosets from the specified user and makes them available in Magento back-end
  * Allows you to choose which photosets you want to display on the site
  * Configurable pagination
  * Configurable thumbnail size
  * Configurable tooltips with different skin styles to choose from
  * Integrated Lightbox that can be disabled if you want to use your own
  * Fully customizable carousel block that can be added to any page
  * Fully customizable Flickr API response caching for increased performance
  * Using AJAX to eliminate the page loading delay caused by Flickr API requests


How to install?
---------------
Download Inchoo Flickr Gallery module files to your Magento root directory. Module files will be extracted into the base package / default template so if you have your own package just copy the module files to your package / template directories.

If you are logged in to your Magento back-end you have to log out and then log in again. Clearing the cache would also be a good idea.


Configuration
-------------
Inchoo Flickr Gallery module is made to be fully and easily configurable form Magento back-end. Just go to System -> Configuration -> Inchoo -> Flickr Gallery to find all the available configuration options.
To get started you’ll need to have a Flickr API Key and User ID. Go to http://www.flickr.com/services/api/misc.api_keys.html to get your own Flickr API Key and http://idgettr.com/ for your User ID.
Once you enter your API Key and User ID save your configuration and you will get the list of all the photosets available for the user specified with the User ID. You can select all of them or just the ones you want to show on the site and save your configuration. That should be enough get the gallery up and running.
All the other configuration options are pretty straight forward with useful descriptions so there is no need to explain them separately.


How to access the gallery on the front-end?
-------------------------------------------
By default, Inchoo Flickr Gallery module adds a link to the footer but you can open the gallery directly at www.yoursite.com/gallery
