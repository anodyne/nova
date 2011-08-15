# Skinning Nova 3

Skinning in Nova has always operated off the assumption of everything a skin needs being present in one place. Skins were designed to be independent objects that contained almost every piece of presentation code. Unfortunately, this model presented problems after the 1.0 release since any new styles would have to applied to  every skin deployed to a Nova site. This process was tedious and could get confusing with larger updates. To alleviate these issues, Nova 3 employs a radically different skinning system that relies on everything being stored in one place and the skin overriding the defaults with their own values. So why such a massive change?

As we looked at what people were doing with skins, we realized the changes were pretty minor ... new colors, new images, new backgrounds and other pretty trivial things. Previously though, no matter how minor, you'd still have to copy an entire skin, find what you wanted to change and then deploy it. If you just wanted to change the color of links throughout the system, this process was serious overkill and left a lot of people frustrated with how difficult little changes were to skins. Those people had a legitimate gripe. While there will be a learning curve to skinning in Nova 3, once you understand how to do it, you'll find it faster and easier to make changes to your skin without all the headaches.

Essentially, Nova 3 relies on loading a base stylesheet (aptly named style.css) before any other stylesheets. After that, Nova checks for the existence of your custom styles (again, aptly named custom.css). If it finds a custom.css stylesheet, it'll load it after the base stylesheet. For those new to CSS, the advantage here is that any properties declared in the custom.css stylesheet will be used instead of those same items in the base stylesheet. That means in our example of changing a link color, a single line of code in a single stylesheet would be enough to make our change instead of copying a skin and finding the place where we need to make the change.

In our base stylesheet, declaring the link styles looks like this:

<pre>a {
	outline: 0;
	color: #1e5799;
}
a:hover { color: #666; }</pre>

In our skin's custom.css file, making that link color red would look like this:

<pre>a { color: #c00; }</pre>

Done.