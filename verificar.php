<?php
echo "<pre>";
echo "Contenido de /var/www/html:\n";
print_r(scandir('/var/www/html'));

echo "\n\nContenido de /var/www/html/public:\n";
print_r(scandir('/var/www/html/public'));
echo "</pre>";