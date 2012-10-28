<?php

echo '<ul>';
chdir(dirname(__FILE__));
foreach (glob("*.php") as $file) {
    if ($file != "index.php") {
        echo '<li><a href="../?lists=', basename(dirname($_SERVER['SCRIPT_NAME'])), '/', $file, '" target="_blank">', $file, '</a></li>';
    }
}
echo '</ul>';