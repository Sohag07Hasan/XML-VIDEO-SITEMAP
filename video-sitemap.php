<?php
/*
Plugin Name: Google XML Sitemap for Videos
Plugin URI: http://www.labnol.org/software/xml-video-sitemaps-for-google/14085/
Description: This plugin will generate a XML Video Sitemap for your WordPress blog. Open the <a href="tools.php?page=video-sitemap-generate-page">settings page</a> to create your video sitemap.
Author: Amit Agarwal
Version: 2.5.1
Author URI: http://www.labnol.org/
*/

add_action ('admin_menu', 'video_sitemap_generate_page');

function video_sitemap_generate_page () {
    if (function_exists ('add_submenu_page'))
        add_submenu_page ('tools.php', __('Video Sitemap'), __('Video Sitemap'),
            'manage_options', 'video-sitemap-generate-page', 'video_sitemap_generate');
}

    /**
     * Checks if a file is writable and tries to make it if not.
     *
     * @since 3.05b
     * @access private
     * @author  VJTD3 <http://www.VJTD3.com>
     * @return bool true if writable
     */
    function IsVideoSitemapWritable($filename) {
        //can we write?
        if(!is_writable($filename)) {
            //no we can't.
            if(!@chmod($filename, 0666)) {
                $pathtofilename = dirname($filename);
                //Lets check if parent directory is writable.
                if(!is_writable($pathtofilename)) {
                    //it's not writeable too.
                    if(!@chmod($pathtoffilename, 0666)) {
                        //darn couldn't fix up parrent directory this hosting is foobar.
                        //Lets error because of the permissions problems.
                        return false;
                    }
                }
            }
        }
        //we can write, return 1/true/happy dance.
        return true;
    }


function video_sitemap_generate () {

    if ($_POST ['submit']) {
        $st = video_sitemap_loop ();
        if (!$st) {
echo '<br /><div class="error"><h2>Oops!</h2><p>Looks like none of your blog posts contain YouTube videos. Please publish a test post containing a YouTube video and regnerate the video sitemap.</p><p>If the issue remains unresolved, please post the error message in this <a target="_blank" href="http://wordpress.org/tags/xml-sitemaps-for-videos?forum_id=10#postform">WordPress forum</a>.</p></div>';    
exit();
}

?>

<div class="wrap">
<h2>XML Sitemap for Videos</h2>
<?php $sitemapurl = get_bloginfo('home') . "/sitemap-video.xml"; ?>
<p>The XML Sitemap was generated successfully. Please open the <a target="_blank" href="<?php echo $sitemapurl; ?>">Sitemap file</a> in your favorite web browser to confirm that there are no errors.</p>
<p>You can submit your Video XML Sitemap through <a href="http://www.google.com/webmasters/tools/" target="_blank">Webmaster Tools</a> or you can directly <a target="_blank" href="http://www.google.com/webmasters/sitemaps/ping?sitemap=<?php echo $sitemapurl; ?>">ping Google</a>.</p>
<h3>Stay Connected</h3>
<p><a href="https://twitter.com/labnol" class="twitter-follow-button" data-show-count="true" data-lang="en" >Follow @labnol</a></p>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fdigital.inspiration&amp;send=false&amp;layout=standard&amp;width=500&amp;show_faces=true&amp;action=recommend&amp;colorscheme=light&amp;font=arial&amp;height=80&amp;appId=197498283654348" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:500px; height:80px;" allowTransparency="true"></iframe>
<hr />
<p>Please email your suggestions to Amit Agarwal at amit@labnol.org. You can also connect with <a href="http://www.labnol.org/" target="_blank">Digital Inspiration</a> on <a href="http://twitter.com/labnol" target="_blank">Twitter</a>, <a href="http://www.youtube.com/labnol" target="_blank">YouTube</a> and <a href="http://www.facebook.com/digital.inspiration" target="_blank">Facebook</a>. </p>
<hr />
<?php } else { ?>
<div class="wrap">
  <h2>XML Sitemap for Videos</h2>
  <p>Sitemaps are a way to tell Google and other search engines about web pages, images and video content on your site that they may otherwise not discover. </p>
  <h3>Create Video Sitemap</h3>
  <form id="options_form" method="post" action="">
    <input type="checkbox" id="sboption" name="time" value="1" />
    <label for="sboption">Include video length? (Not recommended for sites will large number of videos)</label>
    <div class="submit">
      <input type="submit" name="submit" id="sb_submit" value="Generate Video Sitemap" />
    </div>
  </form>
  <p>You can click the button above to generate a Video Sitemap for your website. Once you have created your Sitemap, you should submit it to Google using Webmaster Tools. </p>
  <code>This WordPress plugin was developed by <a href="http://www.labnol.org/about/">Amit Agarwal</a> of <a href="http://www.labnol.org/">Digital Inspiration</a>.</code> </div>
<?php    }
}

