<?php include "../conexao.php"; ?>
<?php include "../partials/header.php"; ?>
<?php include "../partials/sidebar.php"; ?>

<div class="card">
<h3>Estatísticas</h3>

<?php

$c = $conn->query("SELECT COUNT(*) t FROM pessoas WHERE TIMESTAMPDIFF(YEAR,data_nascimento,CURDATE())<18")->fetch_assoc()['t'];

$i = $conn->query("SELECT COUNT(*) t FROM pessoas WHERE TIMESTAMPDIFF(YEAR,data_nascimento,CURDATE())>65")->fetch_assoc()['t'];

$a = $conn->query("SELECT COUNT(*) t FROM pessoas WHERE TIMESTAMPDIFF(YEAR,data_nascimento,CURDATE()) BETWEEN 18 AND 65")->fetch_assoc()['t'];

$taxa = ($a>0) ? round(($c+$i)/$a,2) : 0;

echo "Crianças: $c <br>";
echo "Idosos: $i <br>";
echo "Activos: $a <br>";
echo "Taxa: $taxa";
?>

</div>

<?php include "../partials/footer.php"; ?>