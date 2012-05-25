<?php
include("../../include.php");

echo drawTop("Dear Mme.");

?>
<div class="left">
<i>Dear Mme.</i>, was created in collaboration with The Kronos Quartet as a commission to open the 25th Anniversary of The Next Wave Festival at B.A.M.   
Created and directed by Jessica Grindstaff and Erik Sanko of Phantom Limb, the piece involved a 15 foot puppet (the writer) made from recycled barn lumber that had a 
marionette stage behind barn doors built into the large puppet.  Three scenarios played out inside the heart of the writer to a score composed by Sanko and 
performed live by the Kronos Quartet.  

<?=draw_img($request['path'] . "cervantes2.jpg")?>
<span class="caption">Photo Julieta Cervantes</span>

<?=draw_img($request['path'] . "cervantes3.jpg")?>
<span class="caption">Photo Julieta Cervantes</span>

<?=draw_img($request['path'] . "cervantes4.jpg")?>
<span class="caption">Photo Julieta Cervantes</span>

<?=draw_img($request['path'] . "John-Michaels-photo.jpg")?>
<span class="caption">Photo John Michaels</span>

<?=draw_img($request['path'] . "john-michaels-photo2.jpg")?>
<span class="caption">Photo John Michaels</span>

</div>

<div class="right">
	<?=drawPress()?>
<?=draw_img($request['path'] . "richard-termine-photo.jpg");?>
photo by Richard Termine<br>


</div>

<?=drawBottom();?>