<?php
	/**
	 * File : pages/events_categories/Events_CategoriesController.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Permet la gestion des events
	 **/
    class Events_CategoriesController extends Controller
    {
            /**
             * La page d'accueil des evenement
             **/
            public function index()
            {

            }

            /**
             * admin_index
             *
             * permet d'afficher la liste des categories
             **/
            public function admin_index()
            {
                // test si il est admin ou autheur
                if(isset($_SESSION['auth']) && !empty($_SESSION['auth']))
                {
                    if($_SESSION['auth']['permission'] != 'admin' && $_SESSION['auth']['permission'] != 'autheur')
                    {
                        $message = "Accès refusé.";
                        include ROOT.'errors/error403.php';
                        die();
                    }
                }
                else
                {
                    $message = "Accès refusé.";
                    include ROOT.'errors/error403.php';
                    die();
                }  

                $categories = $this->Events_CategoriesModel->getCategories();

                // Chargement de la vue
                include ROOT_PAGES.'events_categories/view/admin_index.php'; 
            }
            
            /**
             * admin_add
             * 
             * Permet d'ajouter une categories pour les events
             * 
             * @param : $token jeton csrf
             **/
            public function admin_add($token)
            {
                // test si il est admin ou autheur
                if(isset($_SESSION['auth']) && !empty($_SESSION['auth']))
                {
                    if($_SESSION['auth']['permission'] != 'admin' && $_SESSION['auth']['permission'] != 'autheur')
                    {
                        $message = "Accès refusé.";
                        include ROOT.'errors/error403.php';
                        die();
                    }
                }
                else
                {
                    $message = "Accès refusé.";
                    include ROOT.'errors/error403.php';
                    die();
                }

                // On test le token
                if(!isset($token) || empty($token))
                {
                    // On supprime le token
                    session_deleteKey('token');

                    $message = "Accès refusé.";
                    include ROOT.'errors/error403.php';
                    die();
                }
                else
                {
                    if($_SESSION['token'] != $token)
                    {
                        // On supprime le token
                        session_deleteKey('token');

                        $message = "Accès refusé.";
                        include ROOT.'errors/error403.php';
                        die();
                    }
                }

                $validator = new Validator(array(
                    'name' => array(
                        'notEmpty' => array(
                            'rule' => 'notEmpty',
                            'message' => 'Vous devez renseigner ce champ.'
                        ),
                        'alphanumeric' => array(
                            'rule' => 'alphaNumeric',
                            'message' => 'Le nom de la catégorie ne doit comporter que des caractère alphanumériques.'
                        )
                    )
                ), $this->Events_CategoriesModel, 'events_categories', true);

                // Si des données on été posté
                if(!empty($_POST))
                {
                    if($validator->validates())
                    {
                        // On test si les case on été coché
                        if(!isset($_POST['actif']))
                        {
                            $_POST['actif'] = null;
                        }

                        // On envoie les données dans la base de données
                        $this->Events_CategoriesModel->insert($_POST);

                        // On redirige vers la list des categories
                        header("Location: ".URL_PAGES.'events_categories/index.php?function=admin_index');
                        session_deleteKey('token');
                        die();
                    }
                }

                // Chagrment de la vue
                include ROOT_PAGES."events_categories/view/admin_add.php";
            }

            /**
             * admin_edit
             *
             * Permet d'éditer une catégorie
             *
             * @param $id id de la catégorie
             * @param $token jeton csrf
             *
             **/

            public function admin_edit($id, $token)
            {
                // test si il est admin ou autheur
                if(isset($_SESSION['auth']) && !empty($_SESSION['auth']))
                {
                    if($_SESSION['auth']['permission'] != 'admin' && $_SESSION['auth']['permission'] != 'autheur')
                    {
                        $message = "Accès refusé.";
                        include ROOT.'errors/error403.php';
                        die();
                    }
                }
                else
                {
                    $message = "Accès refusé.";
                    include ROOT.'errors/error403.php';
                    die();
                }

                // On test le token
                if(!isset($token) || empty($token))
                {
                    // On supprime le token
                    session_deleteKey('token');

                    $message = "Accès refusé.";
                    include ROOT.'errors/error403.php';
                    die();
                }
                else
                {
                    if($_SESSION['token'] != $token)
                    {
                        // On supprime le token
                        session_deleteKey('token');

                        $message = "Accès refusé.";
                        include ROOT.'errors/error403.php';
                        die();
                    }
                }

                $categorie = $this->Events_CategoriesModel->firstCategorie($id);

                $validator = new Validator(array(
                    'title' => array(
                        'notEmpty' => array(
                            'rule' => 'notEmpty',
                            'message' => 'Vous devez renseigner ce champ.'
                        ),
                        'alphanumeric' => array(
                            'rule' => 'alphaNumeric',
                            'message' => 'Le nom de la catégorie ne doit comporter que des caractères alphanumériques.'
                        )
                    )
                ), $this->Events_CategoriesModel, true);

                if(!isset($id) && empty($id))
                {
                    session_deleteKey('token');

                    header('Location: '.URL_PAGES.'events_categories/index.php?function=admin_index');
                    session_setFlash("La catégorie n'existe pas.", "alertSuccess");
                    die();
                }
                else
                {
                    if(empty($categorie))
                    {
                        session_deleteKey('token');

                        header('Location: '.URL_PAGES.'events_categories/index.php?function=admin_index');
                        session_setFlash("La catégorie n'existe pas.", "alertError");
                        die();   
                    }
                }

                // Si des données on été poster
                if(!empty($_POST))
                {
                    if($validator->validates())
                    {
                        $this->Events_CategoriesModel->edit($id ,$_POST);

                        session_deleteKey('token');

                        header('Location: '.URL_PAGES.'events_categories/index.php?function=admin_index');
                        session_setFlash('La catégorie à été modifier.', 'alertSuccess');
                        die();
                    }
                }


                // Chargement de la vue
                include ROOT_PAGES.'events_categories/view/admin_edit.php';
            }

            /**
             * admin_delete
             *
             * Permet de supprimer une categorie
             *
             * @param $id id de la catégorie
             * @param $token jeton csrf
             *
             **/
            public function admin_delete($id, $token)
            {

                 // test si il est admin ou autheur
                if(isset($_SESSION['auth']) && !empty($_SESSION['auth']))
                {
                    if($_SESSION['auth']['permission'] != 'admin' && $_SESSION['auth']['permission'] != 'autheur')
                    {
                        $message = "Accès refusé.";
                        include ROOT.'errors/error403.php';
                        die();
                    }
                }
                else
                {
                    $message = "Accès refusé.";
                    include ROOT.'errors/error403.php';
                    die();
                }

                // On test le token
                if(!isset($token) || empty($token))
                {
                    // On supprime le token
                    session_deleteKey('token');

                    $message = "Accès refusé.";
                    include ROOT.'errors/error403.php';
                    die();
                }
                else
                {
                    if($_SESSION['token'] != $token)
                    {
                        // On supprime le token
                        session_deleteKey('token');

                        $message = "Accès refusé.";
                        include ROOT.'errors/error403.php';
                        die();
                    }
                }
                
                $categorie = $this->Events_CategoriesModel->firstCategorie($id);

                if(!isset($id) && empty($id))
                {
                    session_deleteKey('token');

                    header('Location: '.URL_PAGES.'events_categories/index.php?function=admin_index');
                    session_setFlash("La catégorie n'existe pas.", "alertSuccess");
                    die();
                }
                else
                {
                    if(empty($categorie))
                    {
                        session_deleteKey('token');

                        header('Location: '.URL_PAGES.'events_categories/index.php?function=admin_index');
                        session_setFlash("La catégorie n'existe pas.", "alertError");
                        die();   
                    }
                }

                $this->Events_CategoriesModel->delete($id);

                session_deleteKey('token');

                header('Location: '.URL_PAGES.'events_categories/index.php?function=admin_index');
                session_setFlash("La catégorie a bien été supprimer.", "alertSuccess");
                die(); 
            }
    }