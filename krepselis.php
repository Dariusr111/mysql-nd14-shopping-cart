<?php

include("db.php");
include("imag_url.php");
//Prekių sąrašas
$sql = "SELECT * FROM store";
//pstm - pre-statement
$pstm = $pdo->prepare($sql);
$pstm->execute();
$items = $pstm->fetchAll(PDO::FETCH_ASSOC);

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
            <form action="" method="POST">
                <button class="navbar-brand btn btn-warning ms-5 mt-2 ps-3 pe-3">PIRKTI</button>
            </form>
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