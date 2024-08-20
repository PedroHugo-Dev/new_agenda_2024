<?php 
include('../../config/conexao.php');

    if(isset($_GET['idDel'])){
    $id = $_GET['idDel'];
    echo "<h1>$id</h1>";
    
    //Primeiro recupere o id do contato selecionado
    $select = "SELECT foto_contatos FROM tb_contatos WHERE id_contatos=:id";
    try{
        $result = $conect ->prepare($select);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        $result->execute();
        
        $contar = $result ->rowCount();
        if($contar > 0){
            $show = $result -> fetch(PDO::FETCH_OBJ);
            $foto = $show->foto_contatos;
        


        if($foto != 'avatar-padrao.png'){
            //caminho da imagem no servidor
            $filePath = "../../img/cont" . $foto;
            //apagar a imagem
            if(file_exists($filePath)){
                unlink($filePath);
            }
            
        }
        //agora deleta o registro no banco de dados
        $delete = "DELETE FROM tb_contatos WHERE id_contatos=:id";
        try {
            //code...
            $result = $conect -> prepare($delete);
            $result->bindValue(':id', $id, PDO::PARAM_INT);
            $result->execute();

            $contar = $result -> rowCount();
            if($contar > 0){
                header("Location: ../home.php");
            }else{
                header("Location: ../home.php");
            }
        } catch(PDOException $e){
            
        }
    } else {
        header("Location: ../home.php");
    }
        }catch(PDOException $e){
            echo "<strong>ERRO DE PDO</strong>";
    }
}
