To Install this theme 
Step 1. - Create a folder called "generated-card-images"
inside the image directory of this theme and allow the webserver, most commonly apache have the permission to write to the folder
so you want to end up with a folder, Also to note your server should have the the GD library installed. It it installed on most servers. 

wp-content/phylomon/img/generated-card-images

Step 2. - Create a "Cards" category 
go to your yoursite.com/wp-admin/categories.php

All your post that have the cards catgeory will get turned into cards. 

Step 3. - Create a cards page 

Create a new page. 
Called it what ever you want but you need to select the cards template 

Step 4. - Create a graphics page

The current graphics page uses shortcodes. 
No special template is needed. 

the shortcode attributes expalined
feed - the feed of the flickr group you want to display, could also be user feed
example:
feed="http://api.flickr.com/services/feeds/photos_public.gne?id=44033358@N02&amp;lang=en-us&amp;format=atom" 

num - number of pictures you want to display, my suggestion is 5 or 10 lets not go over board here 
example:
num="5"

type - what kind of view do you want 
type="cards" produces the card type view 
leaving it blank produces squares of pictures. 

url - the url you want the more link to point to probably the flickr group
example: 
url="http://www.flickr.com/photos/phylomon/"

title -  the heading text
example:
title="Card Queue"

here is everything put together:
[flickr-cards feed="http://api.flickr.com/services/feeds/photos_public.gne?id=44033358@N02&amp;lang=en-us&amp;format=atom" num="5" type="cards" url="http://www.flickr.com/photos/phylomon/" title="Card Queue"]

----------------------------------------------
here the text used on the testing site 
[flickr-cards feed="http://api.flickr.com/services/feeds/photos_public.gne?id=44033358@N02&amp;lang=en-us&amp;format=atom" num="5" type="cards" url="http://www.flickr.com/photos/phylomon/" title="Card Queue"]

Lorem ipsum

[flickr-cards feed="http://api.flickr.com/services/feeds/groups_pool.gne?id=1245643@N20&amp;lang=en-us&amp;format=atom" url="http://www.flickr.com/groups/phylomon/" num="10" title="Latest Graphics"]

[flickr-cards title="Latest Photo" url="http://www.flickr.com/groups/1293102@N24/" feed="http://api.flickr.com/services/feeds/groups_pool.gne?id=1293102@N24&amp;lang=en-us&amp;format=atom" num="5" ]

[flickr-cards title="Latest School" url="http://www.flickr.com/groups/1300145@N20/" feed="http://api.flickr.com/services/feeds/groups_pool.gne?id=1300145@N20&amp;lang=en-us&amp;format=atom" num="5" ]
----------------------------------------------

back to steps now
Step 5. - You might want to change the order of 
what your home page is by going to 
/wp-admin/options-reading.php
and change the the Front Page display settings

Step 6. - Update the permalinks 
go to /wp-admin/options-permalink.php
make you sure selected anything but default
and save the changes.


Step 7. - Get the WP-PageNavi
go to and follow the installation options
http://wordpress.org/extend/plugins/wp-pagenavi/

Some settings to change once the plugin is enabled
make sure that is not checked off "Use pagenavi.css?"

Step 8. Set up the Add to Card Cart 
Install  the Section widget 
http://wordpress.org/extend/plugins/section-widget/

Add the [cards-cart] shortcode. 
Make sure that you select which part of the website you want the Cards cart to appear.


Add the Cart 
Enjoy a coffee :) 

