<!DOCTYPE html>
<html lang="en-GB">
<head>
    <title>Streams | Quwius</title>
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
<div id="streams-lead-in">
    <h1>Take specialized courses<br>
        Earn Streams Certifications</h1>
</div>
<header id="streams-header"></header>
<main class="streams">
    <?php if (isset($streams) && !empty($streams) && is_array($streams)) : ?>

        <?php for ($i = 0; $i < count($streams); $i++): ?>

            <?php if ($i % 4 === 0): ?>
                <div class="centered">
            <?php endif; ?>

            <section class="streams">
                <a href="#"><img src="images/<?php echo $streams[$i]['stream_image']; ?>"
                                 alt="<?php echo $streams[$i]['stream_name']; ?>"
                                 title="<?php echo $streams[$i]['stream_name']; ?>">
                    <span class="course-title padded"><?php echo $streams[$i]['stream_name']; ?></span>
                    <span class="padded"><?php echo $streams[$i]['instructor_name']; ?></span></a>
            </section>

            <?php if ($i === count($streams) - 1 || $i > 0 && ($i + 1) % 4 === 0): ?>
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