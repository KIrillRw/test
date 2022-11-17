<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<form action="<?=$_SERVER["REQUEST_URI"]?>">
	Название<input type="text" name="name"><br>
	<button type="sybmit" name="ADD">Добавить</button>
	<?if($arResult):?><button type="sybmit" name="REMOVE" value="<?=current(array_keys($arResult))?>">Удалить последнюю запись</button><?endif?>
</form>
<?if($arResult):?>
<h3>Список</h3>
<table border="1">
	<tr>
		<th>ID</th>
		<th>NAME</th>
		<th>DATE_INSERT</th>
	</tr>
	<?foreach($arResult as $r):?>
	<tr>
		<td><?=$r["ID"]?></td>
		<td><?=$r["NAME"]?></td>
		<td><?=$r["DATE_INSERT"]?></td>
	</tr>
	<?endforeach?>
</table>
<?else:?>
<h3>Список пуст</h3>
<?endif?>