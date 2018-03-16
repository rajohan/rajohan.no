<?php
    
    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    //-------------------------------------------------
    // Initialize classes
    //-------------------------------------------------

    $tag = new Tags;
    $sort_data = new Sort;

?>
<!-- SECTION BLOG NAVIGATION START -->
<div class="blog-navigation">
    <div class="blog-navigation__sort">
        <div class="blog-navigation__sort__buttons">
            <div id="blog-navigation__recent" class="blog-navigation__sort__buttons__item blog-navigation__sort__buttons__item__active" onclick="blog_nav_sort('recent');">Recent</div>
            <div id="blog-navigation__views" class="blog-navigation__sort__buttons__item" onclick="blog_nav_sort('views');">Views</div>
            <div id="blog-navigation__votes" class="blog-navigation__sort__buttons__item" onclick="blog_nav_sort('votes');">Votes</div>
        </div>
        <div class="blog-navigation__sort__box">
            <?php   

                //-------------------------------------------------
                // Get the blog nav
                //-------------------------------------------------

                require_once('modules/blog_nav_sort.php');
                
            ?>
        </div>
    </div>
    <div class="blog-navigation__search">
        <span class="blog-navigation__heading">Search</span>
        <form action="blog/search/">
            <div class="input__box">
            <input type="text" name="search" placeholder="Search...">
            <button class="input__button">
                <img class="input__button__icon" src="img/icons/search.svg" alt="search">
            </button>
        </div>
        </form>
    </div>
    <div class="blog-navigation__newsletter">
        <span class="blog-navigation__heading">Newsletter</span>
        <form>
            <div class="input__box">
                <input type="text" id="blog-navigation__newsletter__mail" name="newsletter" placeholder="Your email address...">
                <button id="blog-navigation__newsletter__button" class="input__button">
                    <img class="input__button__icon" src="img/icons/arrow_right.svg" alt="search">
                </button>
            </div>
        </form>
    </div>
    <div class="blog-navigation__tags">
        <span class="blog-navigation__heading">Tags</span>
        <div class="blog-navigation__tags__box">
                <?php 

                    //-------------------------------------------------
                    // Output tags
                    //-------------------------------------------------

                    $tags = $tag->get_all_tags();
                    $tags = $tag->add_count($tags);
                    $tag->output_tags($tags);

                ?>            
        </div>
    </div>
</div>
<!-- SECTION NAV NAVIGATION END -->