<?php
	/**
	 * File : class/Controller.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Contient les fonctions de base du controller
	 **/

	class Controller
	{
		protected $controller; // 
		protected $model; // Stock le model du controller

		/**
		 * Intialise les variables de class
		 **/
		public function __construct()
		{
			$this->Controller = $this->getController().'Controller';

			// On inclut le model de la class controller
			$model = $this->getController().'Model';
			// on test que le fichier model existe
			if(file_exists(ROOT_PAGES.$this->getController().__DS__.$model.'.php'))
			{
				include ROOT_PAGES.$this->getController().__DS__.$model.'.php';	
				$this->$model = new $model($this->getController());
			}
		}

		/**
		 * permet d'afficher le controller utilisé
		 **/

		private function getController()
		{
			$controller = get_called_class();
			$controller = preg_split("#Controller#", $controller);
			$controller = implode(array_slice($controller, 0, -1));

			return $controller;
		}

		/**
		 * loadView
		 *
		 * permet de charger une vue
		 * @param $name : contient le nom de la vue
		 **/
		public function loadView($name)
		{
			include ROOT_PAGES.strtolower($this->getController()).__DS__.'view'.__DS__.$name.'.php';
		}
		/** --------------------------- END loadView -------------**/
	}
?>