<?php
	/**
	 * File : pages/menus/MenusModel.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Permet la gestion bdd des menus du site
	 **/

	class MenusModel extends Model
	{
		/**
		 * admin_getMenus()
		 *
		 * Permet de récuperer la list des menus sur le site
		 *
		 * @return : retourne un tableau contenant tout les menus
		 **/
		public function admin_getMenus()
		{
			// Connection a mla base de données
			$this->connect();

			$req = $this->bdd->prepare('SELECT * FROM menus');

			$req->execute() or die(print_r($req->errorInfo()));

			$menu = array();

			while($donnees = $req->fetch(PDO::FETCH_OBJ))
			{
				$menu[] = $donnees;
			}

			return $menu;
		}

		/**
		 * admin_getMenu()
		 *
		 * Permet de récuperer un menu
		 *
		 * @return : retourne un tableau contenant tout les menus
		 **/
		public function admin_getMenu($id)
		{
			// Connection a mla base de données
			$this->connect();

			$req = $this->bdd->prepare('SELECT * FROM menus WHERE id=:id');

			$req->execute(array('id' => $id)) or die(print_r($req->errorInfo()));

			return $req->fetch(PDO::FETCH_OBJ);
		}


		/**
		 * admin_add
		 *
		 * Permet d'ajouter un menu dans la base de donnée
		 *
		 * @param $nom nom du menu
		 **/
		public function admin_add($nom)
		{
			// Connection a la base de données
			$this->connect();

			$req = $this->bdd->prepare('INSERT INTO menus(name) VALUES(:nom)');

			$req->execute(array(
				'nom' => $nom
			)) or die(print_r($req->errorInfo()));

			$req->closeCursor();
		}

		/**
		 * admin_delete
		 *
		 * Permet d'ajouter un menu dans la base de donnée
		 *
		 * @param $id id du menu
		 **/
		public function admin_delete($id)
		{
			// Connection a la base de données
			$this->connect();

			$req = $this->bdd->prepare('DELETE FROM menus WHERE id=:id');

			$req->execute(array(
				'id' => $id
			)) or die(print_r($req->errorInfo()));

			$req->closeCursor();
		}

		/**
		 * admin_edit
		 *
		 * Permet d'ajouter un menu dans la base de donnée
		 *
		 * @param $id id du menu
		 * @param $nom nom du menu
		 **/
		public function admin_setMenu($id, $nom)
		{
			// Connection a la base de données
			$this->connect();

			$req = $this->bdd->prepare('UPDATE menus SET name=:nom WHERE id=:id');

			$req->execute(array(
				'nom' => $nom,
				'id' => $id
			)) or die(print_r($req->errorInfo()));

			$req->closeCursor();
		}
	}
?>