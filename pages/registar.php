<?php include "../conexao.php"; ?>
<?php include "../partials/header.php"; ?>
<?php include "../partials/sidebar.php"; ?>

<div class="card">
<h3>Registar Pessoa</h3>

<form method="POST" enctype="multipart/form-data">

Nome:<br>
<input type="text" name="nome"><br><br>

Data de Nascimento:<br>
<input type="date" name="data"><br><br>

Sexo:<br>
<select name="sexo">
<option value="M">Masculino</option>
<option value="F">Feminino</option>
</select><br><br>

Pai:<br>
<select name="pai">
<option value="">Nenhum</option>
<?php
$res = $conn->query("SELECT id,nome FROM pessoas");
while($r = $res->fetch_assoc()){
echo "<option value='{$r['id']}'>{$r['nome']}</option>";
}
?>
</select><br><br>

Mãe:<br>
<select name="mae">
<option value="">Nenhuma</option>
<?php
$res = $conn->query("SELECT id,nome FROM pessoas");
while($r = $res->fetch_assoc()){
echo "<option value='{$r['id']}'>{$r['nome']}</option>";
}
?>
</select><br><br>

Foto:<br>
<input type="file" name="foto"><br><br>

ID da Família:<br>
<input type="number" name="familia"><br><br>

<button>Guardar</button>

</form>

<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){

$nome = $_POST["nome"];
$data = $_POST["data"];
$sexo = $_POST["sexo"];
$pai = $_POST["pai"] ?: "NULL";
$mae = $_POST["mae"] ?: "NULL";
$familia = $_POST["familia"] ?: "NULL";

// 📸 TRATAR FOTO
$foto_nome = "";

if(!empty($_FILES['foto']['name'])){

    $foto_nome = time() . "_" . $_FILES['foto']['name'];

    move_uploaded_file(
        $_FILES['foto']['tmp_name'],
        "../assets/img/" . $foto_nome
    );
}

// 🔴 VALIDAÇÃO
if(empty($nome) || empty($data)){
    echo "<p style='color:red;'>Preencha os campos obrigatórios!</p>";
} else {

    $sql = "INSERT INTO pessoas
    (nome,data_nascimento,sexo,id_pai,id_mae,foto,id_familia)
    VALUES
    ('$nome','$data','$sexo',$pai,$mae,'$foto_nome',$familia)";

    if($conn->query($sql)){
        echo "<p style='color:green;'>Pessoa registada com sucesso!</p>";
    } else {
        echo "<p style='color:red;'>Erro: ".$conn->error."</p>";
    }
}

}
?>

</div>

<?php include "../partials/footer.php"; ?>