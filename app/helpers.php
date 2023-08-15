<?php
function presentPrice(string $price)
{
    $formattedPrice=number_format(((float) $price/100) ,2,'.',',');
    return "$ ".$formattedPrice;
}
function setActiveCategory($category,$output = 'active'){
 return request()->category == $category? $output :'';
}

function productImage($path)
{   return $path && file_exists('storage/'.$path) ? asset('storage/'.$path) : asset('img/not-found.jpg') ;
}
