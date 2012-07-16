# Skinning in Nova 3

Since the release of SMS 2, skinning has remained relatively unchanged. SMS and Nova could be transformed in to just about anything a skin developer wanted with some patience and the right massaging of CSS rules and HTML markup. Given the low barrier to entry for languages like HTML and CSS, skinning could be done by just about anyone who took the time to learn the tools. That same philosophy remains in Nova 3, but we've turned some of the concepts on their head to make it easier to make simple modifications while at the same time giving skin developers even more control over the skins they create.

In SMS and Nova (to date), skinning relied on everything being in one place. While this made things easier from a development standpoint, it handicapped skin developers (and Anodyne too ironically). Skin developers were forced to duplicate an entire skin, even if they were only making minor modifications to the skin, and wade through huge amounts of CSS they didn't need (or didn't understand). For Anodyne, we found our hands tied behind our backs. If we wanted to make changes to existing styles, we either had to hard-code them in to the pages or force site admins to make all sorts of changes to every skin they had installed. When we sat down to build Nova 3, skinning was front and center as one of the things we wanted to address. What came out of it was a new skinning system that makes minor modifications easier and ensures that changes to the core styles are painless and don't require tons of changes by site admins.

## A New Philosophy

Instead of forcing skin developers to duplicate entire skins, now, minor modifications only require a directory, a QuickInstall file, and a single stylesheet. (You have the option of including a lot more, but at its most basic level, that's all you need.)

One of the greatest strengths of CSS is its cascading nature and we're putting that to good use in Nova 3 by having skins change core styles _after_ they've been declared. That means that if the Nova core sets link colors to blue, changing link colors to red is as simple as doing something like `a { color: red; }` in your stylesheet. For simple modification, stylesheets will actually be incredibly small. For larger changes, skin developers will likely have to leverage tools like Firebug to help them see which styles they need to change (more on that piece later).

## So How Does It Work?

At the highest level, Nova builds the structure and template files (though they can be overriden in a skin) and pulls in a base stylesheet. That stylesheet, stored in the Nova core, is the default look and feel of Nova; everything extends from that. The trick, however, is some logic to make sure Nova is pulling the right pieces in. By default, Nova will pull in a `style.css` file from the core __unless__ it finds a `style.css` file in your own skin. At that point, Nova skips the base file and uses your own.

<p class="alert">We don't recommend doing that as that would leave you a good deal of work to do with each update since styles could change, be removed, or be added.</p>

The other option (and the recommended option) is to use a `custom.css` stylesheet. During the loading of the structure file, Nova looks for the existence of a `custom.css` file in the skin. If it finds it, it'll pull it in after the base stylesheet, meaning anything in `custom.css` will override what's in the base stylesheet. It also means that skin developers don't have to be worried about some of the structural CSS properties, only the things they want to change.

This may seem like a monstrous change, but in reality, things will be a lot simpler for making those minor modifications that most people do.

## A Couple Simple Examples

Let's say we want to take the default Nova 3 skin and make a few tweaks. How exactly would we do that?

### Changing Link Colors

<pre>a { color: #c00; }
a:hover { color: #f00; }</pre>

If you put the above into a `custom.css` stylesheet and activated that skin, everything would look the same except for link colors which would be red instead of blue.

### Changing the Header Background Image

<pre>header { background: transparent url(images/new-header.png) no-repeat top left; }</pre>

Voila! Now your skin uses a new image (which you've placed in an `images` directory in your skin next to your `custom.css` file) in the header.

### Adding a Background Image to the Main Content

<pre>section { background: transparent url(images/content-bg.png) no-repeat top center; }</pre>

Bam! After tossing that image into your `images` folder in the skin, you'd see a minor change to the skin, and all with a single line of code.

In the subsequent sections, we'll go in to more detail about the anatomy of a skin, overriding all sorts of things, and more advanced examples of how you'd do all sorts of different things with Nova 3 skins. There may be a learning curve involved, but once you've learned it, we think you'll love Nova's new way of skinning.