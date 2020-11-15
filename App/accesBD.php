<?php

class accesBD
{
  //-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//--------------------------ATTRIBUTS PRIVES--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	private $hote;
	private $login;
	private $passwd;
	private $base;
	private $bdd;
	private $port;

	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//--------------------------CONSTRUCTEUR------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	public function __construct()
	{
		$this->hote="localhost";
		$this->port="";
		$this->login="root";
		$this->passwd="";
		$this->base="todoux";

		/*$this->hote="localhost";
		$this->port="";
		$this->login="root";
		$this->passwd="";
		$this->base="integration";*/


		$this->connection();

	}

	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//-----------------------------CONNECTION A LA BASE---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	

	public function __sleep()
    {
        return array('hote', 'port', 'login', 'passwd', 'base');
    }

    public function __wakeup()
    {
        $this->connection();
    }

	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------REQUEST USER--------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function REQUser_VerifEmail($email){
		$success = 0;

		try {
			$request = $this->bdd->prepare("SELECT id_user FROM user WHERE email_user = :email_user");
			if ($request->execute(array(':email_user'=>$email))) {
				if ($request->rowCount() > 0) {
					$success = 1;
				}
			}
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		return $success;
	}

	public function REQUser_VerifLogin($email, $password){
		$success = 0;

		try{
		$request = $this->bdd->prepare("SELECT id_user FROM user WHERE email_user = :email_user and password_user = :password_user");
			if ($request->execute(array(':email_user'=>$email,':password_user'=>$password))) {
				if ($request->rowCount() > 0) {
					$success = 1;
				}
			}
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		return $success;
	}

	public function REQUser_InsertUser($name, $firstname, $email, $password){
		$success = 0;

		try{
		$request = $this->bdd->prepare("INSERT INTO user(name_user, firstname_user, email_user, password_user) VALUES(:name_user, :firstname_user, :email_user, :password_user)");
			if ($request->execute([':name_user'=>$name, ':firstname_user'=>$firstname, ':email_user'=>$email, ':password_user'=>$password])) {
				$success = 1;
			}
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		return $success;
	}


	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------REQUEST TODO--------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

  function REQTodo_LoadAllTodoFromIdUser($iduser){
    $success = 0;
    $listeTodo = null;
    $i = 0;
		try{
			$request = $this->bdd->prepare("SELECT id_todo, title_todo, active_todo, status_todo, createdate_todo FROM todo WHERE iduser_todo = :iduser_todo and active_todo = 0");
			if ($request->execute(array(":iduser_todo"=>$iduser))) {
				if ($request->rowCount() > 0) {
					while ($result = $request->fetch()) {
						$success = 1;
						$listeTodo[$i] = ["id_todo" => $result["id_todo"], "title_todo" => $result["title_todo"], "active_todo" => $result["active_todo"], "status_todo" => $result["status_todo"], "createdate_todo" => $result["createdate_todo"]];
						$i++;
					}
				}else {
					$success = 2; //Aucune ligne.
				}
			}
		}catch(PDOException $e){
			echo $e->getMessage();
		}

    if ($success == 0) {
      $response = ["success" => $success];
    }else {
      $response = ["success" => $success, "listeTodo" => $listeTodo];
    }
    return $response;
  }

  function REQTask_LoadTaskFromIdTodo($idTodo){
    $success = 0;
    $listeTask = null;
    $i = 0;

		try{
			$request = $this->bdd->prepare("SELECT id_task, content_task, enddate_task, endtime_task, active_task FROM task WHERE idtodo_task = :idtodo_task and active_task = 0");
	    if ($request->execute(array(":idtodo_task"=>$idTodo))) {
	      if ($request->rowCount() > 0) {
	        while ($result = $request->fetch()) {
	          $success = 1;
	          $listeTask[$i] = ["id_task" => $result["id_task"], "content_task" => $result["content_task"], "enddate_task" => $result["enddate_task"], "endtime_task" => $result["endtime_task"], "active_task" => $result["active_task"]];
	          $i++;
	        }
	      }else {
	        $success = 2;
	      }
	    }
		}catch(PDOException $e){
			echo $e->getMessage();
		}

    if ($success == 0) {
      $response = ["success" => $success];
    }else {
      $response = ["success" => $success, "listeTask" => $listeTask];
    }
    return $response;
  }

  function REQTask_LoadTaskFromIdUser($idUser, $endDate){
    $success = 0;
    $listeTask = null;
    $i = 0;

		if($endDate != null){
			$string_request = "SELECT id_task, content_task, enddate_task, endtime_task, active_task FROM task WHERE iduser_task = :iduser_task and enddate_task = :enddate_task ORDER BY active_task ASC";
			$array_request= array(":iduser_task"=>$idUser, ":enddate_task"=>$endDate);
		}else {
			$string_request = "SELECT id_task, content_task, enddate_task, endtime_task, active_task FROM task WHERE iduser_task = :iduser_task ORDER BY active_task ASC";
			$array_request = array(":iduser_task"=>$idUser);
		}

		try{
			$request = $this->bdd->prepare($string_request);
	    if ($request->execute($array_request)) {
	      if ($request->rowCount() > 0) {
	        while ($result = $request->fetch()) {
	          $success = 1;
	          $listeTask[$i] = ["id_task" => $result["id_task"], "content_task" => $result["content_task"], "enddate_task" => $result["enddate_task"], "endtime_task" => $result["endtime_task"], "active_task" => $result["active_task"]];
	          $i++;
	        }
	      }else {
	        $success = 2;
	      }
	    }
		}catch(PDOException $e){
			echo $e->getMessage();
		}

    if ($success == 0) {
      $response = ["success" => $success];
    }else {
      $response = ["success" => $success, "listeTask" => $listeTask];
    }
    return $response;
  }



}


 ?>
