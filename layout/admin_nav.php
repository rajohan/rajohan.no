<?php
    
    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

?>
<!-- SECTION ADMIN NAVIGATION START -->
<div class="admin-navigation">
    <div class="admin-navigation__blog">
        <span class="admin-navigation__heading">Dashboard</span>
        <ul class="admin-navigation__list">
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/dashboard.svg" alt="dashboard">
                    Dashboard
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-navigation__blog">
        <span class="admin-navigation__heading">Blog posts</span>
        <ul class="admin-navigation__list">
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/write.svg" alt="new blog post">
                    New blog post
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/refresh.svg" alt="edit blog pos">
                    Edit blog posts
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-navigation__user">
        <span class="admin-navigation__heading">Tags</span>
        <ul class="admin-navigation__list">
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/subject.svg" alt="tag">
                    Create new tag
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/refresh.svg" alt="edit tags">
                    Edit tags
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-navigation__user">
        <span class="admin-navigation__heading">Users</span>
        <ul class="admin-navigation__list">
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/new_user.svg" alt="new user">
                    Create new user
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/edit_users.svg" alt="edit users">
                    Edit users
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-navigation__blog">
        <span class="admin-navigation__heading">Contact me</span>
        <ul class="admin-navigation__list">
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/message.svg" alt="Messages">
                    Messages
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-navigation__user">
        <span class="admin-navigation__heading">Newsletter</span>
        <ul class="admin-navigation__list">
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/send_newsletter.svg" alt="send newsletter">
                    Send newsletter
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/edit_newsletter_list.svg" alt="edit newsletter list">
                    Edit newsletter list
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-navigation__images">
        <span class="admin-navigation__heading">Images</span>
        <ul class="admin-navigation__list">
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/upload_image.svg" alt="upload image">
                    Upload image
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/edit_images.svg" alt="edit images">
                    Edit images
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-navigation__settings">
        <span class="admin-navigation__heading">Settings</span>
        <ul class="admin-navigation__list">
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/general_settings.svg" alt="settings">
                    General settings
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/new_page.svg" alt="new page">
                    Add new page
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/edit_pages.svg" alt="edit pages">
                    Edit pages
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/header.svg" alt="header">
                    Header
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/navigation.svg" alt="navigation">
                    Navigation
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/footer.svg" alt="footer">
                    Footer
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-navigation__page">
        <span class="admin-navigation__heading">Projects</span>
        <ul class="admin-navigation__list">
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/add_project.svg" alt="new project">
                    Add project
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/projects.svg" alt="edit projects">
                    Edit projects
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-navigation__page">
        <span class="admin-navigation__heading">Logs</span>
        <ul class="admin-navigation__list">
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/auth_log.svg" alt="auth log">
                    Auth log
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/verification_log.svg" alt="verification log">
                    Verification log
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/traffic_log.svg" alt="traffic log">
                    Traffic log
                </a>
            </li>
        </ul>
    </div>
    <div class="admin-navigation__page">
        <span class="admin-navigation__heading">Pages</span>
        <ul class="admin-navigation__list">
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/about_me.svg" alt="about me">
                    About me
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/cv.svg" alt="cv">
                    Cv
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/computer_setup.svg" alt="computer setup">
                    Computer setup
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/services.svg" alt="services">
                    Services
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/why_me.svg" alt="why_me">
                    Why me
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/">
                    <img src="img/icons/legal.svg" alt="legal policies">
                    Legal policies
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- SECTION ADMIN NAVIGATION END -->