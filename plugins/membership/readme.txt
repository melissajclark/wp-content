=== Membership ===
Contributors: WPMUDEV
Tags: Membership, Subscription, Registration, Content Protection, Control Access, Paid Membership, Pay Wall, Paying Users, Restrict Content, WordPress Membership, Multisite Membership, WPMU DEV
Requires at least: 3.7
Tested up to: 4.0
Stable tag: 3.4.4.1

Membership transforms your WordPress website into a fully functional membership site.

== Description ==

[youtube https://www.youtube.com/watch?v=9PgEJ8Derm4]

Membership transforms your WordPress website into a fully functional membership site. Provide access to downloads, online content, videos, forums, support and more through flexible membership levels and options.
Simple to use, flexible - this plugin will meet all of your membership site needs. Want to create a site like GigaOm, Izzy Video, PSD Tuts? Now you can do it, easy!

= You can use Membership lite to create... =
* A WordPress membership site, offering resources, forums, downloads, videos, support and more... with three different levels of membership and complete customizations.
* Multiple membership sites on a WordPress MultiSite install - so any user of your site can have their own membership site.

= Membership Pro =
Membership lite is a fully functional but limited version of our <a href='http://premium.wpmudev.org/project/membership'>full Membership plugin</a>.
This lite version supports a maximum of three membership levels and three subscription levels, as well as a basic set of rules to get you started. This is enough for most basic membership sites.

Our full version includes many more features:

* **Unlimited** membership levels!
* **Unlimited** subscription levels!
* **BuddyPress rules** - limit and protect access to groups, group creation, pages, blogs, private messageing
* **Administration area rules** - control blog creation (limit number per level), dashboard widgets, menus and sub-menus, available plugins.

<a href='http://premium.wpmudev.org/project/membership/'>**Upgrade to the full version now &raquo;**</a>

= How does it work... well, it's really easy. =

Simply follow the instructions in the installation and configuration guide

You'll then be able to create Membership 'Levels' which can access different types of content, including 'free' (i.e users just visiting the site) and/or paid levels.

You can control access to:

* Downloads
* Categories
* Pages
* Posts
* Comments
* 'More' tags
* Galleries
* And **any content or functionality** (like forums!), via multiple different shortcodes

And you can create three different levels of subscriptions. For example you could:

* Offer free memberships that turn into paid subscriptions after x days
* Finite or indefinite subscriptions
* Serial renewing subscriptions
* Subscriptions that renew every 5, 10, 30, 90 etc. days
* And plenty more...

All this, and more. Membership is as much a **framework** as anything else.

Using our powerful but simple APIs you can easily add different gateways and rules - any half decent WordPress developer should be able to do exactly that!

For example, adding gateways is easy - and we'll be adding plenty more - all you need to do is create a gateway along the lines of one that we supply and you'll be good to go.

= Building a Membership Site =
The WPMU DEV Membership plugin makes it  easy to create and manage a membership site for both free and paid subscribers.

Whilst the plugin handles a lot of the work, you will need to spend some time thinking through the structure of your site and how you want to set-up and categorize your content before installing and activating the Membership plugin.

= What is a membership site =
A membership site can take many guises, from Gigaom Pro which protects long articles and research, through to Izzy video which protects individual videos.

In all cases though, a membership site contains a minimum of two levels of content:

*	**Free (or teaser) content**, which is accessible to everyone and is used to entice potential new members into subscribing (and also help with SEO)
*	**Members only content**, which is only accessible to those who have an active (paid or free) subscription to the site.

We have put together an in-depth <a href='http://premium.wpmudev.org/project/membership/installation/'>instructions guide</a> to help you through using standard WordPress categories to mark posts / content as being accessible to either free users or members only. Then we go into some of the more advanced features that allow you to protect individual uploads and distinct sections of a posts content.

== Installation ==

**To install**

1.  Download the plugin file
2.  Unzip the file into a folder on your hard drive

**Standard WP/WPMS (for blog by blog access)**

1.	Upload the membership folder and all it contents to /wp-content/plugins folder on your site
2.	The path to the main plugin file is wp-content/plugins/membership/membership.php

**To activate it on a blog by blog basis**

1.  Log into the blog dashboard that you want to set up membership on.
2.  Go to Plugins > Installed
3.  Click on Activate under Membership lite system

**Enabling your membership plugin**
By default, the membership plugin is disabled when first installed and when you go your Membership Dashboard you will see it says Disabled.

You need to leave this as disabled until you have at least:

1.	Set up your categories
2.	Created and activated a basic level to use for strangers
3.	Assigned the stranger level in Membership > Edit Options panel

If you are running a live site and enable the plugin in your Membership dashboard all content will be automatically protected until you have set up the stranger level.

**The Admin user**
The membership system can initially be administered by the admin user and is always disabled on the front end of your site for this user, you can add other users to the membership administration group by editing them in WordPress and ticking the Membership admin box at the bottom of the User Edit page.

= More Instructions on setup =
More instructions and screenshots on how to configure the Membership plugin can be found on the <a href='http://premium.wpmudev.org/project/membership/installation/'>WPMU DEV site</a>.

= Need help getting started? =
We provide comprehensive and guaranteed support on the <a href='http://premium.wpmudev.org/forums/tags/membership'>WPMU DEV forums</a> and <a href='http://premium.wpmudev.org/live-support/'>live chat</a>.

== Frequently Asked Questions ==

= How easy is it to set up? =
We have an indepth step by step guide to getting the plugin initially setup and configured <a href='http://premium.wpmudev.org/project/membership/installation/'>here</a>.

= Get Support =
We provide comprehensive and guaranteed support on the <a href='http://premium.wpmudev.org/forums/tags/membership'>WPMU DEV forums</a> and <a href='http://premium.wpmudev.org/live-support/'>live chat</a> only.

== Screenshots ==

1. The Membership admin menu
2. Membership dashboard and news stream
3. Attractive signup statistics
4. Bulk administer Membership Levels
5. Extendable content rules
6. Level edit screen makes it easy to protect content
7. Simply drag content rules to the relevant area to allow or prevent access
8. Define the subscription path a user passes through during their subscription
9. Drag and drop to add levels to a subscription or re-arrange the levels order.
10.	Allow paid or free subscriptions
11. Highly configurable with **a lot** of options and hooks / filters available.

== Changelog ==

= 2.0.7 =
* WP3.3 Styling Compatibility

= 2.0.6 =
* WP3.2 Compatibility

= 2.0.2 =
* Bug fixes

= 2.0 =
* Removes need for set admin usernames - now detects who activated plugin
* Added persistent configuration capability
* Added redirecting No Access page
* Added URL Groups settings and rules
* Added quick start steps
* Added Communications capability - automessage for membership
* Added Pings system
* Added integration with WP roles
* Added Account page setting and shortcode
* Added renewal and upgrade functionality and shortcode
* Added single payment paypal gateway
* Added upgrade and cancel capability to paypal gateways
* Fixed filtering problems with members admin page
* Fixed general bugs and other issues
* Added more hooks and filters for customisation
* Added define checks to completely override signup / subscription / renewal and account pages
* Added filters to override the register and account links for standard wordpress to now direct to membership pages.

= 1.0.2 =
* Allowed membership admin menu to be visible for all admin level users

= 1.0 =
* Initial release.