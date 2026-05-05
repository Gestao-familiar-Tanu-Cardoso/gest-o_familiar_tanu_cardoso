<?php
include "../conexao.php";

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="familia.csv"');

$out = fopen('php://output', 'w');

fputcsv($out, ['Nome','Nascimento','Sexo']);

$res = $conn->query("SELECT * FROM pessoas");

while($r = $res->fetch_assoc()){
    fputcsv($out, [$r['nome'],$r['data_nascimento'],$r['sexo']]);
}

fclose($out);