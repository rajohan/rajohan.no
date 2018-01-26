<?php
    ###########################################################################
    # BBcode parser
    ###########################################################################
    class Bbcode {

        function replace($data) {
            
            // BBcode array
            $find = array(
            '~\[b\]~s',
            '~\[/b\]~s',
            '~\[li\]~s',
            '~\[/li\]~s',
            '~\[br\]~s',
            '~\[ul\]~s',
            '~\[/ul\]~s',
            '~\[ol\]~s',
            '~\[/ol\]~s',
            '~\[p\]~s',
            '~\[/p\]~s',
            '~\[i\]~s',
            '~\[/i\]~s',
            '~\[u\]~s',
            '~\[/u\]~s',
            '~\[table\]~s',
            '~\[/table\]~s',
            '~\[tr\]~s',
            '~\[/tr\]~s',
            '~\[td\]~s',
            '~\[/td\]~s',
            '~\[quote\]~s',
            '~\[/quote\]~s',
            '~\[size=(.*?)\]~s',
            '~\[/size\]~s',
            '~\[color=((?:[a-zA-Z]|#[a-fA-F0-9]{3,6})+)\]~s',
            '~\[/color\]~s',
            '~\[url\]((?:ftp|https?)://.*?)\[/url\]~s',
            '~\[url=((?:ftp|https?)://.*?)\](.*?)\[/url\]~s',
            '~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s'
            );

            // HTML tags to replace BBcode
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
            '<pre>',
            '</'.'pre>',
            '<span style="font-size:$1px;">',
            '</span>',
            '<span style="color:$1;">',
            '</span>',
            '<a href="$1">$1</a>',
            '<a href="$1">$2</a>',
            '<img src="$1" alt="" />'
            );
            // Replacing the BBcodes with corresponding HTML tags
            return preg_replace($find,$replace,$data);

        }

    }
?>