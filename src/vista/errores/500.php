<h1>Error interno</h1>

<?php
$id = $_GET && isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : '';
switch ($id) {
    case 'vista-no-existe':
        echo "<p>No se ha especificado ninguna vista.</p>";
        break;
    default:
        echo "<p>Error interno desconocido.</p>";
        break;
}
