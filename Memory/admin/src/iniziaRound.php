<?php
    ob_start();
    session_start();
    require "../../sql/config.php";
    $_SESSION["roundInCorso"]=true;
    
    if(!isset($_SESSION["n_round"])){
        $_SESSION["n_round"]=1;
    }else{
        $_SESSION["n_round"]+=1;
    }   

    $connessione->query("delete from round where nome_stanza='$_SESSION[nomeStanza]'") or die("errore nell'eliminazione del round");
    //echo "insert into round ('$_SESSION[nomeStanza]', $_SESSION[n_round], '$time', 1, ".scegli_immagine()." )";
    $connessione->query("insert into round values('$_SESSION[nomeStanza]', $_SESSION[n_round], utc_time(), 1, ".scegli_immagine()." )") or die("errore nella creazione del round");


    header('Location: ./admin.php');

    //far si che vendga creato il round per la stanza dentro la sessione
    //$connessione->query("insert into ")


    function scegli_immagine(){
        $imgIndex=mysqli_fetch_all($GLOBALS["connessione"]->query("select imgIndex from img_stanza where nome_stanza='$_SESSION[nomeStanza]' and usata=0 order by rand() limit 1"))[0][0];
        $GLOBALS["connessione"]->query("update img_stanza set usata=1 where imgIndex=$imgIndex and nome_stanza='$_SESSION[nomeStanza]'");
        return $imgIndex;
    }
    ob_end_flush();
?>