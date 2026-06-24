<?php
$mapsHtml = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!3d-5.426800689262991!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e47239bdda912d7%3A0x815b631e86b8749a!2sMIN%202%20Tanggamus!5e0!3m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';

if (preg_match('/<iframe[^>]+src=["\'](https?:\/\/[^"\']+\.google\.[^"\']+maps[^"\']*)["\'][^>]*><\/iframe>/i', $mapsHtml, $m)) {
    echo "Match! URL: " . $m[1] . "\n";
} else {
    echo "No match!\n";
}
