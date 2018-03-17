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

    $user = new Users;
    $login = new Login;

    //-------------------------------------------------
    // Get user data 
    //-------------------------------------------------

    if ($login->login_check()) {

        $user_data = $user->get_user("ID", $_SESSION['USER']['ID']);
    
    }
    
    //-------------------------------------------------
    // Output admin nav bar if user is admin
    //-------------------------------------------------

    if((isset($user_data['ADMIN'])) && ($user_data['ADMIN'] > 0)) {

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
                <a href="admin/new_blog_post/">
                    <img src="img/icons/write.svg" alt="new blog post">
                    New blog post
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/edit_blog_posts/">
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
                <a href="admin/new_tag/">
                    <img src="img/icons/subject.svg" alt="tag">
                    Create new tag
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/edit_tags/">
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
                <a href="admin/new_user/">
                    <img src="img/icons/new_user.svg" alt="new user">
                    Create new user
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/edit_users/">
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
                <a href="admin/contact_messages/">
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
                <a href="admin/send_newsletter/">
                    <img src="img/icons/send_newsletter.svg" alt="send newsletter">
                    Send newsletter
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/edit_newsletter_list/">
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
                <a href="admin/upload_image/">
                    <img src="img/icons/upload_image.svg" alt="upload image">
                    Upload image
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/edit_images/">
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
                <a href="admin/settings/">
                    <img src="img/icons/general_settings.svg" alt="settings">
                    General settings
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/new_page/">
                    <img src="img/icons/new_page.svg" alt="new page">
                    Add new page
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/edit_pages/">
                    <img src="img/icons/edit_pages.svg" alt="edit pages">
                    Edit pages
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/header/">
                    <img src="img/icons/header.svg" alt="header">
                    Header
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/navigation/">
                    <img src="img/icons/navigation.svg" alt="navigation">
                    Navigation
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/footer/">
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
                <a href="admin/new_project/">
                    <img src="img/icons/add_project.svg" alt="new project">
                    Add project
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/edit_projects/">
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
                <a href="admin/auth_log/">
                    <img src="img/icons/auth_log.svg" alt="auth log">
                    Auth log
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/verification_log/">
                    <img src="img/icons/verification_log.svg" alt="verification log">
                    Verification log
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/traffic_log/">
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
                <a href="admin/about_me/">
                    <img src="img/icons/about_me.svg" alt="about me">
                    About me
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/cv/">
                    <img src="img/icons/cv.svg" alt="cv">
                    Cv
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/computer_setup/">
                    <img src="img/icons/computer_setup.svg" alt="computer setup">
                    Computer setup
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/services/">
                    <img src="img/icons/services.svg" alt="services">
                    Services
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/why_me/">
                    <img src="img/icons/why_me.svg" alt="why_me">
                    Why me
                </a>
            </li>
            <li class="admin-navigation__list__item">
                <a href="admin/legal_policies/">
                    <img src="img/icons/legal.svg" alt="legal policies">
                    Legal policies
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- SECTION ADMIN NAVIGATION END -->
<?php
    }
?>