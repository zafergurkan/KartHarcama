<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Aylık Kredi Kartı Harcamalarımız</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jumbotron.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<?php require_once("baglan.php"); ?>
<body>
    <div class="col-md-2"></div>
    <div class="container col-md-8">
        <form id="harcamaForm" onsubmit="return isValidForm()" class="form-inline" name="odemeForm">
            <div class="form-group">
                <label for="exampleInputName2">Mağaza Adı</label>
                <input type="text" class="form-control" name="magazaAdi" id="magazaAdi" placeholder="Mağaza adını giriniz..">
            </div>
            <div class="form-group">
                <label for="exampleInputName2">Tarih</label>
                <input type="date" class="form-control" name="tarih" id="tarih" placeholder="Tarih">
            </div>
            <div class="form-group">
                <label class="sr-only" for="exampleInputAmount">Ödeme (TL)</label>
                <div class="input-group">
                    <div class="input-group-addon">₺</div>
                    <input type="text" class="form-control" name="odeme" id="odeme" placeholder="Ödeme">
                </div>
            </div>
            <button type="submit" class="btn btn-primary" onclick="kaydet()">Kaydet</button>
        </form>
        <span id="hataMesajı"></span>
        <div id="harcamaTablosu" style="margin-top:50px;">
       <table class="table table-hover ">
  <th class="success">Mağaza Adı</th>
  <th class="warning">Tarih</th>
  <th class="danger">Ödeme</th>
  <th class="active">İşlemler</th>

<!-- On cells (`td` or `th`) -->
<?php

$tarihSorgu=$mysqli->query("SELECT DATEDIFF((select max(Tarih) from harcama),(select min(Tarih) from harcama)) AS DiffDate");
$tarihKayit=mysqli_fetch_array($tarihSorgu);

$sorgu = $mysqli->query("SELECT * FROM harcama ORDER BY Tarih");
while($kayit=mysqli_fetch_array($sorgu)){
$i=0;
echo '<tr>';
echo '<td class="success">'.$kayit["MagazaAdi"].'</td>';
echo '<td class="warning">'.$kayit["Tarih"].'</td>';
echo '<td class="danger">'.$kayit["Odeme"].' ₺ </td>';
echo '<td class="active">
<button id="silButonu"  type="submit" class="btn btn-danger glyphicon glyphicon-remove"  onclick="sil('.$kayit["HarcamaID"].')" aria-hidden="true"></button></td>';
}
?>
<tr>
<td colspan="4" class="bg-primary text-center">
<h4>
<?php 
    $toplam = $mysqli->query("SELECT SUM(Odeme) AS OdemeToplam FROM harcama;");
    $sonuc=mysqli_fetch_array($toplam);
    echo $tarihKayit["DiffDate"].' Günde Harcanan Tutar : '.$sonuc["OdemeToplam"].'₺';
?></h4>
</td>

</tr>

</table>
  </div> 
  
    </div>
    <div class="col-md-2"></div>
    <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
        window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')
    </script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    <script type=text/javascript>
    if (window.XMLHttpRequest)
        {
	        istek = new XMLHttpRequest();
        }
    else if (window.ActiveXObject)
        {
	        istek = new ActiveXObject("Microsoft.XMLHTTP");
        }
     function kaydet(){
         var magazaAdi = document.getElementById("magazaAdi").value;
         var tarih=document.getElementById("tarih").value;
         var odeme=document.getElementById("odeme").value;
         if(magazaAdi==""&&tarih==""&&odeme==""){
             document.getElementById('harcamaForm').onsubmit = function() {
    return false;
};
             document.getElementById("hataMesajı").innerHTML = "<h4>Tüm Alanlar Dolu Olmalı</h4>";
             document.getElementById("hataMesajı").className = "text-center";
         }
         else{
         
         istek.open("GET", "kaydet.php?magazaAdi="+magazaAdi+"&tarih="+tarih+"&odeme="+odeme, true);
	     istek.onreadystatechange = verileriAl;
	     istek.send(null);
         }
     }
     function verileriAl() {
	if (istek.readyState == 4 && istek.status == 200)
	{
		var cevap = istek.responseText;
       
	}
}   
    function sil(id){
        istek.open("GET","sil.php?ID="+id,true);
        istek.onreadystatechange = verileriAl;
        istek.send(null);
        window.location.reload();
    }
    </script>
</body>

</html>
