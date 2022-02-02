<?php 
if(!empty($aboutData['result'][0])){
    $aboutData = $aboutData['result'][0];
}
echo isset($aboutData->content_1)?$aboutData->content_1:'';
?>