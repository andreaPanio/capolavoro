<!DOCTYPE html>
<html>
    <header>
    <link rel="stylesheet" href="calcio.css" type="text/css">
    </header>

    <script>
        function apricampionato(x)
        {
            window.location.href='http://localhost/capolavoro/campionato.php?campionato='+x;
        }




    </script>






    <body>
<?php

$conn=new mysqli("localhost","root","","tabelle_calcio");
if($conn->connect_error)
{
    die("Connection failed:".
    $conn->connect_error);

}
else
{
    $sql = "SELECT * FROM campionato";
    $result = $conn->query($sql);

    // Controllo e visualizzazione dei risultati
    if ($result->num_rows > 0) 
    {
        // Uscita dei dati di ogni riga
        echo '<form class="campionati" > ';
        while($row = $result->fetch_assoc()) 
        {

            echo '<div class="campionato" onclick="apricampionato('.$row["id"].')">';
            echo '<h1>'.$row["nome"]. "</h1><br> Nazione: " . $row["nazione"]."<br> <h4> Federazione:". $row["federazione"]. "</h4><br>";
            echo '';
            echo '</div>';

        }
        echo '</div> <br>';
    } 
    else 
    {
        echo "0 risultati";
    }

    // Chiusura della connessione
    $conn->close();
}
?>








    </body>
    
</html>