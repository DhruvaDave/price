
 <?php  error_reporting(0);  ?>
<!DOCTYPE html>
<html>
<title>Price</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<body>

<header class="w3-container w3-teal">
  <h1>Price comapre site</h1>
</header>

<div class="w3-container">

<form class="w3-container w3-card-4" action="price.php" method="get">

<h2>Input Form</h2>

<p>
<input class="w3-input" name="searchdata" type="text" required>
<label class="w3-label w3-validate">Search</label></p>

<p>
<input id="search" class="w3-input" type="submit" value="search" />

<div class="w3-card-2"></div>



</form>


<?php

if(isset($_GET['searchdata']))
{

$search = $_GET['searchdata'];
$search = strtolower($search);

$search = str_replace(" ","+",$search);
$web_page_data=file_get_contents("http://www.pricetree.com/search.aspx?q=".$search);

echo "-------------------------------------------------------------";

$item_list = explode('<div class="items-wrap">',$web_page_data);

$i=1;
if(sizeof($item_list)<2)
{
  echo "No Product Availble";
}
$count=4;

for($i=0;$i<5;$i++)
{
   //echo $item_list[$i];
   
   $url_link1 = explode('href="',$item_list[$i]);
	   $url_link2 = explode('"',$url_link1[1]);
   //echo $url_link2[0]."</br>";
   
   $image_link1 = explode('data-original="',$item_list[$i]);
   $image_link2 = explode('"',$image_link1[1]);
   //echo $image_link2[0]."<br>";
   
   $title1 = explode('title="',$item_list[$i]);
   $title2 = explode('"',$title1[0]);
   
   $available1 = explode('smooth-p-style>"', $item_list[$i]);
   $available = explode('</div>',$available1[0]);
   /*if(strcmp($available[0],"Not available"))
   {
       $count = $count-1;
       continue;
   }*/
   
   
   $item_title = $title2[0];
   if(strlen($item_title)<2)
   {
        continue;
   }
   $item_link = $url_link2[0];
   $item_image_link = $image_link2[0];
  $item_id1 = explode("-",$item_link);
   $item_id = end($item_id1);
   echo $item_id;
   
   echo '
    <div class="w3-container">
   <div class="w3-row">
   <div class="w3-col l2 w3-row-padding">
   <div class="w3-card-2" style="background-color:teal;color=while;">
  <!--<div class="w3-image">-->
  <img src="'.$item_image_link.'"  style="width:100%">
  <h5> '.$item_title.' </h5>
  <!--<div class="w3-title w3-text-black">Nice Car</div>-->
</div>

<!--*<div class="w3-container">
 
   <div class="w3-center w3-grey">  
<img src="'.$item_image_link.'" class="w3-circle" style="width:100%">
</div>

<div class="w3-container">
<h5> '.$item_title.' </h5>

--> </div>
 </div>
 </div>
 </div>
 ';
   //echo $item_title."<br>";
   //echo $item_link."</br>";
  // echo $item_image_link."</br>";
   //echo $item_id."</br>"; 
   
   $request = "http://www.pricetree.com/dev/api.ashx?pricetreeId=".$item_id."&apikey=7770AD31-382F-4D32-8C36-3743C0271699";
$response = file_get_contents($request);
$results = json_decode($response, TRUE);
   
   
  /* $request = "http://www.pricetree.com/dev/api.ashx?pricetreeId=".$item_id."&apikey=7770AD31-382F-4D32-8C36-3743C0271699";
  $response = file_get_contents($request);
  $results = json_decode($response, TRUE);*/
  //print_r($results);
  
  //echo "------------------------";
  //echo $results['count'];
  echo '
	 <table class="w3-table w3-striped w3-border">
<thead>
<tr class="w3-red">
  <th>Seller</th>
  <th>Price</th>
  <th>Buy</th>
</tr>
</thead>
';
  foreach($results['data'] as $itemdata)
  {
     $seller = $itemdata['Seller_Name'];
	 $price =  $itemdata['Best_Price'];
	 $product_link = $itemdata['Uri'];
	 
	 //echo $seller.",".$price.",".$product_link."</br>";
	 echo '
	 <tr>
	 <td> '.$seller.' </td>
	 <td>'.$price.'</td>
	 <td> <a href="'.$product_link.'"> Buy </a> </td>
	 </tr>
	 
	 ';
  }
   
   echo '
   </table>

	 ';
}	

 if($count == 0)
 {
 
   echo "no product available"."<br>";
 }   
}
	 else
	 {
	         echo "use this to get best price form all sites";
	 }


?>


</div>
</div>
<footer class="w3-container w3-teal w3-opacity">

<p> copyright @ Dhruva</p>
</footer>

</body>
</html> 
