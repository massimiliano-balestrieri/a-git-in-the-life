<?php
/*
*  KOIVI PNG Alpha IMG Tag Replacer for PHP (C) 2004 Justin Koivisto
*  Version 2.0.12
*  Last Modified: 12/30/2005
*  
*  This library is free software; you can redistribute it and/or modify it
*  under the terms of the GNU Lesser General Public License as published by
*  the Free Software Foundation; either version 2.1 of the License, or (at
*  your option) any later version.
*  
*  This library is distributed in the hope that it will be useful, but
*  WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
*  or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public
*  License for more details.
*  
*  You should have received a copy of the GNU Lesser General Public License
*  along with this library; if not, write to the Free Software Foundation,
*  Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*  
*  Full license agreement notice can be found in the LICENSE file contained
*  within this distribution package.
*  
*  Justin Koivisto
*  justin.koivisto@gmail.com
*  http://www.koivi.com
*/

    include_once dirname(__FILE__).'/replacePngTags.php';
    echo '<?xml version="1.0" encoding="iso-8859-1"?>'; // so those with short_tags = On don't complain about the parse error
?>
<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title>PNG-24 Alpha Transparency With Microsoft Internet Explorer 5.5 or better (MSIE 5.5+)</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <meta name="description" content="A PHP solution to fixing the display of PNG-24 images with alpha transparency in Microsoft Internet Explorer." />
  <meta name="keywords" content="php png-24 alpha transparency microsoft internet explorer msie fix transparent png" />
  <style type="text/css">
   @import url(http://koivi.com/styles.css);
  </style>
 
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-207722-1";
urchinTracker();
</script>
 </head>


 <body>
  <div id="container">
   <div id="intro">
    <h1>PNG-24 Alpha Transparency with MSIE</h1>
    <p>PNG-24 images with alpha transparency display with a solid gray color as the background by default in Windows versions of Microsoft Internet Explorer. This is because MSIE does not natively support the multiple levels of transparency. The browser does however support the alpha-channel transparency through proprietary filters. For more information on the PNG image format, be sure to check out <a href="http://www.webcolors.freeserve.co.uk/png/" title="http://www.webcolors.freeserve.co.uk/png/">this site</a>.</p>
    
    <!--[if lt IE 7]>
     <h1>Broken Site Design</h1>
     <p>Yes, I know that this page does not render the same as the others on my site, so there is no reason to notify me. Please read the paragraph below if you want to know why you are seeing this message.</p>
    <![endif]-->
    
    <h1>Alternative That Eases Site Design</h1>
    <p>Sure, this takes care of the whole PNG transparency issue, however, there are a lot more CSS-type bugs in Internet Explorer that makes web design harder on web developers.</p>
    <p>I ran into a solution when putting this site's new design together with CSS. By using <a href="http://dean.edwards.name/IE7/">Dean Edward's IE7</a>, you can fix up quite a few of the MSIE quirks for CSS. As of version 0.7, it is an all-javascript solution, so it may not be exactly what you are looking for, but you may want to at least check it out and see what it can do!</p>
    <p>The IE7 solution does conflict with my PHP solution to the Internet Explorer alpha-transparency bug. The defaults for IE7 actually cause PNG images fixed with this method not to render at all.</p>
   </div>

   
   <div>
    <h1>Normal display of PNG Alpha Transparency with MSIE</h1>
    <p>
     <img src="test.png" width="247" height="216" alt="PNG-24 image with transparency" title="PNG-24 image with transparency" style="float: left; margin: 15px;" />
     This PNG-24 image with alpha transparency is displayed without any filters or special CSS styles applied, it is simply a normal HTML <code>IMG</code> tag. If you are using Microsoft Internet Explorer (MSIE) on a Windows platform, you will notice that the image has a gray background, showing you the boundaries of the image clearly.
    </p>

    <h2>Frustrated Web Designers and Developers</h2>
    <p>This is a common problem faced by many web designers and web developers. As web technologies progress, web developers want to take advantage of them to make it easier to implement design elements that would otherwise be quite complex - or impossible. However, if popular web browsers don't have these technologies implemented correctly, designers and developers become frustrated when they aren't able to use the best solution (or only solution in many cases) for their problem.</p>
   </div>

   <div>
    <h1>Solutions</h1>
    <p>Unfortunately, in order for these images to display as intended, some kind of extra code must be applied to the HTML that would otherwise be used to present the images. There are a variety of ways to add the code for these filters that MSIE needs to display the multiple degrees of transparency in the PNG-24 images.</p>
    <p>The first method that a developer will likely try is to include the code statically into the HTML code. When doing so, you may have an HTML <code>IMG</code> tag that looks like the following:</p>
    <p class="example">&lt;img src="test.png" width="247" height="216" style="filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='test.png', sizingMethod='scale');" alt=""&gt;</p>
    <p>This doesn't work. MSIE will do the transform, but still places the unfiltered image on top of it. If the developer then changes the IMG SRC to spacer.png, it works in IE only.</p>
    <p>The next step a developer will likely take is to go to their favorite search engine and search for &quot;png transparency ie&quot; in hopes of finding a quick fix. (Afterall, if you are a developer, that is likely how you found this page.) The next types of solutions you may find use JavaScript that do an image substitution, but if the user has JavaScript disabled, these solutions wouldn't do help any. There are also solutions that exploit a bug (or lack of support) in MSIE's CSS implementations to correctly display these PNG images.</p>
    <p>Some of these methods may also have undesireable results in other popular web browsers. By creating a PHP function that replaces the necessary parts of an image tag and uses image substitution, MSIE 5.5+ will display the PNG-24 image's alpha transparency as expected - without effecting the display for other browsers.</p>
   </div>
   
   <div>
    <h1>Fixed display of PNG Alpha Transparency</h1>
    <p>
     <?php echo replacePngTags('<img src="test.png" alt="PNG-24 image with transparency" title="PNG-24 image with transparency" style="float: left; margin: 15px;" />'),"\n"; ?>
     This PNG-24 image with alpha transparency (the same image as used at the top of this page) is displayed by using the PHP function mentioned above. If you are using Microsoft Internet Explorer (MSIE) on a Windows platform, you will notice that the gray background shown in the first instance of this image is now gone.
    </p>

    <h2>Checking PNG Transparency</h2>
    <p>By keeping the above paragraph short, and applying a background color to the title of this paragraph, you should now be able to see a colored bar disappear behind the image and its drop shadow. Notice that the shadow for the image looks as if it has been placed on top of the color bar. In order to have this effect with a GIF or PNG-8 image with binary transparency, you'd have to make the image with the color bar in its background, or a ghosted edge would be visible.</p>
    <p>As you can start to imagine, the ability to have multiple levels of transparency in an image allows for nearly endless possibilities for effects on the web. For those of you who have used graphics programs like Photoshop, Paint Shop Pro, and The GIMP, imagine having a way to place a graphic layer on top of another element (using CSS positioning) and then adjusting the transparency of that layer (using PNG-24 alpha-channel transparency).</p>
   </div>
   
   <div>
    <h1>Methodology</h1>
    <p>The method used on this page is the same that is used for many JavaScript-based solutions to PNG-24 transparency for MSIE. The PHP script searches for <code>IMG</code> tags in the HTML that have &quot;.png&quot; (case-insensitive) in the <code>SRC</code> attribute, replaces it with a 1px x 1px PNG-8 image containing binary transparency (which MSIE <i>does</i> support) and adds the necessary CSS style statements for MSIE 5.5+ to render the transparency as desired. However, since this is a server-side solution, you do not have to rely on the user's browser settings or capeabilities.</p>
    <p>In addition to scanning <code>IMG</code> tags, this function will also scan <code>INPUT</code> tags and search for background images defined with <code>background-image: url(image.png);</code> or <code>background-image: url('image.png');</code>. With background images, there is no need to use an additional transparent image as a placeholder.</p>
   </div>

   <div>
    <h1>Implementation</h1>
    <p>For this function to work, you will need to be able to capture the web page's browser output into a PHP variable. To accomplish this, simply follow the steps below, and everything should work as expected.</p>
    <ol>
     <li>Save the function into a file named "replacePngTags.php"</li>
     <li>
      At the top of the files that you want to use this function with, paste the following code:
      <pre>&lt;?php ob_start(); ?&gt;</pre>
     </li>
     <li>Now, at the bottom of this file, paste the following lines of code:
      <pre>&lt;?php
    include_once 'replacePngTags.php';
    echo replacePngTags(ob_get_clean());
?&gt;</pre>
      You should also realize that if the replacePngTags.php is not found within your server's include path for PHP, you will have to adjust the include line.
     </li>
     <li>If the file in question is not a file that is already being parsed as PHP, you will have to make an adjustment. For this code to work, the web server needs to see this as a PHP file, or the code will simply display on the page. To do this, you have a couple options:
      <ul>
       <li>Change the file's extension from .html (or other) to .php or something that your web server will parse. This will depend on your server's configuration.</li>
       <li>Another option is to tell the server to parse the file extension as PHP. There are drawbacks to this, but I won't get into that here. For the <a href="http://httpd.apache.org/">Apache Web Server</a>, this can be accomplished by adding a file called ".htaccess" in the directory with the following line in it:
        <pre>AddType application/x-httpd-php .html</pre>
        Not all Apache web servers will have the option of using .htaccess files. You may need to contact your hosting provider to determine this. For other web server software, you are on your own (I only use Apache), so if you aren't running the server yourself, contact your provider for options.
       </li>
      </ul>
     </li>
    </ol>
   </div>

   <div>
    <h1>Other Problems</h1>
    <ul>
     <li><p>I have had a number of reports of odd behavior regarding PNG alpha transparencies in MSIE. The most often reported problem goes something like:</p>
      <blockquote><p>I have a PNG with alpha transparentcy set as the background of a table cell (<code>&lt;td&gt;</code>) that has some HTML content displayed in it. When there is a hyperlink (<code>&lt;a href="something.html"&gt;click&lt;/a&gt;</code>) on top of the PNG, the link is not clickable.</p></blockquote>
      <p>I have personally seen this problem as well, but I have not been able to find a fix for it. My take on it is that when MSIE (before 7) applies the alpha filter, it puts the image in the same way as a browser plug-in would. This means that the image now has something equivaltent to the highest z-index in the page in effect, disabling any kind of click events for elements below. This probably isn't quite what happens as I doubt that IE would make a knock-out of the image to display, but it is the same effect.</p>
      <p><b>UPDATE 8/5/2005:</b> I would like to give a big thanks to <b>Holger Rüprich of <a href="http://www.indesigns.de/">www.indesigns.de</a></b>. Holger was kind enough to submit a fix for this links not being clickable. All you need to do is simply add a <code>position: relative;</code> to the style of the link that appears on the background image. Now, that may be a bit of a task to do this for all your links, but if you do a simply little <code>*a{position:relative;}</code> in your style sheet, all should be good. I haven't tested this in complex pages at all to see what happens when you are using a lot of CSS2 layout, but it works without implecations for simple layouts.</p>
     </li>
    </ul>
    <p>There have been other similar problems reported as well, but I don't remember those off-hand. I've just been chalking it up as another bug in MSIE rendering engine, but I really can't be sure.</p>
    <p>If you find a fix for any of the items above (I will post them as they come in), please shoot me an <a href="mailto:justin.koivisto@gmail.com?subject=PNG%20MSIE%20Render%20Fix">e-mail</a> and I will be sure to get it on this site (and of course, give you credit for it).</p>
   </div>

   <div>
    <h1>Source Code</h1>
    <p>To see how this is working, you can view the source to the function below, or download the <a href="/ie-png-transparency.zip">Full Source Download</a> of this page to see how it was all done. <a href="mailto:justin.koivisto@gmail.com?subject=PNG-24 Transparency Code">Comments or suggestions welcome</a>.</p>
    <div class="example"><?php highlight_file(dirname(__FILE__).'/replacePngTags.php'); ?></div>
   </div>

   <div>
    <h1>Search Engine Concerns</h1>
    <p>Somebody had emailed me about how using this code may effect search engine rankings on Google. The had referred to <a href="http://www.professional-website-promotion-ranking.com/newsletter.htm">this</a> article. The part worth quoting from that article follows:</p>
    <blockquote>
     <p>Obviously not all hidden text is "bad." For example, meta tags are hidden, but you'll not be penalized for using them. However, Google does try to penalize pages that use certain other techniques intended to hide text or hyperlinks from the end user while making them visible to the search engine. One common tactic to hide a link is to use a tiny, 1-pixel image that contains a link. Considering that Google already has the technology to index image content, it is a fair bet that you will be penalized for using such a common technique, or will be penalized in the very near future.</p>
     <p>Rather than hiding links to pages, consider creating a site map page that contains links to all your other optimized pages. You'll need to link to this page from your home page for Google to consider it as a legitimate sub-page. In my opinion, you should avoid using any images for this link that are smaller than what would be considered a small button on a Web site. So long as the image is of sufficient size and does not consist solely of transparent pixels, Google would have great difficulty penalizing it in any kind of automated process.</p>
     <p>Technically, you could still make any image, or a portion of a larger image on your site serve as a link to your site map page. Therefore, a clever Webmaster could still effectively conceal one or more links from the average human visitor without being caught by Google's new spam checks. However, you should be very careful not to simply create GIF images that contain nothing but transparent pixels. If you do, you will surely be red-flagged for spamming. Even if your site is still listed today, now is the time to make sure it is "clean" before Google completes all of its new spam tests.</p>
     <p>Some of the clever ways to hide keyword TEXT on a page will likely be targeted as well, so bear this in mind! The best thing to do is to design your pages in such a way that hiding links and keywords becomes unnecessary.</p>
    </blockquote>
    <p>Just to clear up some confusion, this method of displaying PNG alpha transparencies should have <b>no effect</b> on Google's SERPS. Why? Simply because Google's spider (googlebot) doesn't identify itself as a Window's version of Microsoft Internet Explorer 5.5+. This method only changes the code for those browsers, not for others. To see this, view this page with IE and view source. Then open up Mozilla (or other browser) and compare the source for that page against the one for IE.</p>
   </div>

   <div>
    <h1>Updates</h1>
    <ul>
     <li><p><b>UPDATE: (12/30/2005):</b> Fixed the regular expression used to detect MSIE to ignore IE7 or greater.</p></li>
     <li><p><b>UPDATE: (8/4/2005):</b> There was a missing comma in the filter that caused MSIE 5.5 (6 was ok) to not render some background images. Thanks to Pierre Lemieux for reporting this!</p></li>
     <li><p><b>UPDATE: (8/1/2005):</b> Made this function NOT replace tags that are in within <code>&lt;script&gt;</code> code blocks. If you want those to be replaced as well, send a boolean true value as the fourth parameter to the function call. Replacing <code>IMG</code> tags in a JavaScript string may cause errors. That is why this option has been added.</p></li>
     <li><p><b>UPDATE: (6/28/2005):</b> Added another case to handling when width and height are not defined. I don't think it will work in all cases, but this should cover the most common ones.</p></li>
     <li><p><b>UPDATE: (6/23/2005):</b> Bug fixes regarding the optional single quotes when used with the background-image style property and when width or height properties are not set for the image.</p></li>
     <li><p><b>UPDATE: (2/25/2005):</b> Bug fix regarding the optional single quotes when used with the background-image style property.</p></li>
     <li><p><b>UPDATE: (2/14/2005 & 2/15/2005):</b> More bug fixes regarding the path of the images. Thanks to Alex Lobas for the report.</p></li>
     <li><p><b>UPDATE: (2/10/2005):</b> The single quotes when using the <code>background-image</code> style are now optional since the CSS specification doesn't require them.</p></li>
     <li><p><b>UPDATE: (2/3/2005):</b> Another bug was reported and fixed dealing with the $img_path variable. Thanks to Andrew Muraco for reporting the bug.</p></li>
     <li><p><b>UPDATE: (2/2/2005):</b> A bug was fixed that caused the script to only work with one image from a page. Thanks to Nic Sievers and Eric Lee for reporting it and hinting to a fix.</p></li>
     <li><p><b>UPDATE: (12/13/2004):</b> Bugs dealing with using relative URIs in the image tag and using PHP to get the image's width and height were fixed.</p></li>
     <li><p><b>UPDATE: (8/04/2004):</b> OK, you no longer have to worry about images that don't define the height and width not being replaced. The script will now also use a call to <a href="http://www.php.net/getimagesize" title="PHP Manual: getimagesize">getimagesize</a> to figure out the width and height - if they weren't provided in the tag. This allows you to still force an image to display smaller than its actual size.</p></li>
     <li><p><b>UPDATE: (7/30/2004):</b> It was just brought to my attention that this method was being fired on MSIE 5.0 as well. Turns out that 5.5 is the first version that supports the filter used. Therefore, the regex has been updated to look for version 5.5 or greater.</p></li>
     <li><p><b>UPDATE: (7/21/2004):</b> I have had requests to change the reziseMethod to &quot;image&quot; from &quot;scale&quot;. This prevents the image from resizing itself to what the style defines. However, doing so also prevents background images from stretching or shrinking. Because both of these behaviors may be beneficial, I have added a 3rd optional parameter to the function. $sizeMeth is a string defining the sizingMethod, allowing all possible values for the Microsoft.AlphaImageLoader filter. Default is &quot;scale&quot; so that no previous implementations are effected.</p></li>
     <li><p><b>UPDATE: (7/21/2004):</b> I have been receiving a lot of questions about external style sheet support and style tag definitions lately. I decided to provide you with answers to these questions here:</p>
      <p>The method and code presented on this page <b>does not</b> work with external style sheets or style definitions in the HEAD of the document. In order to do that, the script would have to:</p>
      <ol>
       <li>read in the entire file</li>
       <li>parse for one of many ways to import style sheets and/or ways to define styles in the document head</li>
       <li>replace the found styles with the &quot;fixed&quot; styles for MSIE</li>
       <li>remove references to imported, linked, etc. style sheets, and insert the code from them into the output with the modifications</li>
       <li>re-parse the output for the png pieces to replace</li>
      </ol>
      <p>OK, that would be a lot of work. I guess I just don't have the time to do that right now. Also, that would take some of the flexibility way from the script. For instance, on this page, I only use it to replace one PNG. Parsing the file for styles and external sheets wouldn't allow for that anymore without additional modification to either the code or the HTML.</p>
     </li>
     <li><p><b>UPDATE (6/16/2004):</b> OK, I got around to partially fixing the situation reported in the 1/28/2004 update. If an IMG tag is missing either the WIDTH or HEIGHT attribute and width and height are not set in using the STYLE attribute, (or the width was not set first), the image will appear with the gray background instead of disappearing.</p></li>
     <li><p><b>UPDATE (5/11/2004):</b> Fixed a small bug regarding the new second parameter and undefined variables.</p></li>
     <li><p><b>UPDATE (5/5/2004):</b> A second (optional) parameter has now been added. This parameter allows you to pass the path to the directory that contains the spacer.png image relative to the DOCUMENT_ROOT of the site. Use this parameter if you have multiple directories where images are stored. That way, you will only need one spacer.png file.</p></li>
     <li><p><b>UPDATE (4/29/2004):</b> Function was updated a little to compensate for the oversight I had made with the $modified variable where it generated warnings in certain cases.</p>
         <p>Another modification is that the function now looks for spacer.png instead of spacer.gif. Since MSIE <i>does</i> support <u>binary</u> transparency in PNG images, I decided to go this route to rid myself of a single GIF image in my web tree.</p></li>
     <li><p><b>UPDATE (4/14/2004):</b> Oops... I had made a slight oversight on the last update. The bug is now fixed. Thanks to Adam for bringing it to my attention.</p></li>
     <li><p><b>UPDATE (4/13/2004):</b> New feature request has been implemented. The code will now also support percentages in the image height and width. Also, the modified tag now defines the width and height only in the style without duplication.</p></li>
     <li><p><b>UPDATE (3/16/2004):</b> It never fails... after using the function for a few more days, I found a logic error. I have now corrected the corrupted lines of code.</p></li>
     <li><p><b>UPDATE (3/11/2004):</b> While working on a new project, I had to use single quotes in my image tags because the tags were inside ini files that were being parsed with PHP's <b>parse_ini_file()</b> function. Therefore, I had to update the code to look for either " or ' and use them accordingly in the replacement code.</p></li>
     <li><p><b>UPDATE (1/28/2004):</b> It was brought to my attention that if you do not have the width or height in an <code>IMG</code> tag for a PNG image, the image will not show up when parsed through this function. I may or may not change this behavior, but it is something that should be mentioned on this web page. Again, if you want to use this function, be sure that you have the WIDTH and HEIGHT attributes (in that order) in the <code>IMG</code> or INPUT tag or that you have width and height defined in the STYLE attribute.</p></li>
    </ul>
   </div>
  <script type="text/javascript"><!--
google_ad_client = "pub-6879264339756189";
google_alternate_ad_url = "http://koivi.com/google_adsense_script.html";
google_ad_width = 728;
google_ad_height = 90;
google_ad_format = "728x90_as";
google_ad_type = "text_image";
google_ad_channel ="7653137181";
google_color_border = "6E6057";
google_color_bg = "DFE0D0";
google_color_link = "313040";
google_color_url = "0000CC";
google_color_text = "000000";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
  </div>

<?php
// this is only the menu column that you see on the left side of my site, don't worry about the file not being in the distribution package.
include_once 'site_menu.php';
?>

 </body>
</html>
