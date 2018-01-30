<?php

    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
 
    $db_conn = new Database(); // connect to database
    $filter = new Filter(); // Start filter
    
    $stmt = $db_conn->connect->prepare("SELECT NAME, CATEGORY, DESCRIPTION, IMAGE, URL FROM `PROJECTS` ORDER BY `ID` DESC LIMIT 3"); // prepare statement
    $stmt->execute(); // select from database
    $result = $stmt->get_result(); // Get the result

?>

<!-- SECTION PROJECTS START -->
<section class="projects-short">
    <h1 class="heading-secondary heading-secondary--white letter-spacing-medium u-margin-top-medium">Projects</h1>
    <h1 class="heading-tertiary letter-spacing-small">My latest projects</h1>
    <div class="projects-short__box">
        <?php 

            while ($row = $result->fetch_assoc()) {

                $name = $filter->sanitize($row['NAME']);
                $category = $filter->sanitize($row['CATEGORY']);
                $description = $filter->sanitize($row['DESCRIPTION']);
                $img = $filter->sanitize($row['IMAGE']);
                $url = $filter->sanitize($row['URL']);

                echo '<div class="projects-short__item">';
                echo '<img src="img/projects/'.$img.'" alt="'.$name.'" class="projects-short__img">';
                echo '<h3 class="u-margin-top-small">'.ucfirst($category).' &ndash; '.ucfirst($name).'</h3>';
                echo $description;
                echo '<span class="u-margin-top-small">';
                echo '<a href="'.$url.'" target="_blank" class="projects-short__view whitelink">View project <span>&roarr;</span></a>';
                echo '</span>';
                echo '</div>';

            }

            $db_conn->free_close($result, $stmt); // free result and close db connection

        ?>
    </div>
    <a href="projects/" class="btn btn--primary u-margin-top-medium u-margin-bottom-medium">See more projects</a>  
</section>
<!-- SECTION PROJECTS END -->