function video_sitemap_loop () {
    global $wpdb;

    $posts = $wpdb->get_results ("SELECT id, post_title, post_content, post_date_gmt, post_excerpt 
    FROM $wpdb->posts WHERE post_status = 'publish' 
    AND (post_type = 'post' OR post_type = 'page')
    AND post_content LIKE '%youtube.com%' 
    ORDER BY post_date DESC");

    if (empty ($posts)) {
        return false;

    } else {

        $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";       
        $xml .= '<!-- Created by (http://wordpress.org/extend/plugins/xml-sitemaps-for-videos/) -->' . "\n";
        $xml .= '<!-- Generated-on="' . date("F j, Y, g:i a") .'" -->' . "\n";             
        $xml .= '<?xml-stylesheet type="text/xsl" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/xml-sitemaps-for-videos/video-sitemap.xsl"?>' . "\n" ;        
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">' . "\n";
        
        $videos = array();
    
        foreach ($posts as $post) {
            $c = 0;
            if (preg_match_all ("/youtube.com\/(v\/|watch\?v=|embed\/)([a-zA-Z0-9\-_]*)/", $post->post_content, $matches, PREG_SET_ORDER)) {

                    $excerpt = ($post->post_excerpt != "") ? $post->post_excerpt : $post->post_title ; 
                    $permalink = get_permalink($post->id); 

                foreach ($matches as $match) {
                                    
                        $id = $match [2];
                        $fix =  $c++==0?'':' [Video '. $c .'] ';
                        
                        if (in_array($id, $videos))
                            continue;
                            
                        array_push($videos, $id);
                        
                        $xml .= "\n <url>\n";
                        $xml .= " <loc>$permalink</loc>\n";
                        $xml .= " <video:video>\n";
                        $xml .= "  <video:player_loc allow_embed=\"yes\" autoplay=\"autoplay=1\">http://www.youtube.com/v/$id</video:player_loc>\n";
                        $xml .= "  <video:thumbnail_loc>http://i.ytimg.com/vi/$id/hqdefault.jpg</video:thumbnail_loc>\n";
                        $xml .= "  <video:title>" . htmlspecialchars($post->post_title) . $fix . "</video:title>\n";
                        $xml .= "  <video:description>" . $fix . htmlspecialchars($excerpt) . "</video:description>\n";
    
                    if ($_POST['time'] == 1) {  
                        $duration = youtube_duration ($id);
                        if ($duration != 0)
                            $xml .= "  <video:duration>".youtube_duration ($id)."</video:duration>\n";
                            }

                    $xml .= "  <video:publication_date>".date (DATE_W3C, strtotime ($post->post_date_gmt))."</video:publication_date>\n";
    
                    $posttags = get_the_tags($post->id); if ($posttags) { 
                    $tagcount=0;
                    foreach ($posttags as $tag) {
                        if ($tagcount++ > 32) break;
                        $xml .= "   <video:tag>$tag->name</video:tag>\n";
                        }
                    }    

                    $postcats = get_the_category($post->id); if ($postcats) { 
                    foreach ($postcats as $category) {
                        $xml .= "   <video:category>$category->name</video:category>\n";
                        break;
                        }
                    }        

                    $xml .= " </video:video>\n </url>";
                }
            }
        }

        $xml .= "\n</urlset>";
    }

    $video_sitemap_url = $_SERVER["DOCUMENT_ROOT"] . '/sitemap-video.xml';
    if (IsVideoSitemapWritable($_SERVER["DOCUMENT_ROOT"]) || IsVideoSitemapWritable($video_sitemap_url)) {
        if (file_put_contents ($video_sitemap_url, $xml)) {
            return true;
        }
    } 
echo '<br /><div class="wrap"><h2>Error writing the file</h2><p>The XML sitemap was generated successfully but the  plugin was unable to save the xml to your WordPress root folder at <strong>' . $_SERVER["DOCUMENT_ROOT"] . '</strong> probably because the folder doesn\'t have appropriate <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">write permissions</a>.</p><p>You can however manually copy-paste the following text into a file and save it as video-sitemap.xml in your WordPress root folder. </p><br /><textarea rows="30" cols="150" style="font-family:verdana; font-size:11px;color:#666;background-color:#f9f9f9;padding:5px;margin:5px">' . $xml . '</textarea></div>';    
    exit();
}

# given a video id, get the duration.
# might give this a delay to avoid running into issues with YouTube.
function youtube_duration ($id) {
    try {
        $ch = curl_init ();
        curl_setopt ($ch, CURLOPT_URL, "http://gdata.youtube.com/feeds/api/videos/$id");
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec ($ch);
        curl_close ($ch);

        preg_match ("/duration=['\"]([0-9]*)['\"]/", $data, $match);
        return $match [1];

    } catch (Exception $e) {
        # returning 0 if the YouTube API fails for some reason.
        return '0';
    }
}
?>
