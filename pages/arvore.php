<?php include "../conexao.php"; ?>
<?php include "../partials/header.php"; ?>
<?php include "../partials/sidebar.php"; ?>

<div class="card">
<h3>Árvore Genealógica</h3>

<?php

function mostrarFilhos($conn, $id){
    $res = $conn->query("SELECT * FROM pessoas WHERE id_pai=$id OR id_mae=$id");

    while($r = $res->fetch_assoc()){
        echo "<ul><li>".$r['nome']."</li></ul>";
        mostrarFilhos($conn, $r['id']);
    }
}

$res = $conn->query("SELECT * FROM pessoas WHERE id_pai IS NULL AND id_mae IS NULL");

while($p = $res->fetch_assoc()){
    echo "<b>".$p['nome']."</b>";
    mostrarFilhos($conn, $p['id']);
}
?>

</div>

<?php include "../partials/footer.php"; ?>