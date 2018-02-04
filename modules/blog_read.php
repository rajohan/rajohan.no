<?php
    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    $db_conn = new Database(); // connect to database
    $filter = new Filter(); // Start filter
    $bbcode = new Bbcode(); // Start bbcode parser
    $tag = new Tags(); // Start the tag handler
    $converter = new Converter; // Start the converter

    $id = 3;

    $stmt = $db_conn->connect->prepare("SELECT * FROM `BLOG` WHERE ID=? ORDER BY `ID` DESC LIMIT 1"); // prepare statement
    $stmt->bind_param("i", $id); // Bind variables to the prepared statement as parameters
    $stmt->execute(); // select from database
    $result = $stmt->get_result(); // Get the result
    
    while ($row = $result->fetch_assoc()) {
        $id = $filter->sanitize($row['ID']);
        $img = $filter->sanitize($row['IMAGE']);
        $title = $filter->sanitize($row['TITLE']);
        $publish_date = $filter->sanitize($row['PUBLISH_DATE']);
        $published_by = $filter->sanitize($row['PUBLISHED_BY_USER']);
        $update_date = $filter->sanitize($row['UPDATE_DATE']);
        $updated_by = $filter->sanitize($row['UPDATED_BY_USER']);
        $seen = $filter->sanitize($row['SEEN']);
        $likes = $filter->sanitize($row['LIKES']);
        $dislikes = $filter->sanitize($row['DISLIKES']);
        $short_blog = $bbcode->replace($filter->sanitize($row['SHORT_BLOG']));
        $blog = $bbcode->replace($filter->sanitize($row['BLOG']));
        // Dates
        $publish_date = $converter->date($publish_date);
        $update_date = $converter->date($update_date);   
    }

    $db_conn->free_close($result, $stmt); // free result and close db connection

