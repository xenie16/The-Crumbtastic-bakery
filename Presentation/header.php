<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?= $tabTitle ?> | The Crumbtastic bakery</title>

   <link rel="icon" type="image/x-icon" href="Presentation\img\favicon.ico">
   <link rel="stylesheet" href="Presentation\CSS\reset.css">
   <link rel="stylesheet" href="Presentation\CSS\style.css">
   <link rel="stylesheet" href="Presentation\CSS\<?= $specificStyling ?>.css">
   <link rel="stylesheet" href="Presentation\CSS\footer.css">
</head>

<body>
   <div class="wrapper">
      <header>
         <nav>
            <a href="index.php"><img id="logo" src="Presentation\img\logo.png" alt="logo"></a>
            <section>
               <ul>
                  <?php foreach ($navLinks as $key => $value) { ?>
                     <li><a href="<?= $value ?>"><?= $key ?></a></li>
                  <?php } ?>
               </ul>
               <a href="basket.php"><button>Basket</button></a>
            </section>
         </nav>