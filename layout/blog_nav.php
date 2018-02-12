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

    $filter = new Filter;
    $pagination = new Pagination;
    $tag = new Tags;
    $converter = new Converter;
    $users = new Users;

?>
<!-- SECTION BLOG SHORT START -->
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
        <form action="blog/search/" class="blog-navigation__search__form">
            <input type="text" name="search" class="blog-navigation__search__form__input" placeholder="Search...">
            <button class="blog-navigation__search__form__button">
                <img class="blog-navigation__search__form__icon" src="img/icons/search.svg" alt="search">
            </button>
        </form>
    </div>
    <div class="blog-navigation__newsletter">
        <span class="blog-navigation__heading">Newsletter</span>
        <form class="blog-navigation__newsletter__form">
            <input type="text" id="blog-navigation__newsletter__mail" name="newsletter" class="blog-navigation__newsletter__form__input" placeholder="Your email address...">
            <button id="blog-navigation__newsletter__button" class="blog-navigation__newsletter__form__button">
                <img class="blog-navigation__newsletter__form__icon" src="img/icons/arrow_right.svg" alt="search">
            </button>
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
<!-- SECTION NAV BLOG END -->