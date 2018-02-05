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
    $vote = new Vote;

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
<div class="blog__container u-margin-bottom-medium">
    <div class="blog__box">
        <div class="blog__img" >
            <img src="img/blog/<?php echo $img; ?>" alt="<?php echo $title; ?>">
        </div>
        <div class="blog__title">
            <?php echo ucfirst($title); ?>
        </div>
        <div class="blog__by">
            <?php echo "Posted ".$publish_date." by ".ucfirst($published_by); ?>
        </div>
        <div class="blog__updated-by">
            <?php echo "Updated ".$update_date." by ".ucfirst($updated_by); ?>
        </div>
        <div class="blog__stats">
            <img src="img/icons/seen.svg" alt="seen" class="blog__stats__img">
            <?php echo $seen; ?>
            <img src="img/icons/like.svg" alt="like" class="blog__stats__img">
            <?php echo $likes; ?>
            <img src="img/icons/dislike.svg" alt="dislike" class="blog__stats__img">
            <?php echo $dislikes; ?>
        </div>
        <div class="blog__tags">
            <?php 
                $tag_name = $tag->get_blog_tags($id);
                $tag->output_tags($tag_name); 
            ?>
        </div>
        <div class="blog__short">
            <?php echo ucfirst($short_blog); ?>
        </div>
        <div class="blog__full">
            <?php echo ucfirst($blog); ?>
        </div>
        <div class="blog__comment__stats">
            <div class="blog__comment__stats__count">
                <div class="blog__comment__stats__count__text">
                    COMMENTS
                </div>
                <div class="blog__comment__stats__count__img">
                    <div class="blog__comment__stats__count__img__text">
                        158
                    </div>
                </div>
            </div>
            <div class="blog__comment__stats__social_media">
                SHARE
                <img src="img/icons/facebook.svg" alt="facebook" class="blog__comment__stats__social_media__img">
                <img src="img/icons/twitter.svg" alt="twitter" class="blog__comment__stats__social_media__img">
                <img src="img/icons/reddit.svg" alt="reddit" class="blog__comment__stats__social_media__img">
            </div>
        </div>
        <div class="blog__comment__sort">
            <div class="blog__comment__sort__by">
                Oldest first | Newest first | Best comments
            </div>
            <div class="blog__comment__sort__pagination">
                Page 1 2 3 4 5 6 Next
            </div>
        </div>
        <div class="blog__comment__user">
            <div>
                Rajohan (<span class="blog__comment__user__rating">53</span>)<span class="blog__comment__user__admin">ADMIN</span>
            </div>
            <div class="blog__comment__date-reply">
                27.12.2017 19:37
                <img src="img/icons/reply.svg" alt="reddit" class="blog__comment__date-reply__img">
            </div>
        </div>
        <div class="blog__comment__message">
            <?php echo $short_blog; ?>
        </div>
        <div class="blog__comment__message__stats">
            <div class="blog__comment__message__vote">
                <img src="img/icons/like.svg" alt="like" class="blog__comment__message__vote__img">
                <div class="blog__comment__message__vote__stats">
                    <span class="blog__comment__message__vote__stats__count">+36 </span>(+47 / -11)
                </div>
                <img src="img/icons/dislike.svg" alt="dislike" class="blog__comment__message__vote__img">
            </div>
            <div class="blog__comment__message__hide">
                Hide answers
            </div>
            <div class="blog__comment__user__stats">
                254 comments | Registered 28.12.2017
            </div>
        </div>
        <div style="padding-left: 100px;">
            <div class="blog__comment__user">
                <div>
                    Rajohan (<span class="blog__comment__user__rating">53</span>)<span class="blog__comment__user__admin">ADMIN</span>
                </div>
                <div class="blog__comment__date-reply">
                    27.12.2017 19:37
                    <img src="img/icons/reply.svg" alt="reddit" class="blog__comment__date-reply__img">
                </div>
            </div>
            <div class="blog__comment__message">
                <?php echo $short_blog; ?>
            </div>
            <div class="blog__comment__message__stats">
                <div class="blog__comment__message__vote">
                    <img src="img/icons/like.svg" alt="like" class="blog__comment__message__vote__img">
                    <div class="blog__comment__message__vote__stats">
                        <span class="blog__comment__message__vote__stats__count">+36 </span>(+47 / -11)
                    </div>
                    <img src="img/icons/dislike.svg" alt="dislike" class="blog__comment__message__vote__img">
                </div>
                <div class="blog__comment__message__hide">
                    
                </div>
                <div class="blog__comment__user__stats">
                    254 comments | Registered 28.12.2017
                </div>
            </div>
        </div>
        <div style="padding-left: 100px;">
            <div class="blog__comment__user">
                <div>
                    Rajohan (<span class="blog__comment__user__rating">53</span>)<span class="blog__comment__user__admin">ADMIN</span>
                </div>
                <div class="blog__comment__date-reply">
                    27.12.2017 19:37
                    <img src="img/icons/reply.svg" alt="reddit" class="blog__comment__date-reply__img">
                </div>
            </div>
            <div class="blog__comment__message">
                <?php echo $short_blog; ?>
            </div>
            <div class="blog__comment__message__stats">
                <div class="blog__comment__message__vote">
                    <img src="img/icons/like.svg" alt="like" class="blog__comment__message__vote__img">
                    <div class="blog__comment__message__vote__stats">
                        <span class="blog__comment__message__vote__stats__count">+36 </span>(+47 / -11)
                    </div>
                    <img src="img/icons/dislike.svg" alt="dislike" class="blog__comment__message__vote__img">
                </div>
                <div class="blog__comment__message__hide">
                    
                </div>
                <div class="blog__comment__user__stats">
                    254 comments | Registered 28.12.2017
                </div>
            </div>
        </div>
        <div class="blog__comment__user">
            <div>
                Rajohan (<span class="blog__comment__user__rating">53</span>)<span class="blog__comment__user__admin">ADMIN</span>
            </div>
            <div class="blog__comment__date-reply">
                27.12.2017 19:37
                <img src="img/icons/reply.svg" alt="reddit" class="blog__comment__date-reply__img">
            </div>
        </div>
        <div class="blog__comment__message">
            <?php echo $short_blog; ?>
        </div>
        <div class="blog__comment__message__stats">
            <div class="blog__comment__message__vote">
                <img src="img/icons/like.svg" alt="like" class="blog__comment__message__vote__img">
                <div class="blog__comment__message__vote__stats">
                    <span class="blog__comment__message__vote__stats__count">+36 </span>(+47 / -11)
                </div>
                <img src="img/icons/dislike.svg" alt="dislike" class="blog__comment__message__vote__img">
            </div>
            <div class="blog__comment__message__hide">
                
            </div>
            <div class="blog__comment__user__stats">
                254 comments | Registered 28.12.2017
            </div>
        </div>
        <div class="blog__comment__user">
            <div>
                Rajohan (<span class="rating">53</span>)<span class="blog__comment__user__admin">ADMIN</span>
            </div>
            <div class="blog__comment__date-reply">
                27.12.2017 19:37
                <img src="img/icons/reply.svg" alt="reddit" class="blog__comment__date-reply__img">
            </div>
        </div>
        <div class="blog__comment__message">
            <?php echo $short_blog; ?>
        </div>
        <div class="blog__comment__message__stats">
            <div class="blog__comment__message__vote">
                <img src="img/icons/like.svg" alt="like" class="blog__comment__message__vote__img">
                <div class="blog__comment__message__vote__stats">
                    <span class="blog__comment__message__vote__stats__count">+36 </span>(+47 / -11)
                </div>
                <img src="img/icons/dislike.svg" alt="dislike" class="blog__comment__message__vote__img">
            </div>
            <div class="blog__comment__message__hide">
                
            </div>
            <div class="blog__comment__user__stats">
                254 comments | Registered 28.12.2017
            </div>
        </div>
        <div class="blog__comment__user">
            <div>
                Rajohan (<span class="blog__comment__user__rating">53</span>)<span class="blog__comment__user__admin">ADMIN</span>
            </div>
            <div class="blog__comment__date-reply">
                27.12.2017 19:37
                <img src="img/icons/reply.svg" alt="reddit" class="blog__comment__date-reply__img">
            </div>
        </div>
        <div class="blog__comment__message">
            <?php echo $short_blog; ?>
        </div>
        <div class="blog__comment__message__stats">
            <div class="blog__comment__message__vote">
                <img src="img/icons/like.svg" alt="like" class="blog__comment__message__vote__img">
                <div class="blog__comment__message__vote__stats">
                    <span class="blog__comment__message__vote__stats__count">+36 </span>(+47 / -11)
                </div>
                <img src="img/icons/dislike.svg" alt="dislike" class="blog__comment__message__vote__img">
            </div>
            <div class="blog__comment__message__hide">
                
            </div>
            <div class="blog__comment__user__stats">
                254 comments | Registered 28.12.2017
            </div>
        </div>
        <fieldset>
            <textarea placeholder="Din kommentar..." class="blog__comment__textarea" tabindex="1"></textarea>
        </fieldset>
        <fieldset>
            <button name="submit" type="submit" class="blog__comment__submit">Send kommentar</button>
        </fieldset>
    </div>
</div>
<!-- SECTION BLOG READ END -->