?>
<!-- SECTION BLOG READ START -->
<div class="blog-short__container">
    <div class="blog-short__box">
        <div class="blog-short__img" >
            <img src="img/blog/<?php echo $img; ?>" alt="<?php echo $title; ?>">
        </div>
        <div class="blog-short__title">
            <?php echo $title; ?>
        </div>
        <div class="blog-short__by">
            <?php echo "Postet ".$publish_date." av ".$published_by ?>
        </div>
        <div class="blog-short__updated-by">
            <?php echo "Oppdatert ".$update_date." av ".$updated_by; ?>
        </div>
        <div id="story_votes_wrapper">
            <div id="story_seen" class="story_votes">
        </div>
        <?php echo $seen; ?>
        <div id="story_vote_up" class="story_votes">
        </div>
        <?php echo $likes; ?>
        <div id="story_vote_down" class="story_votes">
        </div>
        <?php echo $dislikes; ?>
        <div class="blog-short__tags">
            <?php 
                $tag_name = $tag->get_blog_tags($id);
                $tag->output_tags($tag_name); 
            ?>
        </div>
        <div class="blog-short__story">
            <?php echo $short_blog; ?>
        </div>
        <div id="full_story">
            <?php echo $blog; ?>
        </div>
    </div>
    <div id="comment_count_social_wrapper">
        <div id="comment_count_wrapper">
            <div id="comment_text">
                KOMMENTARER
            </div>
            <div id="comment_img">
                <div id="comment_count">
                    158
                </div>
            </div>
        </div>
        <div id="social_media__share_wrapper">
            DEL DETTE
            <div id="facebook_share" class="social_media_share">
            </div>
            <div id="twitter_share" class="social_media_share">
            </div>
            <div id="reddit_share" class="social_media_share">
            </div>
        </div>
    </div>
    <div id="comment_sort_wrapper">
        <div>
            Eldste først | Nyeste først | Beste kommentarer
        </div>
        <div>
            Side 1 2 3 4 5 6 Neste
        </div>
    </div>
    <div class="comment_top">
        <div>
            Rajohan (<span class="rating">53</span>)<span class="admin">ADMIN</span>
        </div>
        <div class="date_reply">
            <div>
                27.12.2017 19:37
            </div>
            <div class="reply">
            </div>
        </div>
    </div>
    <div class="comment">
        <?php echo $short_blog; ?>
    </div>
    <div class="comment_vote_userstats">
        <div class="comment_vote">
            <div class="comment_vote_up">
            </div>
            <div>
                <span class="comment_stats">+36 </span>(+47 / -11)
            </div>
            <div class="comment_vote_down">
            </div>
        </div>
        <div>
            Skjul svar
        </div>
        <div class="comment_userstats">
            254 kommentarer | Registrert 28.12.2017
        </div>
    </div>
    <div style="padding-left: 100px;">
        <div class="comment_top">
            <div>
                Rajohan (<span class="rating">53</span>)<span class="admin">ADMIN</span>
            </div>
            <div class="date_reply">
                <div>
                    27.12.2017 19:37
                </div>
                <div class="reply">
                </div>
            </div>
        </div>
        <div class="comment">
            <?php echo $short_blog; ?>
        </div>
        <div class="comment_vote_userstats">
            <div class="comment_vote">
                <div class="comment_vote_up">
                </div>
                <div>
                    <span class="comment_stats">+36 </span>(+47 / -11)
                </div>
                <div class="comment_vote_down">
                </div>
            </div>
            <div class="comment_userstats">
                254 kommentarer | Registrert 28.12.2017
            </div>
        </div>
    </div>
    <div style="padding-left: 100px;">
        <div class="comment_top">
            <div>
                Rajohan (<span class="rating">53</span>)<span class="admin">ADMIN</span>
            </div>
            <div class="date_reply">
                <div>
                    27.12.2017 19:37
                </div>
                <div class="reply">
                </div>
            </div>
        </div>
        <div class="comment">
            <?php echo $short_blog; ?>
        </div>
        <div class="comment_vote_userstats">
            <div class="comment_vote">
                <div class="comment_vote_up">
                </div>
                <div>
                    <span class="comment_stats">+36 </span>(+47 / -11)
                </div>
                <div class="comment_vote_down">
                </div>
            </div>
            <div class="comment_userstats">
                254 kommentarer | Registrert 28.12.2017
            </div>
        </div>
    </div>
    <div class="comment_top">
        <div>
            Rajohan (<span class="rating">53</span>)<span class="admin">ADMIN</span>
        </div>
        <div class="date_reply">
            <div>
                27.12.2017 19:37
            </div>
            <div class="reply">
            </div>
        </div>
    </div>
    <div class="comment">
        <?php echo $short_blog; ?>
    </div>
    <div class="comment_vote_userstats">
        <div class="comment_vote">
            <div class="comment_vote_up">
            </div>
            <div>
                <span class="comment_stats">+36 </span>(+47 / -11)
            </div>
            <div class="comment_vote_down">
            </div>
        </div>
        <div class="comment_userstats">
            254 kommentarer | Registrert 28.12.2017
        </div>
    </div>
    <div class="comment_top">
        <div>
            Rajohan (<span class="rating">53</span>)<span class="admin">ADMIN</span>
        </div>
        <div class="date_reply">
            <div>
                27.12.2017 19:37
            </div>
            <div class="reply">
            </div>
        </div>
    </div>
    <div class="comment">
        <?php echo $short_blog; ?>
    </div>
    <div class="comment_vote_userstats">
        <div class="comment_vote">
            <div class="comment_vote_up">
            </div>
            <div>
                <span class="comment_stats">+36 </span>(+47 / -11)
            </div>
            <div class="comment_vote_down">
            </div>
        </div>
        <div class="comment_userstats">
            254 kommentarer | Registrert 28.12.2017
        </div>
    </div>
    <div class="comment_top">
        <div>
            Rajohan (<span class="rating">53</span>)<span class="admin">ADMIN</span>
        </div>
        <div class="date_reply">
            <div>
                27.12.2017 19:37
            </div>
            <div class="reply">
            </div>
        </div>
    </div>
    <div class="comment">
        <?php echo $short_blog; ?>
    </div>
    <div class="comment_vote_userstats">
        <div class="comment_vote">
            <div class="comment_vote_up">
            </div>
            <div>
                <span class="comment_stats">+36 </span>(+47 / -11)
            </div>
            <div class="comment_vote_down">
            </div>
        </div>
        <div class="comment_userstats">
            254 kommentarer | Registrert 28.12.2017
        </div>
    </div>
    <fieldset>
        <textarea placeholder="Din kommentar..." class="comment_textarea" tabindex="1" style="margin-top: 15px; min-width: 100%; padding:10px; max-width: 100%; height:100px; background:#FFF; border:1px solid #CCC;"></textarea>
    </fieldset>
    <fieldset>
        <button name="submit" type="submit" class="comment_submit" style="width:100%; padding: 10px; border:none;">Send kommentar</button>
    </fieldset>
</div>
<!-- SECTION BLOG READ END -->