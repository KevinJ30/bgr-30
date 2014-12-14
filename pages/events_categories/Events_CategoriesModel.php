<?php
/**
 * File : pages/events_categories/Events_CategoriesModel.php
 *
 * Crées par Joudrier Kevin
 *
 * Permet la gestion des news
 **/

class Events_CategoriesModel extends Model
{
	/**
	 * getCategories
	 *
	 * @return retourne la liste des categories
	 **/
	public function getCategories()
	{
		// Connection a la base de données
		$this->connect();

		$req = $this->bdd->query("SELECT id, name, color, actif FROM events_categories ORDER BY id DESC") or die(print_r($this->bdd->errorInfo()));
		
		$cats = array();

		while($donnees = $req->fetch(PDO::FETCH_OBJ))
		{
			$cats[] = $donnees;
		}

		$req->closeCursor();

		return $cats;
	}

	
	/**
	 * insert
	 *
	 * permet d'insérer une catégorie dans la base de données
	 *
	 * @param $données : tableaux contenant les données a envoyer dans la base de données
	 **/
	public function insert($donnees = array())
	{
		// Connection à la base de données
		$this->connect();

		$req = $this->bdd->prepare("INSERT INTO events_categories(name, color, actif) VALUES(:name, :color, :actif)");
		$req->execute($donnees)or die(print_r($req->errorInfo()));
		$req->closeCursor();

		return true;
	}

	/**
	 * firstCategories
	 *
	 * Retourne la categories lier à son id
	 *
	 * @param $id id de la categorie
	 * @return retourne la categorie 
	 **/
	public function firstCategorie($id)
	{
		// Connection à la base de données
		$this->connect();

		// Requête
		$req = $this->bdd->prepare('SELECT id, name, color, actif FROM events_categories WHERE id=:id');
		$req->execute(array(
			'id' => $id
		));

		$donnees = $req->fetch(PDO::FETCH_OBJ);

		$req->closeCursor();

		return $donnees;
	}

	/**
	 * edit
	 *
	 * Permet de modifier les données
	 *
	 * @param $id id de la categorie à modifier
	 * @param $donnees données a entrée dans la base de donnée
	 **/
	public function edit($id, $donnees = array())
	{

		// Connection à la base de données
		$this->connect();

		// Requête
		$req = $this->bdd->prepare('UPDATE events_categories SET name=:name, color=:color, actif=:actif WHERE id=:id');
		$req->execute(array(
			'name' => $donnees['name'],
			'color' => $donnees['color'],
			'actif' => $donnees['actif'],
			'id' => $id
		)) or die(print_r($req->errorInfo()));

		$req->closeCursor();
		return true;
	}

	/**
	 * delete
	 *
	 * @param $id id de la categorie
	 **/
	public function delete($id)
	{
		// Connection à la base de données
		$this->connect();

		$req = $this->bdd->prepare("DELETE FROM events_categories WHERE id=:id");
		$req->execute(array(
			'id' => $id
		)) or die(print_r($req->errorInfo()));

		$req->closeCursor();

		return true;
	}
}