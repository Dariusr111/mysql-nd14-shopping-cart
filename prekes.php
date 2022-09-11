<?php
include("db.php");
include("imag_url.php");
//Prekių sąrašas
$sql = "SELECT * FROM store";
//pstm - pre-statement
$pstm = $pdo->prepare($sql);
$pstm->execute();
$items = $pstm->fetchAll(PDO::FETCH_ASSOC);
//Į krepšelį
if (isset($_POST['action']) && $_POST['action']=='insert'){
   try{
       
      //  $sql= INSERT INTO cart (id, name, description, quantity, category, price, units, state) VALUES ('$item['id']', '$item['name']', '$item['description']', '$item['quantity']', '$item['category']', '$item['price']', '$item['units']', '$item['state']');
       $stm=$pdo->prepare($sql);
       $stm->execute([ $_POST['id'], $_POST['name'], $_POST['description'], $_POST['quantity'], $_POST['category'], $_POST['price'], $_POST['units'], $_POST['state']]);
       header("location:statistika.php");
       die();
   }catch(Exception $e){
       
       $klaida="Įvyko klaida: ".$e->getMessage();
   }
 }

session_start();

// if counter is not set, set to zero
if(!isset($_SESSION['counter'])) {
    $_SESSION['counter'] = 0;
}

// if button is pressed, increment counter
if(isset($_POST['button'])) {
    ++$_SESSION['counter'];
}    

// reset counter
if(isset($_POST['reset'])) {
    $_SESSION['counter'] = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Prekių sąrašas</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
   <style>
      .nowrap {
         white-space: nowrap;
         color: black;
      }
      .fix{
         position: fixed;
         top: 0px;
         z-index: 99;
         width: 100%;
      }
      .margin{
         margin-top: 80px;
      }
   </style>
</head>

<body>

   <nav class="navbar navbar-expand-lg mb-3 fix" style="background-color: #c3e49a;">
      <div class="container-fluid">
         <form action="krepselis.php" method="POST">
            <a class="navbar-brand btn btn-warning ms-5 mt-2 ps-3" href="krepselis.php">Eiti į krepšelį</a>
            <a class="navbar-brand ms-5 ps-2" href="krepselis.php">
               <img src="images/cart.svg" alt="" width="50" height="50" class="d-inline-block align-text-top">
            </a>
         </form>
         <form action="" method="POST">
            <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
               <li>
                  <h1 class="ms-5 mt-2"><?php echo $_SESSION['counter']; ?></h1>
               </li>
               <li>
                 <input type="submit" name="reset" class="navbar-brand btn btn-danger ms-5 ps-3 mt-3 pt-1" value="Pašalinti" />
               </li>
            </ul>
         </form> 
         <div class="d-flex pe-3" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success float-end" type="submit">Search</button>
         </div>
      </div>
   </nav>


   <!-- Prekiu sąrašas -->
   <div class="container-fluid margin">
      <div class="card mt-5 mb-3">

         <?php if (count($items) > 0) :
            $i = 1;
         ?>
  
            <form method="POST" action="#error-check" id="error-check">
               <div class="card-body">
                  <h5 class="card-header bg-light nowrap">Prekių sąrašas:</h5>
                  <table class="table table-striped table-hover mb-3">
                     <thead>
                        <tr>
                           <td><strong>ID</strong></td>
                           <td><strong>Pavadinimas</strong></td>
                           <td><strong>Aprašymas</strong></td>
                           <td><strong>Kiekis</strong></td>
                           <td><strong>Kategorija</strong></td>
                           <td><strong>Kaina<br>(EUR)</strong></td>
                           <td><strong>Vienetai</strong></td>
                           <td><strong>Būsena</strong></td>
                           <td><strong>Paveikslėlis</strong></td>
                        </tr>
                     </thead>
                     <tbody>
                        <?php foreach ($items as $item) { ?>
                           <tr>
                              <td><?= $item['id'] ?></td>
                              <td><?= $item['name'] ?></td>
                              <td><?= $item['description'] ?></td>
                              <td><?= $item['quantity'] ?></td>
                              <td><?= $item['category'] ?></td>
                              <td><?= ($item['price']) / 100 ?></td>
                              <td><?= $item['units'] ?></td>
                              <td><?= $item['state'] ?></td>
                              <td><img src="<?php echo $images[$item['id']] ?>" alt="" width="120" height="90"></td>
                              <td><input type="submit" name="button" class="btn btn-success nowrap mt-4" value="Į krepšelį"></a></td>
                           <?php } ?>
                           </tr>
                     </tbody>
                  </table>
               </div>
            </form>
         <?php endif; ?>
      </div>
   </div>
  

</body>

</html>