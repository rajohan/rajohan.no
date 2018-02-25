<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    //-------------------------------------------------
    // BBcode parser
    //-------------------------------------------------
    
    class Bbcode {

        //-------------------------------------------------
        // Method to replace html with bbcodes
        //-------------------------------------------------

        function html_to_bbcode() {

            $find = array(

                    '~\<b\>~i',
                    '~\<\/b\>~i',
                    '~\<li\>~i',
                    '~\<\/li\>~i',
                    '~\<br\>~i',
                    '~\<ul\>~i',
                    '~\<\/ul\>~i',
                    '~\<ol\>~i',
                    '~\<\/ol\>~i',
                    '~\<p\>~i',
                    '~\<\/p\>~i',
                    '~\<i\>~i',
                    '~\<\/i\>~i',
                    '~\<u\>~i',
                    '~\<\/u\>~i',
                    '~\<div\>~i',
                    '~\<\/div\>~i',
                    '~\<strike\>~i',
                    '~\<\/strike\>~i',
                    '~\<a href="((?:ftp|http|https?)://.*?)"\>.*?\<\/a\>~i',
                    '~\<a href="((?:ftp|http|https?)://.*?)"\>.*?\<\/a\>~i',
                    '~\<img src="((?:http|https?)://.*?\.(?:jpg|jpeg|gif|png|bmp|svg))" alt=".*?"\>~i',
                    '~\<img src="((?:http|https?)://.*?\.(?:jpg|jpeg|gif|png|bmp|svg))" class="emoticon" alt=".*?" style="margin-bottom: -0.3rem; width: 1.7rem; height: 1.7rem;"\>~i'

                );
    
                $replace = array(

                    '[b]',
                    '[/b]',
                    '[li]',
                    '[/li]',
                    '[br]',
                    '[ul]',
                    '[/ul]',
                    '[ol]',
                    '[/ol]',
                    '[p]',
                    '[/p]',
                    '[i]',
                    '[/i]',
                    '[u]',
                    '[/u]',
                    '[br]',
                    '',
                    '[strike]',
                    '[/strike]',
                    '[url]$1[/url]',
                    '[url=$1]$2[/url]',
                    '[img]$1[/img]',
                    '[emoticon]$1[/emoticon]'
  
                );
    
                return preg_replace($find,$replace,$data);
    
        }

        //-------------------------------------------------
        // Method to replace bbcodes with html
        //-------------------------------------------------

        function replace($data) {
            
            $find = array(

                '~\[b\]~i',
                '~\[/b\]~i',
                '~\[li\]~i',
                '~\[/li\]~i',
                '~\[br\]~i',
                '~\[ul\]~i',
                '~\[/ul\]~i',
                '~\[ol\]~i',
                '~\[/ol\]~i',
                '~\[p\]~i',
                '~\[/p\]~i',
                '~\[i\]~i',
                '~\[/i\]~i',
                '~\[u\]~i',
                '~\[/u\]~i',
                '~\[table\]~i',
                '~\[/table\]~i',
                '~\[tr\]~i',
                '~\[/tr\]~i',
                '~\[td\]~i',
                '~\[/td\]~i',
                '~\[quote\]~i',
                '~\[/quote\]~i',
                '~\[code\]~i',
                '~\[/code\]~i',
                '~\[size=(.*?)\]~i',
                '~\[/size\]~i',
                '~\[color=((?:[a-zA-Z]|#[a-fA-F0-9]{3,6})+)\]~i',
                '~\[/color\]~i',
                '~\[url\]((?:ftp|https?)://.*?)\[/url\]~i',
                '~\[url=((?:ftp|https?)://.*?)\](.*?)\[/url\]~i',
                '~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~i'

            );

            $replace = array(

                '<b>',
                '</b>',
                '<li>',
                '</li>',
                '<br>',
                '<ul>',
                '</ul>',
                '<ol>',
                '</ol>',
                '<p>',
                '</p>',
                '<i>',
                '</i>',
                '<u>',
                '</u>',
                '<table>',
                '</table>',
                '<tr>',
                '</tr>',
                '<td>',
                '</td>',
                '<span class="quote">',
                '</span>',
                '<pre><code>',
                '</code></pre>',
                '<span style="font-size:$1px;">',
                '</span>',
                '<span style="color:$1;">',
                '</span>',
                '<a href="$1">$1</a>',
                '<a href="$1">$2</a>',
                '<img src="$1" alt="" />'
            
            );

            return preg_replace($find,$replace,$data);

        }

    }
    
?>