_s_backbone WordPress Starter Theme [![Dockunit Status](https://dockunit.io/svg/tlovett1/_s_backbone?master)](https://dockunit.io/projects/tlovett1/_s_backbone#master)
===

Hi. I'm a starter theme called `_s_backbone` for WordPress based off [_s](https://github.com/Automattic/_s) and the [JSON REST API](https://github.com/WP-API/wp-api) [Backbone client](https://github.com/WP-API/client-js).
I'm very similar to my cousin _s. Really, the only difference between us is that all my loops have infinite scroll built in using a "more" button. Also, I don' support post formats like _s.

I'm a theme meant for hacking so don't use me as a Parent Theme. Instead try turning me into the next, most awesome, WordPress theme out there. That's what I'm here for.

My ultra-minimal CSS might make me look like theme tartare but that means less stuff to get in your way when you're designing your awesome theme. Here are some of the other more interesting things you'll find here:

* A just right amount of lean, well-commented, modern, HTML5 templates.
* A helpful 404 template.
* A sample custom header implementation in `inc/custom-header.php` that can be activated by uncommenting one line in `functions.php` and adding the code snippet found in the comments of `inc/custom-header.php` to your `header.php` template.
* Custom template tags in `inc/template-tags.php` that keep your templates clean and neat and prevent code duplication.
* Some small tweaks in `inc/extras.php` that can improve your theming experience.
* A script at `js/navigation.js` that makes your menu a toggled dropdown on small screens (like your phone), ready for CSS artistry. It's enqueued in `functions.php`.
* 2 sample CSS layouts in `layouts/` for a sidebar on either side of your content.
* Smartly organized starter CSS in `style.css` that will help you to quickly get your design off the ground.
* Licensed under GPLv2 or later like _s. :) Use it to make something cool.

Getting Started
---------------

Download `_s_backbone` from GitHub. The first thing you want to do is copy the `_s_backbone` directory and change the name to something else (like, say, `megatherium`), and then you'll need to do a five-step find and replace on the name in all the templates.

1. Search for `'_s_backbone'` (inside single quotations) to capture the text domain.
2. Search for `_s_backbone_` to capture all the function names.
3. Search for `Text Domain: _s_backbone` in style.css.
4. Search for <code>&nbsp;_s_backbone</code> (with a space before it) to capture DocBlocks.
5. Search for `_s_backbone-` to capture prefixed handles.

OR

* Search for: `'_s_backbone'` and replace with: `'megatherium'`
* Search for: `_s_backbone_` and replace with: `megatherium_`
* Search for: `Text Domain: _s_backbone` and replace with: `Text Domain: megatherium` in style.css.
* Search for: <code>&nbsp;_s_backbone</code> and replace with: <code>&nbsp;Megatherium</code>
* Search for: `_s_backbone-` and replace with: `megatherium-`

Then, update the stylesheet header in `style.css` and the links in `footer.php` with your own information. Next, update or delete this readme.

Now you're ready to go! The next step is easy to say, but harder to do: make an awesome WordPress theme. :)

Good luck!
