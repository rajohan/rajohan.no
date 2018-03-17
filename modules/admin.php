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
    
    $page = new Page_handler;
    $user = new Users;
    $login = new Login;

    //-------------------------------------------------
    // Get user data
    //-------------------------------------------------

    if ($login->login_check()) {

        $user_data = $user->get_user("ID", $_SESSION['USER']['ID']);

    } else {

        header('Location: /login/');
        exit;

    }

    //-------------------------------------------------
    // Output admin nav bar if user is admin
    //-------------------------------------------------

    if((isset($user_data['ADMIN'])) && ($user_data['ADMIN'] > 0)) {

        //-------------------------------------------------
        // Get admin page to view
        //-------------------------------------------------

        $adminPage = $page->adminPage;

    ?>

<!-- SECTION ADMIN START -->
<div class="container u-margin-bottom-medium">

    <?php

    // New blog post
    if($adminPage === "new_blog_post") {

        require_once('admin/new_blog_post.php'); 

    }
    
    // Edit blog post
    else if($adminPage === "edit_blog_posts") {

        require_once('admin/edit_blog_posts.php'); 

    } 
    
    // New tag
    else if($adminPage === "new_tag") {

        require_once('admin/new_tag.php'); 

    } 
    
    // Edit tags
    else if($adminPage === "edit_tags") {

        require_once('admin/edit_tags.php'); 

    } 
    
    // New user
    else if($adminPage === "new_user") {

        require_once('admin/new_user.php'); 

    } 
    
    // Edit users
    else if($adminPage === "edit_users") {

        require_once('admin/edit_users.php'); 

    } 

    // Contact messages
    else if($adminPage === "contact_messages") {

        require_once('admin/contact_messages.php'); 

    } 

    // Send newsletter
    else if($adminPage === "send_newsletter") {

        require_once('admin/send_newsletter.php'); 

    } 
    
    // Edit newsletter list
    else if($adminPage === "edit_newsletter_list") {

        require_once('admin/edit_newsletter_list.php'); 

    } 

    // Upload image
    else if($adminPage === "upload_image") {

        require_once('admin/upload_image.php'); 

    }

    // Edit images
    else if($adminPage === "edit_images") {

        require_once('admin/edit_images.php'); 

    } 
    
    // Settings
    else if($adminPage === "settings") {

        require_once('admin/settings.php'); 

    }

    // New page
    else if($adminPage === "new_page") {

        require_once('admin/new_page.php'); 

    } 
    
    // Edit pages
    else if($adminPage === "edit_pages") {

        require_once('admin/edit_pages.php'); 

    } 
    
    // Header
    else if($adminPage === "header") {

        require_once('admin/header.php'); 

    }
    
    // Navigation
    else if($adminPage === "navigation") {

        require_once('admin/navigation.php'); 

    }
    
    // Footer
    else if($adminPage === "footer") {

        require_once('admin/footer.php'); 

    }
    
    // New project
    else if($adminPage === "new_project") {

        require_once('admin/new_project.php'); 

    } 
    
    // Edit projects
    else if($adminPage === "edit_projects") {

        require_once('admin/edit_projects.php'); 

    }
    
    // Auth log
    else if($adminPage === "auth_log") {

        require_once('admin/auth_log.php'); 

    } 
    
    // Verification log
    else if($adminPage === "verification_log") {

        require_once('admin/verification_log.php'); 

    }
    
    // Traffic log
    else if($adminPage === "traffic_log") {

        require_once('admin/traffic_log.php'); 

    } 
    
    // About me
    else if($adminPage === "about_me") {

        require_once('admin/about_me.php'); 

    }
    
    // Cv
    else if($adminPage === "cv") {

        require_once('admin/cv.php'); 

    } 
    
    // Computer setup
    else if($adminPage === "computer_setup") {

        require_once('admin/computer_setup.php'); 

    }
    
    // Services
    else if($adminPage === "services") {

        require_once('admin/services.php'); 

    }
    
    // Why me
    else if($adminPage === "why_me") {

        require_once('admin/why_me.php'); 

    } 
    
    // Legal policies
    else if($adminPage === "legal_policies") {

        require_once('admin/legal_policies.php'); 

    } else { // Dashboard

        require_once('admin/dashboard.php');

    }

    ?>

</div>
<!-- SECTION ADMIN END -->
<?php

    } else {

        header('Location: /user/');
        exit;
    
    }

?>