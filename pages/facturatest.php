<?php
include 'connect.php';

if (isset($_GET['id'])) {
    $orderId = $_GET['id'];

    // Fetch order and client details
    $stmt = $con->prepare("SELECT c.oras, c.stradanr, cl.nume AS client_nume, cl.oras AS client_oras, cl.strada_nr, c.valoare, c.data_ex, cl.cif, c.cost_transport 
                           FROM comenzi c
                           JOIN clienti cl ON c.id_client = cl.client_id
                           WHERE c.idcomanda = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $stmt->bind_result($orderOras, $orderStradanr, $clientNume, $clientOras, $clientStradanr, $orderValoare, $orderDataEx, $cif, $cost_transport);
    $stmt->fetch();
    $stmt->close();

    // Fetch order items
    $stmt = $con->prepare("SELECT p.titlu, p.pret, con.cantitate 
                           FROM continut con
                           JOIN tablouri p ON con.id_comanda = ? AND con.id_produs = p.id_tablou");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();

    $orderItems = [];
    while ($row = $result->fetch_assoc()) {
        $orderItems[] = $row;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/favicon4.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon4.png">
  <title>
    Mirela Sofica
  </title>
      <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        .header-left {
            text-align: left;
        }
        .header-right {
            text-align: right;
        }
        .header h1 {
            margin: 0;
        }
        .details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .details .block {
            width: 48%;
            padding: 10px;
        }
        .details table {
            width: 100%;
            border-collapse: collapse;
        }
        .details td {
            padding: 5px;
        }
        .items, .total {
            width: 100%;
            margin-bottom: 20px;
        }
        .items table, .total table {
            width: 100%;
            border-collapse: collapse;
        }
        .items th, .items td, .total td {
            padding: 10px;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }
        .items th {
            background-color: #f2f2f2;
        }
        .total td {
            text-align: right;
        }
        .horizontal-line {
            width: 100%;
            border-bottom: 1px solid #000;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <br><br><br>
    <div class="container">
        <div class="header">
            <div class="header-left">
                <h1>FACTURA</h1>
                <p>Serie FMS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Numar <?php echo $orderId; ?></p>
                <p>Data: <?php echo date("d.m.Y", strtotime($orderDataEx)); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Scadent la: <?php echo date("d.m.Y", strtotime($orderDataEx)); ?></p>
            </div>
            <div class="header-right">
                <p>- RON -</p>
            </div>
        </div>
    <div class="details">
        <div class="block">
        <strong>FURNIZOR</strong>
        </div>
    
    
        <div class="block">
        <strong>CLIENT</strong>
         </div>
    </div>
    
    <div class="horizontal-line"></div>
        <div class="details">
            <div class="block">
                <strong>PFA SOFICA MIRELA</strong></br>
                <strong>CIF 41426985</strong>
                <p>RC F40/1610/2019</p>
                <p>BUCURESTI sect. 1 str. SOVEJA nr. 87</p>
                <p>BANCA TRANSILVANIA </br>RO66BTRLRONCRT0378915001</p>
                <p>COTA TVA = 0%</p>
            </div>
            <div class="block">
                <table>
                    <tr>
                        <td><strong><?php echo $clientNume; ?></strong></td>
                    
                    </tr>
                    <tr>
                        <?php if($cif>0) echo '
                        
                        <td>CIF &nbsp&nbsp&nbsp'.$cif.'</td>'
                        ?>
                        
                    </tr>
                    <tr>
                        <td><?php echo strtoupper($clientOras); ?>,<?php echo strtoupper($clientStradanr); ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="horizontal-line"></div>
        <div class="items">
            <table>
                <thead>
                    <tr>
                        <th>Nr. crt.</th>
                        <th>Denumire produs</th>
                        <th>Cantitate</th>
                        <th>Pret unitar</th>
                        <th>Valoare</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
/*                    $nrCrt = 1;
                    foreach ($orderItems as $item) {
                        $totalValue = $item['pret'] * $item['cantitate'];
                        echo "<tr>";
                        echo "<td>{$nrCrt}</td>";
                        echo "<td>{$item['titlu']}</td>";
                        echo "<td>{$item['cantitate']}</td>";
                        echo "<td>" . number_format($item['pret'], 2) . "</td>";
                        echo "<td>" . number_format($totalValue, 2) . "</td>";
                        echo "</tr>";
                        $nrCrt++;
                    }*/
                    $nrCrt = 1;

                    $sql="SELECT * FROM continut WHERE id_comanda = $orderId";
                    $result=mysqli_query($con,$sql);
                    if($result){
                        
                        while($row=mysqli_fetch_assoc($result)){
                            $tip=$row['tip'];
                            $idprodus=$row['id_produs'];
                            $cantitate=$row['cantitate'];



                            if($tip=='tablou'){
                            $sql2="SELECT * FROM tablouri WHERE id_tablou = $idprodus ";
                            $result2=mysqli_query($con,$sql2);
                            $row2=mysqli_fetch_assoc($result2);

                                $nume=$row2['titlu'];
                                $pret=$row2['pret'];
                                $totalvaloare=$pret*$cantitate;

                            }


                            if($tip=='handmade')
                            {
                                $sql2="SELECT * FROM produse WHERE cod_produs = $idprodus ";
                                $result2=mysqli_query($con,$sql2);
                                $row2=mysqli_fetch_assoc($result2); 
    
                                    $nume=$row2['nume'];
                                    $pret=$row2['pret'];
                                    $totalvaloare=$pret*$cantitate;
                            }


                            echo "<tr>";
                        echo "<td>{$nrCrt}</td>";
                        echo "<td>{$nume}</td>";
                        echo "<td>{$cantitate}</td>";
                        echo "<td>" . number_format($pret, 2) . "</td>";
                        echo "<td>" . number_format($totalvaloare, 2) . "</td>";
                        echo "</tr>";


                            $nrCrt++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="total">
            <table>
                <tr>
                    <td><strong>Total:</strong></td>
                    <td><?php echo number_format($orderValoare, 2); ?></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
