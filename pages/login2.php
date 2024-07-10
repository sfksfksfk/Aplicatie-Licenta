
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'] ;

    if ($name === 'mirela' && $password === '1234') {
      
        header('Location: dashboard.php');
      
    } 
    else{

        header('Location: ../index.html');
    }
} 

?>