<?php

class pageMeta{
	private $title;
	private $icon;

	function __construct($idPage){
		$meta = $this->loadPageMeta($idPage);
		$this->setTitle($meta['label']);
		$this->setIcon($meta['icon']);
	}
	
	function setTitle($title){
		$this->title = $title;
	}
	
	function getTitle(){
		return $this->title;
	}
	
	function setIcon($icon){
		$this->icon = $icon;
	}
	
	function getIcon(){
		return $this->icon;
	}
	
	private function loadPageMeta($idPage){
		$pdo = database::connect();
	
		$params = array(':idPage' => $idPage);
	
		$query = 'SELECT label, icon FROM t_app_page WHERE idPage = :idPage';
	
		$stmt = $pdo->prepare($query);
	
		if($stmt->execute($params)){
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
			return $row;
		}
	}
}

?>