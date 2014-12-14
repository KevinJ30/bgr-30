<?php
	/**
	 * File : pages/news/NewsModel.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Permet la gestion des news dans la base de données
	 **/
	
	class NewsModel extends Model
	{
		/**
		 * getNews
		 * 
		 * Permet de récuperer toutes les news de la base de données
		 * Retourne la liste du dernier rentré au premier
		 * 
		 * @param $depart : contient le numéro départ de la limit
		 * @param $fin : contient la fin de la limit
		 * 
		 **/
		public function getNews($limit = array())
		{
			$news = array(); // permet de stocker toutes les news de la base de données
		
			// Connection a la base de données
			$this->connect();
			
			$sql = "SELECT news.id, news.title, news.content, DATE_FORMAT(news.created, '%d-%m-%Y') as created, news.status, users.username as users_username FROM news LEFT JOIN users ON users.id = users_id  WHERE status=1 ORDER BY news.id DESC";
			
			// Si le tableau limit est renseigné alors on applique la limit
			if(!empty($limit))
			{
				$sql .= ' LIMIT '.$limit['depart'].','.$limit['fin'];	
			}
			
			$req = $this->bdd->query($sql) or die(print_r($this->bdd->errorInfo()));
			
			while($donnees = $req->fetch(PDO::FETCH_OBJ))
			{
				$news[] = $donnees;
			}
			
			$req->closeCursor();
			
			return $news;
		}
		
		/**
		 * firstNews()
		 *
		 * Permet de récuperer la news en fonction de son id
		 * 
		 * @param $id : contient l'id de la news a récupérer
		 *
		 **/
		public function firstNews($id)
		{
			// Connection à la base de données
			$this->connect();
			
			$req = $this->bdd->prepare('SELECT id, title, content, status FROM news WHERE id=:id');
			
			$req->execute(array(
				'id' => $id		
			))or die(print_r($req->errorInfo()));
			
			$news = $req->fetch(PDO::FETCH_OBJ);
			
			$req->closeCursor();
			
			return $news;
		}
		
		/**
		 * insert()
		 * 
		 * Permet d'insérer une news dans la base de données
		 **/
		public function insert($donnees = array())
		{
			// Connection à la base de données
			$this->connect();
			
			$req = $this->bdd->prepare('INSERT INTO news(title, content, created, status, users_id) VALUES(:title, :content, now(), :status, :users_id)');
			
			$req->execute($donnees)or die(print_r($req->errorInfo()));
			
			$req->closeCursor();
			return true;
		}
		
		/**
		 * update()
		 *
		 * Permet d'editer une news
		 * 
		 * @param : $donnees : contient les données a sauvegarder
		 * @param : $id : contient l'id de la news
		 **/
		public function update($donnees = array(), $id)
		{
			// Connection à la base de données
			$this->connect();
			
			$req = $this->bdd->prepare('UPDATE news SET title=:title, content=:content, status=:status WHERE id=:id');
			
			$req->execute(array(
				'title' => $donnees['title'],
				'content' => $donnees['content'],
				'status' => $donnees['status'],
				'id' => $id
			)) or die(print_r($req->errorInfo()));
			
			$req->closeCursor();
		}
		
		/**
		 * delete()
		 *
		 * Permet d'editer une news
		 *
		 * @param : $id : contient l'id de la news
		 **/
		public function delete($id)
		{
			// Connection à la base de données
			$this->connect();
			
			$req = $this->bdd->prepare('DELETE FROM news WHERE id=:id');
			
			$req->execute(array('id' => $id)) or die(print_r($req->errorInfo()));
			
			$req->closeCursor();
		}
		
		
		/**
		 * countNews
		 *
		 * Retourne le nombre de news total
		 *
		 **/
		public function countNews()
		{
			// Connection a la base de données
			$this->connect();
			
			$req = $this->bdd->query('SELECT count(id) as count FROM news') or die($this->bdd->errorInfo());
			
			return $req->fetch(PDO::FETCH_OBJ);
		}
	}