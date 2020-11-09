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

	private function connection()
	{
		try
        {
			//echo "sqlsrv:server=$this->hote$this->port;Database=$this->base"." | ".$this->login." | ".$this->passwd;
			// Pour SQL Server
			//$this->conn = new PDO("sqlsrv:server=$this->hote$this->port;Database=$this->base", $this->login, $this->passwd);
			//$this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

            // Pour Mysql/MariaDB
            $this->bdd = new PDO("mysql:dbname=$this->base;host=$this->hote",$this->login, $this->passwd);
						$this->bdd->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $this->boolconnection = true;
        }
        catch(PDOException $e)
        {
            die("connection à la base de données échouée".$e->getMessage());
        }
	}

	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//----------------------------REQUEST USER--------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function REQUser_VerifEmail($email){
		$success = 0;

		$request = $this->bdd->prepare("SELECT id_user FROM user WHERE email_user = :email_user");
		if ($request->execute(array('email_user'=>$email))) {
			if ($request->rowCount() > 0) {
				$success = 1;
			}
		}
		return $success;
	}

	public function REQUser_VerifLogin($email, $password){
		$success = 1;

		$request = $this->bdd->prepare("SELECT id_user FROM user WHERE email_user = :email_user and password_user = :password_user");
		try{
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

		$request = $this->bdd->prepare("INSERT INTO user(name_user, firstname_user, email_user, password_user) VALUES(:name_user, :firstname_user, :email_user, :password_user)");
		try{
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

  function REQTodo_LoadTodoFromIdUser($iduser){
    $success = 0;
    $listeTodo = null;
    $i = 0;

    $request = $this->bdd->prepare("SELECT id_todo, title_todo, active_todo, status_todo FROM todo WHERE iduser_todo = ?");
    if ($request->execute(array($iduser))) {
      if ($request->rowCount() > 0) {
        while ($result = $request->fetch()) {
          $success = 1;
          $listeTodo[$i] = ["id_todo" => $result["id_todo"], "title_todo" => $result["title_todo"], "active_todo" => $result["active_todo"], "status_todo" => $result["status_todo"]];
          $i++;
        }
      }else {
        $success = 2; //Aucune ligne.
      }
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

    $request = $this->bdd->prepare("SELECT id_task, content_task, enddate_task, endtime_task, status_task FROM task WHERE idtodo_task = ?");
    if ($request->execute(array($idTodo))) {
      if ($request->rowCount() > 0) {
        while ($result = $request->fetch()) {
          $success = 1;
          $listeTask[$i] = ["id_task" => $result["id_task"], "content_task" => $result["content_task"], "enddate_task" => $result["enddate_task"], "endtime_task" => $result["endtime_task"], "status_task" => $result["status_task"]];
          $i++;
        }
      }else {
        $success = 2;
      }
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

		if(isset($date)){
			$string_request = "SELECT id_task, content_task, enddate_task, endtime_task, status_task FROM task WHERE iduser_task = ? and enddate_task = ?";
			$array_request= array($idUser, $endDate);
		}else {
			$string_request = "SELECT id_task, content_task, enddate_task, endtime_task, status_task FROM task WHERE iduser_task = ?";
			$array_request = array($idUser);
		}

    $request = $this->bdd->prepare($string_request);
    if ($request->execute($array_request)) {
      if ($request->rowCount() > 0) {
        while ($result = $request->fetch()) {
          $success = 1;
          $listeTask[$i] = ["id_task" => $result["id_task"], "content_task" => $result["content_task"], "enddate_task" => $result["enddate_task"], "endtime_task" => $result["endtime_task"], "status_task" => $result["status_task"]];
          $i++;
        }
      }else {
        $success = 2;
      }
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
