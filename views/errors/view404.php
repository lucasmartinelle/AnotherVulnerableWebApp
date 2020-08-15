<?php
    $asset = "assets/";
    $idPage = "page404";
    ob_start();
?>

<div class="container-fluid h-100 w-100">
    <h1 class="text-white h1 text-center">404 - Page introuvable</h1>
</div>

<?php $content = ob_get_clean(); ?>