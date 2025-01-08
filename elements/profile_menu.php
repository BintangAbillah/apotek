<?php
header('Content-Type: application/json');

$menu = [
    ['label' => 'Profile', 'link' => './profile.php'],
    ['label' => 'Logout', 'link' => '/apotek/includes/auth.php?action=logout'],
];

echo json_encode($menu);
?>
