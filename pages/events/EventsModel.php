<?php
    
class EventsModel extends Model
{
	
	/**
	 * getCategories
	 *
	 * @return toutes les categories
	 **/
	public function getCategories()
	{
		// Connection aà la base de données
		$this->connect();

		// Requête
		$req = $this->bdd->prepare('SELECT * FROM events_categories WHERE actif=:actif ORDER BY id DESC');

		$req->execute(array(
			'actif' => 1
		)) or die(print_r($req->errorInfo()));

		$categories = array();

		while($donnees = $req->fetch(PDO::FETCH_OBJ))
		{
			$categories[] = $donnees; 
		}

		$req->closeCursor();

		return $categories;
	}

	/**
	 * getEvents
	 *
	 * @param : $month indique le mois pour la condition
	 * @param : $years indique l'année pour la condition
	 * @param : $categorie contient le numero de la categorie
	 * @return retourne la liste des évenements compléte
	 **/
	public function getEvents($month, $years, $categorie)
	{
		$condition = array(
			'start' => $years.'-'.$month.'-01',
			'end' => $years.'-'.$month.'-'.getDayMonth($month, $years)
		);

		// Connection à la base de données
		$this->connect();

		$req = $this->bdd->prepare('SELECT id, title, DATE_FORMAT(date_start, "%d-%m-%Y") as date_start, DATE_FORMAT(date_end, "%d-%m-%Y") as date_end, heure_start, heure_end, description, lieu, category_id, contact, adresse, mail, phone, lien, actif FROM events WHERE date_start >= :date_start AND date_start <= :date_end AND category_id=:category_id AND actif = 1');

		$req->execute(array(
			'date_start' => (string)$condition['start'],
			'date_end' => (string)$condition['end'],
			'category_id' => $categorie
		)) or die(print_r($req->errorInfo()));

		$events = array();

		while($donnees = $req->fetch(PDO::FETCH_OBJ))
		{
			$events[] = $donnees;
		}

		$req->closeCursor();

		return $events;
	}

	/**
	 * eventsCalendar
	 *
	 * Retourne la liste des événeùment du calendrier en cours
	 *
	 * @param : $date la date du calendrier du mois en cours
	 * @return la liste des événement du calendrier
	 **/
	public function eventsCalendar($month, $years)
	{
		$condition = array(
			'start' => $years.'-'.$month.'-01',
			'end' => $years.'-'.$month.'-'.getDayMonth($month, $years)
		);

		// Connection à la base de données
		$this->connect();

		$req = $this->bdd->prepare("SELECT id, DATE_FORMAT(date_start, '%d') as day FROM events WHERE date_start >= :date_start AND date_start <= :date_end AND actif=1 ORDER BY date_start DESC");

		$req->execute(array(
			'date_start' => $condition['start'],
			'date_end' => $condition['end']
		));

		$events = array();

		while($donnees = $req->fetch(PDO::FETCH_OBJ))
		{
			$events[] = $donnees;
		}

		$req->closeCursor();

		return $events;
	}

