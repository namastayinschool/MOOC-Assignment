<!DOCTYPE html>
<html lang="en-GB">
<head>
    <title>Quwius</title>
    <link rel="stylesheet" href="css/styles.css" type="text/css" media="screen">
    <meta charset="utf-8">
</head>
<body>
<nav>
    <a href="index.php"><img src="images/logo.png" alt="UWI online"></a>
    <ul>
        <li><a href="index.php?controller=Courses">Courses</a></li>
        <li><a href="index.php?controller=Streams">Streams</a></li>
        <li><a href="index.php?controller=Home">About Us</a></li>
        <li><a href="index.php?controller=Login">Login</a></li>
        <li><a href="index.php?controller=SignUp">Sign Up</a></li>
    </ul>
</nav>
<main>
    <h1>Courses</h1>
    <ul class="course-list">

        <?php if (isset($courses) && !empty($courses) && is_array($courses)) : ?>

            <?php foreach ($courses as $course): ?>

                <li>
                    <div>
                        <a href="#"><img src="images/<?php echo $course['course_image']; ?>"
                                         alt="<?php echo $course['course_name']; ?>"></a>
                    </div>
                    <div>
                        <a href="#"><span class="faculty-department"><?php echo $course['faculty_dept_name']; ?></span>
                            <span class="course-title"><?php echo $course['course_name']; ?></span>
                            <span class="instructor"><?php echo $course['instructor_name']; ?></span></a>
                    </div>
                    <div>
                        <p>Get Curious.</p>
                        <a href="index.php?controller=Courses&add=<?php echo $course['course_id']; ?>" class="startnow-button startnow-btn">Start Now!</a>
                    </div>
                </li>

            <?php endforeach; ?>

        <?php endif; ?>

    </ul>
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