<?php


ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'constants.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

    function add_to_cart(){
		extract($_POST);
        $data = " c_id = '{$_SESSION['id']}'";
		$data .= ", food_id = $id ";
		$data .= ", quantity= $qty";
		$check = $this->db->query("SELECT * FROM cart where food_id = $id");
		$id= $check->num_rows > 0 ? $check->fetch_array()['id'] : '';
		if(!empty($id))
			$save = $this->db->query("UPDATE cart set quantity = quantity+$qty where food_id = $id");
		else
			$save = $this->db->query("INSERT INTO cart set $data");
		if($save){
			return 1;
		}
	}

}
?>