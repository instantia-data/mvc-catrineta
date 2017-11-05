<?php 

/**
* 
*/
return [
    {@while ($item in columns):}'{$item.colname}'=>'{$item.translation}',
    {@endwhile;}
];