	/**
	 * eventsExist
	 *
	 * permet de récupérer l'événement en fonction de la date
	 *
	 * @param : $date date sur la qu'elle on cherche l'évenement
	 * @return : retourne un bollean true si l'évenment existe ou false
	 **/
	public function eventsExist($date)
	{

		// Connection à la base de données
		$this->connect();

		$req = $this->bdd->prepare('SELECT id FROM events WHERE date_start=:date_start');

		$req->execute(array(
			'date_start' => $date
		));

		$exist = $req->fetch(PDO::FETCH_OBJ);

		if($exist)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * defaultCategorie
	 *
	 * Retourne la categorie par défaut
	 * @return Retourne la category trouvé
	 **/
	public function defaultCategorie()
	{

		// Connection à la base de données
		$this->connect();

		$req = $this->bdd->prepare('SELECT * FROM events_categories WHERE defaut = :default');

		$req->execute(array(
			'default' => 1
		)) or die(print_r($req->errorInfo()));

		$donnees = $req->fetch(PDO::FETCH_OBJ);
		
		return $donnees;
	}

	/**
	 * allEvents
	 * @return retourne tous les événement du site
	 *
	 * Jointure avec la table events_categories
	 **/
	public function allEvents()
	{
		// Connection à la base de données
		$this->connect();

		$req = $this->bdd->query("SELECT events.id, events.title, DATE_FORMAT(events.date_start, '%d-%d-%Y') as date_start, DATE_FORMAT(events.date_end, '%d-%d-%Y') as date_end, 
								  events.heure_start, events.heure_end, events.category_id, events.actif, events_categories.id as categorieId, events_categories.name as categorieName, events_categories.color as categorieColor
								  ,events_categories.defaut as categorieDefaut FROM events LEFT JOIN events_categories ON events.category_id = events_categories.id ORDER BY events.id DESC") or die(print_r($this->bdd->errorInfo()));

		$events = array();

		while($donnees = $req->fetch(PDO::FETCH_OBJ))
		{
			$events[] = $donnees;
		}

		$req->closeCursor();

		return $events;
	}

	/**
	 * add
	 *
	 * @param : $donnees : contient les données à rentrer dans la base de données
	 *
	 **/
	public function add($donnees = array())
	{

		// Connection à la base de données
		$this->connect();

		// requête
		$req = $this->bdd->prepare("INSERT INTO events(title, date_start, date_end, heure_start, heure_end, description, lieu, category_id, contact, adresse, mail, phone, actif) VALUES(:title, :date_start, :date_end, :heure_start, :heure_end, :description, :lieu, :category_id, :contact, :adresse, :mail, :phone, :actif)");

		$req->execute($donnees) or die(print_r($req->errorInfo()));

		$req->closeCursor();

		return false;
	}

	/**
	 * first
	 *
	 * Permet de recherché un événement par son id
	 *
	 * @param $id : id de l'event
	 * @return retourne l'événement
	 **/
	public function first($id)
	{

		// Connection à la base de données
		$this->connect();

		// Requête
		$req = $this->bdd->prepare("SELECT title, date_start, date_end, DATE_FORMAT(heure_start, '%h:%m') as heure_start, DATE_FORMAT(heure_end, '%h:%m') as heure_end, description, lieu, category_id, contact, adresse, mail, phone, actif FROM events WHERE id=:id");

		$req->execute(array(
			'id' => $id
		));

		$event = $req->fetch(PDO::FETCH_OBJ);

		$req->closeCursor();

		return $event;
	}

	/**
	 * delete
	 *
	 * Permet de supprimer un event dans la base de données
	 *
	 * @param : $id : id de l'évent
	 **/
	public function delete($id)
	{

		// Connection à la base de donnée
		$this->connect();

		// Requête
		$req = $this->bdd->prepare("DELETE FROM events WHERE id=:id");

		$req->execute(array(
			'id' => $id
		)) or die(print_r($req->errorInfo()));

		$req->closeCursor();
		return false;
	}

	/**
	 * edit
	 *
	 * permet d'édité un événement
	 *
	 * @param : $donnees : contient le tableaux avec les données modifier
	 **/
	public function edit($donnees = array())
	{
		//debug($donnees);
		// Connection à la base de données
		$this->connect();

		// Requête
		$req = $this->bdd->prepare("UPDATE events SET title=:title, date_start=:date_start, date_end=:date_end, heure_start=:heure_start, heure_end=:heure_end, description=:description, lieu=:lieu, category_id=:categories, contact=:contact, adresse=:adresse, mail=:mail, phone=:phone, actif=:actif WHERE id=:id");

		$req->execute($donnees) or die(print_r($req->errorInfo()));

		$req->closeCursor();
		return false;
	}
}