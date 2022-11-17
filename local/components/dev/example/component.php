<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Entity;
use \Bitrix\Main\Type;
use Bitrix\Main\Application;
if($arParams["AJAX_MODE"] != "Y")
{
	echo "Для работы компонента нужно включить AJAX режим в настройках";
	return false;
}
class ExampleTable extends Entity\DataManager{
	public static function tName()
	{
		return "example_test_table";
	}
	public static function createExampleTable()
	{
		$connection = Application::getConnection();
		if(!$connection->isTableExists(self::tName()))
			 self::createTable();
	}
	public static function getTableName()
	{
		return self::tName();
    }
    public static function getMap()
    {
		return array(
			new Entity\IntegerField("ID", array(
				"autocomplete" => true,
				"primary" => true,
			)),
            new Entity\StringField("NAME"),
            new Entity\DateTimeField("DATE_INSERT",array(
            	"default_value"=>new Type\DateTime(date("Y-m-d H:i:s"), "Y-m-d H:i:s")
            ))
        );
    }
    public static function createTable(){
        $connection = Application::getInstance()->getConnection();
        if (!$connection->isTableExists(static::getTableName()))
        {
            static::getEntity()->createDbTable();
            return true;
        }
        else
            return false;
    }
    

    public static function getItems($id=false)
    {
    	$arr = ["order"=>["ID"=>"DESC"]];
    	if($id)
    		$arr["filter"] = ["ID"=>$id];
    	$request = self::getList($arr);
		while ($res = $request->Fetch())
		{
			$return[$res["ID"]]["ID"] = $res["ID"];
			$return[$res["ID"]]["NAME"] = $res["NAME"];
			$return[$res["ID"]]["DATE_INSERT"] = date($res["DATE_INSERT"],strtotime($res["DATE_INSERT"]));
		}
		return $return;
    }
    public static function addItem($name=false)
    {
    	if($name == false) return false;
    	$add = ExampleTable::add(array(
		    "NAME"=>$name,
		));
		if ($add->isSuccess())
		    $id = $add->getId();
		else
		{
		    $errors = $add->getErrors();
		    foreach ($errors as $error)
		       echo $error->getMessage();
		}
    }
    public static function removeLastItem($id=false)
    {
    	if($id == false) return false;
    	ExampleTable::delete($id);
    }
}
ExampleTable::createExampleTable();
if($_REQUEST["AJAX_CALL"]=="Y")
{
	
	if(isset($_REQUEST["ADD"]))
	{
		$name = strip_tags(trim($_REQUEST["name"]));
		if(!empty($name))
			ExampleTable::addItem($name);
		else
			echo "<h3>Поле \"Название\" пусто</h3>";

	}
	if(isset($_REQUEST["REMOVE"]))
	{
		if(!empty($_REQUEST["REMOVE"]))
			ExampleTable::removeLastItem($_REQUEST["REMOVE"]);
		else
			echo "<h3>Нет ID удаляемого элемента</h3>";

	}
	$arResult = ExampleTable::getItems();
		
}
else
	$arResult = ExampleTable::getItems();
$this->IncludeComponentTemplate();
