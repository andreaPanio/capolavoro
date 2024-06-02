<!DOCTYPE html>
<html>
    <header>
    <link rel="stylesheet" href="calcio.css" type="text/css">
    </header>

    <script>
       
       function torna()
        {
            window.location.href='http://localhost/capolavoro';
        }
        function classifica()
        {
            window.location.href='http://localhost/capolavoro/campionato.php?campionato='+<?php echo $_GET["campionato"]  ?>;
        }


    </script>






    <body>


    <div class="riga">

    <div class="div1"><button name="ordine" onclick="torna()">torna al menù</button></div>
    <div class="div1">






    <?php

        $conn=new mysqli("localhost","root","","tabelle_calcio");
        if($conn->connect_error)
        {
            die("Connection failed:".
            $conn->connect_error);

        }
        else
        {
            $campionato=$_GET["campionato"];
            $sql = "SELECT * FROM campionato where id=$campionato limit 1;";
            $result = $conn->query($sql);

            // Controllo e visualizzazione dei risultati
            if ($result->num_rows > 0) 
            {
                while($row = $result->fetch_assoc()) 
                {
                    echo 'Calendario '.$row["nome"];

                }
            } 
            else 
            {
                echo "0 risultati";
            }

            // Chiusura della connessione
            $conn->close();
        }
?>





    </div>
    <div class="div2"><button  name="ordine" onclick="classifica()">classifica</button></div>

    </div>




    <div class="riga3">
    <form action=""  method="post">

    <label for="giornata">Seleziona la Giornata:</label>
        <select name="giornata" id="giornata">
            <!-- Genera le opzioni da 1 a 38 -->
            <option value="all">Completo</option>
            <?php for ($i = 1; $i <= 38; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select>
        <button type="submit">Invia</button>


    </form>
    </div>














    <?php
        if(isset($_GET["campionato"]))
        {
            $campionato=$_GET["campionato"];






            $conn=new mysqli("localhost","root","","tabelle_calcio");
            if($conn->connect_error)
            {
                die("Connection failed:".
                $conn->connect_error);
            
            }
            else
            {
                if(!isset($_POST["giornata"]) || $_POST["giornata"]=="all")
                {


                    $sql = "SELECT 
                    squadracasa.nome AS squadra_casa,
                    squadratrasferta.nome AS squadra_trasferta,
                    partita.gol_casa,
                    partita.gol_trasferta,
                    partita.data_partita,
                    partita.giornata
                    FROM 
                    partita
                    JOIN 
                    campionato ON partita.id_campionato = campionato.id
                    JOIN 
                    squadra AS squadracasa ON partita.id_casa = squadracasa.id
                    JOIN 
                    squadra AS squadratrasferta ON partita.id_trasferta = squadratrasferta.id
                    WHERE 
                    partita.id_campionato = $campionato
                    ORDER BY 
                    partita.giornata ASC";
                }
                else 
                {
                                        
                    $giornata=$_POST["giornata"];
                    
                    $sql = "SELECT 
                    squadracasa.nome as squadra_casa ,
                    gol_casa,gol_trasferta,
                    squadratrasferta.nome as squadra_trasferta,
                    partita.data_partita,
                    partita.giornata   
                    FROM 
                    partita,
                    campionato,
                    squadra as squadracasa,
                    squadra as squadratrasferta 
                    where 
                    partita.id_campionato=$campionato AND 
                    giornata=$giornata AND 
                    id_casa=squadracasa.id and 
                    id_trasferta=squadratrasferta.id 
                    group by squadracasa.nome";
                }
                    




                
                $result = $conn->query($sql);
            


                //echo '<form method="post" action="campionato.php>'


                // Controllo e visualizzazione dei risultati
                if ($result->num_rows > 0) 
                {
                    // Uscita dei dati di ogni riga
                    if(!isset($_POST["giornata"]) || $_POST["giornata"]=="all")
                    {
                        $giornata=1;
                        echo '<div class="riga2"><div class="giornata"> giornata    '.$giornata.' </div></div>';
                    }
                    else{
                        $giornata=$_POST["giornata"];
                        echo '<div class="riga2"><div class="giornata"> giornata    '.$giornata.' </div></div>';
                    }
                            
                    while($row = $result->fetch_assoc()) 
                    {
                        if((!isset($_POST["giornata"]) || $_POST["giornata"]=="all")&&$giornata!=$row["giornata"])
                        {
                            $giornata=$row["giornata"];
                            echo '<div class="riga2"><div class="giornata"> giornata    '.$giornata.' </div></div>';
                        }
                        
                        
                        echo '<div class="riga" >';


                        echo '<div class="div5">'. $row["squadra_casa"].'</div>';
                        echo '<div class="div5">'.$row["gol_casa"].'</div>';
                        echo '<div class="div5"> - </div>';
                        echo '<div class="div5">'. $row["gol_trasferta"]. '</div>';
                        echo '<div class="div5">'. $row["squadra_trasferta"].'</div>';
                        
                        
                        echo '</div>';
                        
                    }
                    
                    //echo '</form>'
                } 
                else 
                {
                    echo "0 risultati";
                }
            
                // Chiusura della connessione
                $conn->close();
            }




        }
    ?>





    </body>
    
</html>