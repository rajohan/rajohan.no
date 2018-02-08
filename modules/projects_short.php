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
 
    $db_conn = new Database;
    $filter = new Filter;
    
    //-------------------------------------------------
    // Get the projects
    //-------------------------------------------------

    $stmt = $db_conn->connect->prepare("SELECT `NAME`, `CATEGORY`, `DESCRIPTION`, `IMAGE`, `URL` FROM `PROJECTS` ORDER BY `ID` DESC LIMIT 3");
    $stmt->execute();
    $result = $stmt->get_result();

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

            $db_conn->free_close($result, $stmt);

        ?>
    </div>
    <a href="projects/" class="btn btn--primary u-margin-top-medium u-margin-bottom-medium">See more projects</a>  
</section>
<!-- SECTION PROJECTS END -->