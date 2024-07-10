<?php
include 'connect.php';

// Fetch all produse and their stoc
$query = "SELECT nume, stoc, poza FROM produse";
$result = $con->query($query);

if ($result->num_rows > 0) {
    // Start of the HTML document
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        
  <link rel="icon" type="image/png" href="../assets/img/favicon4.png">
        <title>Fisa De Stoc Produse</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }
            .container {
                width: 100%;
                max-width: 800px;
                margin: auto;
                padding: 20px;
                background-color: #ffffff;
                border: 1px solid #ddd;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                page-break-inside: avoid;
            }
            .header {
                text-align: center;
                margin-bottom: 20px;
            }
            h1 {
                font-size: 24px;
                margin-bottom: 10px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
            .footer {
                text-align: center;
                font-size: 12px;
                color: #666;
                margin-top: 20px;
            }
            .produs-img {
                width: 50px;
                height: auto;
                display: block;
            }
            @media print {
                .container {
                    border: none;
                    box-shadow: none;
                }
                .footer {
                    page-break-after: always;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Fisa De Stoc Produse</h1>
                <p>Lista cu stocul actual pentru toate produsele</p>
            </div>
            <table>
                <tr>
                    <th>Denumire Produs</th>
                    <th>Imagine</th>
                    <th>Stoc</th>
                </tr>';
                
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo '<tr>
                        <td>' . $row["nume"] . '</td>
                        <td><img class="produs-img" src="../media/poze_produse/' . $row["poza"] . '" alt="' . $row["nume"] . '"></td>
                        <td>' . $row["stoc"] . '</td>
                    </tr>';
                }
                
    echo '  </table>
            <div class="footer">
                <p>&copy; ' . date("Y") . ' Mirela Sofica ART. Toate drepturile rezervate.</p>
            </div>
        </div>
    </body>
    </html>';
} else {
    echo "0 results";
}
$con->close();
?>
