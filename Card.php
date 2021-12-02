<?php

interface Card
{
	public function GetAllCards();
	public function GetCardByID(int $ID);
	public function GetCardBySet(string $Set);
	public function GetCardByName(string $Name);
	#public function UpdateCard();
	#public function DeleteCard();
} #End Card interface

class MyPDO extends PDO
{
	public function __construct($dsn, $username, $password, $options) {
        $default_options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $options = array_merge($default_options, $options);
        parent::__construct($dsn, $username, $password, $options);
    }

    public function run($sql, $args = null) {
        $stmt = $this->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }
}


class TestCard implements Card
{
	private $db = null;
	private $tbl = "cards";
	
	public function __construct(PDO $db)
	{
		$this->db = $db;
	}
	
	
	public function GetAllCards()
	{
		return $this->db->run("SELECT * FROM " . $this->tbl . "");
	}
	
	
	public function GetCardByID($ID)
	{
		return $this->db->run("SELECT * FROM " . $this->tbl . " WHERE ID=\"" . $ID . "\"");
	}
	
	public function GetCardBySet($Set)
	{
		return $this->db->run("SELECT * FROM " . $this->tbl . " WHERE SetName=\"" . $Set . "\"");
	}
	
	public function GetCardByName($Name)
	{
		return $this->db->run("SELECT * FROM " . $this->tbl . " WHERE CardName LIKE \"" . $Name . "%\"");
	}
}





#region
/*
class CreateCard
{
	private $ID;
	private $CardName;
	private $SetName;
	private $ImageURL;
	private $NumOwned;
	private $RegPrice;
	private $FoilPrice;
	
	public function __construct($ID, $CardName, $SetName, $ImageURL, $NumOwned, $RegPrice, $FoilPrice)
	{
			$this->ID = $ID;
			$this->CardName = $CardName;
			$this->SetName = $SetName;
			$this->ImageURL = $ImageURL;
			$this->NumOwned = $NumOwned;
			$this->RegPrice = $RegPrice;
			$this->FoilPrice = $FoilPrice;
	}
	
	#Getters
	public function get_ID()
	{
		return $this->ID;
	}
	
	public function get_CardName()
	{
		return $this->CardName;
	}
	
	public function get_SetName()
	{
		return $this->SetName;
	}
	
	public function get_ImageURL()
	{
		return $this->ImageURL;
	}
	
	public function get_NumOwned()
	{
		return $this->NumOwned;
	}
	
	public function get_RegPrice()
	{
		return $this->RegPrice;
	}
	
	public function get_FoilPrice()
	{
		return $this->FoilPrice;
	}
	#End Getters
	
	#Setters
	
	public function set_ID($ID)
	{
		if ($ID >= 0 && $ID != null)
		{
			$this->ID = $ID;
		}
	}
	
	public function set_CardName($CardName)
	{
		if($CardName != null && strlen($CardName) > 0)
		{
			$this->CardName = $CardName;
		}
	}
	
	public function set_SetName($SetName)
	{
		if($SetName != null && strlen($SetName) > 0)
		{
			$this->SetName = $SetName;
		}
	}
	
	public function set_ImageURL($ImageURL)
	{
		if($ImageURL != null && strlen($ImageURL) > 0)
		{
			$this->ImageURL = $ImageURL;
		}
	}
	
	public function set_NumOwned($NumOwned)
	{
		if($NumOwned != null)
		{
			$this->NumOwned = $NumOwned;
		}
	}
	
	public function set_RegPrice($RegPrice)
	{
		if($RegPrice != null && $RegPrice > 0)
		{
			$this->RegPrice = $RegPrice;
		}
	}
	
	public function set_FoilPrice($FoilPrice)
	{
		if($FoilPrice != null && $FoilPrice > 0)
		{
			$this->FoilPrice;
		}
	}
	
	
	#End Setters
	


	
} #End CreateCard class
*/
#endregion




?>