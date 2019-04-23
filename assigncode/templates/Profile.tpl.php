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
    <h1>Profile Page</h1>
    <h2>Enrolled Courses</h2>

    <?php if (isset($courses) && !empty($courses) && is_array($courses)) : ?>

        <ul class="course-list">

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
                        <a href="#" class="startnow-btn startnow-button">Go to Class!</a>
                        <a href="index.php?controller=Courses&delete=<?php echo $course['course_id']; ?>" class="startnow-btn unenroll-button">Unenroll</a>
                    </div>
                </li>

            <?php endforeach; ?>

        </ul>

    <?php else: ?>

        <div class="centered">
            <p>You have not registered for any courses.</p>
        </div>

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