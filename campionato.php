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
        function calendario()
        {
            window.location.href='http://localhost/capolavoro/calendario.php?campionato='+<?php echo $_GET["campionato"]  ?>;
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
                    echo 'Classifica '.$row["nome"];

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
    <div class="div2"><button  name="ordine" onclick="calendario()">calendario</button></div>

    </div>




    <div class="riga">
    <form action=""  method="post">
        <div class="div1">  <button type="submit" name="ordine" value="nome">nome</button> </div>
        <div class="div2">    <button type="submit" name="ordine" value="punti">punti</button> </div>
        <div class="div3">    <button type="submit" name="ordine" value="gol_fatti">gol fatti</button> </div>
        <div class="div4">    <button type="submit" name="ordine" value="gol_subiti">gol subiti</button> </div>
        
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
                if(isset($_POST["ordine"]))
                {
                    
                    $ordine=$_POST["ordine"];
                    
                    $sql = "SELECT * FROM squadra where id_campionato=$campionato order by $ordine DESC;";
                }
                else
                {
                    $sql = "SELECT * FROM squadra where id_campionato=$campionato ";
                }
                    




                
                $result = $conn->query($sql);
            


                //echo '<form method="post" action="campionato.php>'


                // Controllo e visualizzazione dei risultati
                if ($result->num_rows > 0) 
                {
                    // Uscita dei dati di ogni riga

                    $pos=1;
                    while($row = $result->fetch_assoc()) 
                    {

                        
                        echo '<div class="riga" > ';
                        echo '<div class="div">'.$pos.'</div>';
                        echo '<div class="div1">'. $row["nome"].'</div>';
                        echo '<div class="div2">'. $row["punti"].'</div>';
                        echo '<div class="div3">'. $row["gol_fatti"].'</div>';
                        echo '<div class="div4">'. $row["gol_subiti"].'</div>';
                        echo '</div>';
                        $pos+=1;
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