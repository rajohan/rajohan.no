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
    $converter = new Converter;
    $user = new Users;

?>

<!-- SECTION USER START -->
<div class="container u-margin-bottom-medium">
    <img src="img/me.jpg" alt="User photo" class="user__img"> 
    
    <?php

        $user_data = $user->get_user("ID", $_SESSION['USER']['ID']);

        echo $user_data['USERNAME'];

    ?>

</div>
<!-- SECTION USER END -->