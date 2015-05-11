# Starter Package for new WordPress projects with:

### mu-plugins/ 
- In this directory there is a _must-use-plugin_ titled Starter Theme Functionality. This plugin contains useful functions that are project-related rather than theme-related.
- _Must Use Plugins_ are executed (ie. activated automatically) before any other plugins, and cannot be disabled by the user. This is a great way to store important functionality for a WordPress project, and ensure it won't be accidentally deactivated or removed. 
- Functions in the plugin: removal of the default link to attachment file on images, removal of the `<p>` tag around images, setup of custom editor styles, customization of the excerpt 
- **Resources:**
    - _[Must Use Plugins](https://codex.wordpress.org/Must_Use_Plugins)_ - WordPress Codex article
    - Creation of this plugin was inspired by this CSS-Tricks article: _[WordPress Functionality Plugins](https://css-tricks.com/wordpress-functionality-plugins/)_
    - _[Add Editor Style](https://codex.wordpress.org/Function_Reference/add_editor_style)_ - WordPress Codex article on setting up an `editor-style.css` stylesheet

### themes/starter-theme/
- WordPress starter theme originally created while taking [Zoe Rooney](http://zoerooney.com)'s  [Neatly Polished](https://neatlypolished.com) WordPress development class

### plugins/ 

Useful plugins that I use while developing a new WordPress project.

1. Admin Post Navigation
- Codepress Admin Columns
- Custom Post Types UI
- Regenerate Thumbnails
- RICG Responsive Images
- Theme Check
- Unsplash Stock Photo Library
- Velvet Blue Update URLs
- What the File
- WordPress Importer
- WordPress SEO
- WP Accessibility

### Project Setup
- Gulp is setup for uglifying JavaScript and compiling SASS
- Download the repository and type `npm install` (or `sudo npm install`) to install the necessary Gulp packages
- Want to change the name to reflect your project? Do a search and replace in your editor for:
    - `starter-theme`
    - `Starter_Theme`


More info coming soon! - <em>May 11, 2015</em>