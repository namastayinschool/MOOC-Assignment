<!DOCTYPE html>
<html lang="en-GB">
<head>
    <title>Quwius</title>
    <link rel="stylesheet" href="css/styles.css" type="text/css" media="screen">
    <meta charset="utf-8">
</head>
<body>
<nav>
    <a href="index.php"><img src="images/logo.png" alt="Quwius"></a>
    <ul>
        <li><a href="index.php?controller=Courses">Courses</a></li>
        <li><a href="index.php?controller=Streams">Streams</a></li>
        <li><a href="index.php?controller=Home">About Us</a></li>
        <li><a href="index.php?controller=Login">Login</a></li>
        <li><a href="index.php?controller=SignUp">Sign Up</a></li>
    </ul>
</nav>
<div id="lead-in">
    <h1>Feed Your Curiosity,<br>
        Take Online Courses from UWI</h1>

    <form name="course_search" method="post" action="index.php?controller=">
        <div class="wide-thick-bordered">
            <input class="c-banner-search-input" type="text" name="formSearch" value=""
                   placeholder="Find the right course for you">
            <button class="c-banner-search-button"></button>
        </div>
    </form>
</div>
<header></header>
<main>
    <?php if (isset($pop_courses) && !empty($pop_courses) && is_array($pop_courses)) : ?>
        <h1>Most Popular</h1>

        <?php for ($i = 0; $i < count($pop_courses); $i++): ?>

            <?php if ($i % 4 === 0): ?>
                <div class="centered">
            <?php endif; ?>

            <section>
                <a href="#"><img src="images/<?php echo $pop_courses[$i]['course_image']; ?>"
                                 alt="<?php echo $pop_courses[$i]['course_name']; ?>"
                                 title="<?php echo $pop_courses[$i]['course_name']; ?>">
                    <span class="course-title"><?php echo $pop_courses[$i]['course_name']; ?></span>
                    <span><?php echo $pop_courses[$i]['instructor_name']; ?></span></a>
            </section>

            <?php if ($i === count($pop_courses) - 1 || $i > 0 && ($i + 1) % 4 === 0): ?>
                </div>
            <?php endif; ?>

        <?php endfor; ?>

    <?php endif; ?>


    <?php if (isset($rec_courses) && !empty($rec_courses) && is_array($rec_courses)) : ?>
        <h1>Learner Recommended</h1>

        <?php for ($i = 0; $i < count($rec_courses); $i++): ?>

            <?php if ($i % 4 === 0): ?>
                <div class="centered">
            <?php endif; ?>

            <section>
                <a href="#"><img src="images/<?php echo $rec_courses[$i]['course_image']; ?>"
                                 alt="<?php echo $rec_courses[$i]['course_name']; ?>"
                                 title="<?php echo $rec_courses[$i]['course_name']; ?>">
                    <span class="course-title"><?php echo $rec_courses[$i]['course_name']; ?></span>
                    <span><?php echo $rec_courses[$i]['instructor_name']; ?></span></a>
            </section>

            <?php if ($i === count($rec_courses) - 1 || $i > 0 && ($i + 1) % 4 === 0): ?>
                </div>
            <?php endif; ?>

        <?php endfor; ?>

    <?php endif; ?>

    <footer>
        <nav>
            <ul>
                <li>&copy;2018 Quwius Inc.</li>
                <li><a href="#">Company</a></li>
                <li><a href="#">Connect</a></li>
                <li><a href="#">Terms &amp; Conditions</a></li>
            </ul>
        </nav>
    </footer>
</main>
</body>
</html>