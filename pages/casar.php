<?php include "../conexao.php"; ?>
<?php include "../partials/header.php"; ?>
<?php include "../partials/sidebar.php"; ?>

<div class="card">
<h3>Casar Pessoas</h3>

<form method="POST">

Pessoa 1:<br>
<select name="p1">
<?php
$res=$conn->query("SELECT id,nome FROM pessoas");
while($r=$res->fetch_assoc()){
echo "<option value='{$r['id']}'>{$r['nome']}</option>";
}
?>
</select><br><br>

Pessoa 2:<br>
<select name="p2">
<?php
$res=$conn->query("SELECT id,nome FROM pessoas");
while($r=$res->fetch_assoc()){
echo "<option value='{$r['id']}'>{$r['nome']}</option>";
}
?>
</select><br><br>

<button>Casar</button>
</form>

<?php
if($_POST){

$p1=$_POST["p1"];
$p2=$_POST["p2"];

$conn->query("UPDATE pessoas SET id_conjuge=$p2 WHERE id=$p1");
$conn->query("UPDATE pessoas SET id_conjuge=$p1 WHERE id=$p2");

echo "<p style='color:green;'>Casamento registado!</p>";
}
?>

</div>

<?php include "../partials/footer.php"; ?>