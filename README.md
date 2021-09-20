# Multi User Content Management System
The user can write and edit his own articles and control comments on his article, with a system of notifications to the user when there is a new comment on his article.

With the ability to search in articles, main menu, latest added articles, latest comments, articles by a category, tags, and articles by archive

In addition to a control panel for each user and a control panel for managing the site with supervisors according to the permissions

And the system of controlling the settings of the site and with a system of notifications for the administration
And fixed pages and messages contact us

## API documentation:
```http request
https://documenter.getpostman.com/view/17453126/UUxtGBMV
```

## Packages:

### 1. Zizaco/entrust
- [Zizaco](https://github.com/Zizaco/entrust).
Entrust is a succinct and flexible way to add Role-based Permissions to Laravel 5.

- [mindscms](https://github.com/mindscms/entrust).
Entrust (Laravel 8 Package) - Copied & Customized from (Zizaco/Entrust)

### 2. Intervention image & imagecache
- [Intervention](http://image.intervention.io)
is an open source PHP image handling and manipulation library. 
  It provides an easier and expressive way to create, edit, and compose images, create image thumbnails, watermarks or 
  format large image files Intervention Image helps you to manage every task

### 3. laravel collective
- [laravel collective](https://laravelcollective.com/docs/6.x/html)
package HTML comes packed with an HTML and FORM generator allowing you to handle easy to manage forms in your blade files as well as intricate model binding to your forms.

### 4. cviebrock/eloquent-sluggable
- [Eloquent-Sluggable](https://github.com/cviebrock/eloquent-sluggable)
Easy creation of slugs for your Eloquent models in Laravel.

### 5. nicolaslopezj/searchable
- [Eloquent model search trait](https://github.com/nicolaslopezj/searchable)
Searchable, a search trait for Laravel
Searchable allows you to perform searches in a table giving priorities to each field for the table and it's relations.

This is not optimized for big searches, but sometimes you just need to make it simple (Although it is not slow).

### 6. Cache(predis/predis)
- [Redis client](https://github.com/predis/predis)
A flexible and feature-complete Redis client for PHP.

### 7. (stevebauman/purify)
- [Purify](https://github.com/stevebauman/purify)
 is an HTML input sanitizer for Laravel.

### 8. (barryvdh/laravel-debugbar)
- [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar)
This is a package to integrate PHP Debug Bar with Laravel. It includes a ServiceProvider to register the debugbar and attach it to the output. You can publish assets and configure it through Laravel. It bootstraps some Collectors to work with Laravel and implements a couple custom DataCollectors, specific for Laravel. It is configured to display Redirects and (jQuery) Ajax Requests. (Shown in a dropdown) Read the documentation for more configuration options.

### 9. (spatie/valuestore)
- [valuestore](https://github.com/spatie/valuestore)
This package makes it easy to store and retrieve some loose values. Stored values are saved as a json file.

### 10. (laravel-livewire)
- [Livewire](https://laravel-livewire.com/docs/2.x/installation)
Livewire is a full-stack framework for Laravel that makes building dynamic interfaces simple, without leaving the comfort of Laravel.

## Notifications System
Notify New Comment For Admin & Notify New Comment For Post Owner

### Server Side
#### 1. (Laravel Websockets)
- [beyondcode/laravel-websockets](https://github.com/beyondcode/laravel-websockets)
Laravel WebSockets is a package for Laravel 5.7 and up that will get your application started with WebSockets in no-time! It has a drop-in Pusher API replacement, has a debug dashboard, realtime statistics and even allows you to create custom WebSocket controllers.

#### 2. (Pusher Channels)
- [pusher/pusher-php-server](https://github.com/pusher/pusher-http-php)
PHP library for interacting with the Pusher Channels HTTP API

### Client Side
#### 1. (Vuejs)
- [Vue.js](https://vuejs.org)
 The Progressive JavaScript Framework.
 
#### 2. (Axios)
- [axios/axios](https://github.com/axios/axios)
Promise based HTTP client for the browser and node.js

#### 3. (laravel-echo)
- [laravel/echo](https://github.com/laravel/echo)
is a JavaScript library that makes it painless to subscribe to channels and listen for events broadcast by your server-side broadcasting driver.
 
#### 4. (pusher-js)
- [pusher-js package](https://pusher.com/docs/channels/getting_started/javascript)
using the Pusher Channels broadcaster you will have published an event to your web app using Channels

### To make the notification system work
```shell script
php artisan websocket:serve
```

```shell script
php artisan queue:work
````

## Avatar
An "avatar" is an image that represents you online—a little picture that appears next to your name when you interact with websites.

### Gravatar gravatar.com
[gravatar.com](https://ar.gravatar.com/site/implement/images/php/)
A Gravatar is a Globally Recognized Avatar. You upload an image and create your public profile just once, and then when you participate in any Gravatar-enabled site, your Gravatar image and public profile will automatically follow you there.

## Plugin jQuery (Vendors)

### summernote.org
[Summernote](https://summernote.org/)
Super Simple WYSIWYG, Editor on Bootstrap

### kartik-v/bootstrap-fileinput
[File Input](https://plugins.krajee.com/file-input)
An enhanced HTML 5 file input for Bootstrap 5.x/4.x./3.x with file preview, multiple selection, and more features.

### select2/select2
[Select2](https://github.com/select2/select2)
is a jQuery based replacement for select boxes. It supports searching, remote data sets, and infinite scrolling of results.

## Themes

### Frontend Theme
- [Boighor – Free Books Library eCommerce Store](https://freethemescloud.com/item/boighor-free-books-library-ecommerce-store)
 is a neat, clean and simple designed bookstore website template. This HTML5 template is perfect for your eCommerce project. It is powered with Bootstrap4. The fully responsive template Boighor looks great on all types of screens and devices. The cross-browser optimized Boighor – Bookshop Responsive Bootstrap 4 Temple is the best for the library, book publisher, book author, book writer, and book library. Try it now!
- [Preview](https://preview.hasthemes.com/boighor-v3/index.html)

Cross Browser Supported
Well Commented
W3C Validated Code
Fully Responsive Design

### Backend Theme

- [SB Admin 2](https://startbootstrap.com/theme/sb-admin-2)
A free Bootstrap 4 admin theme built with HTML/CSS and a modern development workflow environment ready to use to build your next dashboard or web application
- [Preview](https://startbootstrap.com/previews/sb-admin-2)

### Project Screenshots

![Screenshot](./ProjectScreenshots/1.png?raw=true)

![Screenshot](./ProjectScreenshots/1-5.png?raw=true)

![Screenshot](./ProjectScreenshots/2.png?raw=true)

![Screenshot](./ProjectScreenshots/3.png?raw=true)

![Screenshot](./ProjectScreenshots/4.png?raw=true)

![Screenshot](./ProjectScreenshots/5.png?raw=true)

![Screenshot](./ProjectScreenshots/6.png?raw=true)

![Screenshot](./ProjectScreenshots/7.png?raw=true)

![Screenshot](./ProjectScreenshots/8.png?raw=true)

![Screenshot](./ProjectScreenshots/9.png?raw=true)

![Screenshot](./ProjectScreenshots/9.5.png?raw=true)

![Screenshot](./ProjectScreenshots/10.png?raw=true)

![Screenshot](./ProjectScreenshots/12.png?raw=true)

![Screenshot](./ProjectScreenshots/13.png?raw=true)

![Screenshot](./ProjectScreenshots/14.png?raw=true)

![Screenshot](./ProjectScreenshots/15.png?raw=true)

![Screenshot](./ProjectScreenshots/16.png?raw=true)

![Screenshot](./ProjectScreenshots/17.png?raw=true)

![Screenshot](./ProjectScreenshots/18.png?raw=true)

![Screenshot](./ProjectScreenshots/19.png?raw=true)

![Screenshot](./ProjectScreenshots/20.png?raw=true)

![Screenshot](./ProjectScreenshots/21.png?raw=true)

![Screenshot](./ProjectScreenshots/22.png?raw=true)

![Screenshot](./ProjectScreenshots/23.png?raw=true)
