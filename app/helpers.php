<?php
function presentPrice($price)
{

     $formattedPrice=number_format(((float) $price/100),2,'.',',');

    return "$ ".$formattedPrice;
}
