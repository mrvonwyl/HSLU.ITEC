<?php
class crudBase{
	public $pdo;
	public $table;
	public $index;

	public $cQuery;
	public $rQuery;
	public $uQuery;
	public $dQuery;

	public $cParams;
	public $rCols;
	public $uParams;
	public $dParams;
	
	public $response;

	public function __construct(){
		$this->pdo = database::connect();
		$this->response = new crudResponse(0, null, array());
	}
	
	public function create(){
		$this->query($this->cQuery, $this->cParams);
	}
	
	public function read(){
		$stmt = $this->query($this->rQuery, array());
		
		$cols = array_flip(array_merge(array($this->index), $this->rCols));
		$filtered = array();
		$full = array();
		
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
			$rowFiltered = array_intersect_key($row, $cols);
			$vals = array_values($rowFiltered);
			$filtered[$vals[0]] = $vals[1];
			$full[] = $row;
		}
		
		$this->response->data['filtered'] = $filtered;
		$this->response->data['full'] = $full; 
	}
	
	public function update(){
		$this->query($this->uQuery, $this->uParams);
	}
	
	public function delete(){
		$this->query($this->dQuery, $this->dParams);
	}

	public function query($query, $params){
		$stmt = $this->pdo->prepare($query);

		if($stmt->execute($params)){
			$this->response->code = 1;
			$this->response->text = '<b>SUCCESS:</b> The operation succeeded...';
			return $stmt;
		}
		else{
			$this->response->code = -1;
			$this->response->text = '<b>ERROR:</b> The operation failed...';
			print_r($stmt->errorInfo());
			return false;
		}
	}

	public function getResponse(){
		return json_encode($this->response);
	}
}

class crudResponse{
	public $code;
	public $text;
	public $data;

	public function __construct($code, $text, $data){
		$this->code = $code;
		$this->text = $text;
		$this->data = $data;
	}
}
?>