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


		$this->connexion();

	}

	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//-----------------------------CONNECTION A LA BASE---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private function connexion()
	{
		try
        {
			//echo "sqlsrv:server=$this->hote$this->port;Database=$this->base"." | ".$this->login." | ".$this->passwd;
			// Pour SQL Server
			//$this->conn = new PDO("sqlsrv:server=$this->hote$this->port;Database=$this->base", $this->login, $this->passwd);
			//$this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

            // Pour Mysql/MariaDB
            $this->bdd = new PDO("mysql:dbname=$this->base;host=$this->hote",$this->login, $this->passwd);
            $this->boolConnexion = true;
        }
        catch(PDOException $e)
        {
            die("Connexion à la base de données échouée".$e->getMessage());
        }
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

  function REQTask_LoadTaskFromIdUser($idUser){
    $success = 0;
    $listeTask = null;
    $i = 0;

    $request = $this->bdd->prepare("SELECT id_task, content_task, enddate_task, endtime_task, status_task FROM task WHERE iduser_task = ?");
    if ($request->execute(array($idUser))) {
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
