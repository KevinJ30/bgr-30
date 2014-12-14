<?php
/**
 * File : pages/pages/PagesModel.php
 *
 * Crées par Joudrier Kevin
 *
 * Permet la gestion des pages dans la base de données
 **/

class PagesModel extends Model
{
	/**
	 * getAccueil
	 *
	 * permet de récupérer la page d'accueil du site
	 **/
	public function getAccueil()
	{
		// Connection a la base de données
		$this->connect();

		$req = $this->bdd->prepare("SELECT title, DATE_FORMAT(date, '%d-%m-%Y') as date, content, accueil  FROM pages WHERE accueil=:accueil AND status = 1 ORDER BY id DESC");

		$req->execute(array(
			'accueil' => 1
		)) or die(print_r($req->errorInfo()));

		$accueil = array();

		while($donnees = $req->fetch(PDO::FETCH_OBJ))
		{
			$accueil[] = $donnees;
		}

		$req->closeCursor();

		return $accueil;
	}

	/**
	 * create()
	 *
	 * @param : $donnees = array() un tableau contenant les donnée a ajouter a la base de données
	 **/
	public function create($donnees = array())
	{
		// Connection a la base de données
		$this->connect();

		$req = $this->bdd->prepare('INSERT INTO pages (title, date, content, status, accueil, menu_id) VALUES(:title, now(), :content, :status, :accueil, :menu)');

		$req->execute($donnees) or die(print_r($req->errorInfo()));

		$req->closeCursor();

		// On ferme la fonction pour s'assurer d'aucune execution de code supplémentaire
		return  false;
	}

	/**
	 * edit()
	 *
	 *Permet d'editer une page
	 * @param : $donnees = array() un tableau contenant les donnée a ajouter a la base de données
	 **/
	public function edit($donnees, $id)
	{
		// Connection a la base de données
		$this->connect();

		// preparation de la requête
		$req = $this->bdd->prepare('UPDATE pages SET title = :title, content =  :content, status = :status, accueil = :accueil, menu_id = :menu_id WHERE id = :id');

		$req->execute(array(
			'title' => $donnees['title'],
			'content' => $donnees['content'],
			'status' => $donnees['status'],
			'accueil' => $donnees['accueil'],
			'menu_id' => $donnees['menu'],
			'id' => $id
		)) or die(print_r($req->errorInfo()));

		$req->closeCursor();

		return false;
	}

	/**
	 * delete($id)
	 *
	 *Permet d'editer une page
	 * @param : $id contient l'id de la page a supprimer
	 **/
	public function delete($id)
	{
		// Connection a la base de données
		$this->connect();

		$req = $this->bdd->prepare('DELETE FROM pages WHERE id=:id');

		$req->execute(array(
			'id' => $id
		)) or die(print_r($req->errorInfo()));

		$req->closeCursor();
	}


	/**
	 * getPages
	 *
	 * permet d'afficher la liste des toutes les pages du site
	 **/
	public function getPages()
	{
		// Connection a la base de données
		$this->connect();

		$req = $this->bdd->prepare("SELECT id, title, DATE_FORMAT(date, '%d-%m-%Y') as date, status, accueil FROM pages ORDER BY id DESC");

		$req->execute() or die(print_r($req->errorInfo()));

		$pages = array();

		while($donnees = $req->fetch(PDO::FETCH_OBJ))
		{
			$pages[] = $donnees;
		}

		$req->closeCursor();

		return $pages;
	}

	/**
	 * getPagesJoinMenu
	 *
	 * Permet de récupérer les pages et les menu qui son associer
	 **/
	public function getPagesJoinMenu()
	{
		// connection a la base de données
		$this->connect();

		$req = $this->bdd->prepare("SELECT pages.id, pages.title, DATE_FORMAT(date, '%d-%m-%Y') as date, pages.status, pages.accueil, menus.id as menu_id, menus.name as menu_name FROM pages LEFT JOIN menus ON pages.menu_id = menus.id ORDER BY id DESC");

		$req->execute() or die(print_r($req->errorInfo()));

		$pages = array();

		while($donnees = $req->fetch(PDO::FETCH_OBJ))
		{
			$pages[] = $donnees;
		}

		$req->closeCursor();

		return $pages;
	}


	/**
	 * getPagesMenu
	 *
	 * Permet de récupérer les pages du menu
	 *@param $id : l'id du menu menu
	 **/
	public function getPagesMenu($id)
	{
		// Connection a la base de données
		$this->connect();

		$req = $this->bdd->prepare('SELECT pages.id, pages.title, pages.menu_id FROM pages INNER JOIN menus ON pages.menu_id = menus.id WHERE pages.menu_id=:id');

		$req->execute(array('id' => $id)) or die(print_r($req->errorInfo()));

		$pages = array();

		while($donnees = $req->fetch(PDO::FETCH_OBJ))
		{
			$pages[] = $donnees;
		}

		$req->closeCursor();

		return $pages;
	}

	/**
	 * getPage
	 *
	 * permet de récupérer une page en fonction son id
	 **/
	public function getPage($id)
	{
		// Connection a la base de données
		$this->connect();

		$req = $this->bdd->prepare('SELECT id, title, date, content, status, accueil, menu_id FROM pages WHERE id=:id');

		$donnees = $req->execute(array(
			'id' => $id
		));

		$page = $req->fetch(PDO::FETCH_OBJ);

		$req->closeCursor();

		return $page;
	}

	/**
	 * getMenu
	 *
	 * permet d'afficher la liste de tous les menus du site
	 **/
	public function getMenu()
	{
		// Connection a la base de données
		$this->connect();

		$req = $this->bdd->prepare("SELECT id, name FROM menus");

		$req->execute() or die(print_r($req->errorInfo()));

		$menus = array();

		while($donnees = $req->fetch(PDO::FETCH_OBJ))
		{
			$menus[] = $donnees;
		}

		$req->closeCursor();

		return $menus;
	}

	/**
	 * setMenu_id
	 *
	 * permet de changer la valeur du menu_id
	 *
	 * @param : $id : id de la page
	 * @param : $value : correspond à la valeur
	 **/
	public function setMenu_id($id, $value)
	{

		// Connection à la base de données
		$this->connect();
 		
 		// Réquete SQL
		$req = $this->bdd->prepare('UPDATE pages SET menu_id=:menu_id WHERE id=:id');

		$req->execute(array(
			'menu_id' => $value,
			'id' => $id
		)) or die(print_r($req->errorInfo()));

		$req->closeCursor();
		return false;
	}
}
?>
