<?php
	/**
	 * File : pages/events/EventsController.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Permet la gestion des events
	 **/

    include ROOT.'elements/agenda.php';

    class EventsController extends Controller
    {
        /**
         * La page d'accueil des evenement
         **/
        public function index()
        {
            $categories = $this->EventsModel->getCategories();

            /**
             * permet de déterminer l'etat du calendrier
             **/

            $searchDate = array();

            if(empty($_POST))
            {
                $searchDate = array(
                    'month' => $GLOBALS['date']['month'],
                    'years' => $GLOBALS['date']['years']
                );
            }
            else
            {
                $searchDate = array(
                    'month' => $_POST['month'],
                    'years' => $_POST['years']
                );
            }

            $calendrier = generateCalendar($searchDate['month'], $searchDate['years']);

            // Récupere les events en fonction du mois et de l'année

            // On recherche la categorie par défaut
            $defaultCategorie = $this->EventsModel->defaultCategorie();

            if(!isset($_POST['categories']))
            {
                $_POST['categories'] = $defaultCategorie->id;
            }

            $events = $this->EventsModel->getEvents($searchDate['month'], $searchDate['years'], $_POST['categories']);

            // Chargement de la vue
            include ROOT_PAGES.'events/view/index.php';           
        }

        /**
         * admin_index
         *
         * Affiche tous les événement sur le site
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

            // On récupere tous les événement existant sur le site
            $events = $this->EventsModel->allEvents();

            // Chargement de la vue
            include ROOT_PAGES.'events/view/admin_index.php';
        }

        /**
         * admin_add
         *
         * @param : $token : jeton csrf
         **/
        public function admin_add($token)
        {
            // On charge le model events_categories
            require ROOT_PAGES.'events_categories/events_categoriesModel.php';

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

            // Validation des données transmise
            $validator = new validator(array(
                'title' => array(
                    'notEmpty' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Vous devez renseigner ce champ.'
                    ),
                    'alphanumeric' => array(
                        'rule' => 'alphanumeric',
                        'message' => "Le nom de l'événement ne doit comporter que des caractères alphanumérique."
                    )
                ),
                'date_start' => array(
                    'notEmpty' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Vous devez renseigner ce champ.'
                    ),
                    'date' => array(
                        'rule' => 'date',
                        'message' => "La date n'est pas au bon format"
                    )
                ),
                'heure_start' => array(
                    'notEmpty' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Vous devez renseigner ce champ.'
                    ),
                    'time' => array(
                        'rule' => 'time',
                        'message' => "L'heure n'est pas au bon format."
                    )
                ),
                'date_end' => array(
                    'notEmpty' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Vous devez renseigner ce champ.'
                    ),
                    'date' => array(
                        'rule' => 'date',
                        'message' => "La date n'est pas au bon format"
                    )
                ),
                'heure_end' => array(
                    'notEmpty' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Vous devez renseigner ce champ.'
                    ),
                    'time' => array(
                        'rule' => 'time',
                        'message' => "L'heure n'est pas au bon format."
                    )
                ),
                'description' => array(
                    'notEmpty' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Vous devez renseigner ce champ.'
                    ),
                    'alphanumeric' => array(
                        'rule' => 'alphanumeric',
                        'message' => "La description ne doit comporter que des caractères alphanumerique."
                    )
                ),
                'lieu' => array(
                    'notEmpty' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Vous devez renseigner ce champ.'
                    ),
                    'alphanumeric' => array(
                        'rule' => 'alphanumeric',
                        'message' => "La description ne doit comporter que des caractères alphanumerique."
                    )
                ),
                'adresse' => array(
                    'notEmpty' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Vous devez renseigner ce champ.'
                    ),
                    'alphanumeric' => array(
                        'rule' => 'alphanumeric',
                        'message' => "La description ne doit comporter que des caractères alphanumerique."
                    )
                ), 
                'mail' => array(
                    'mail' => array(
                        'rule' => 'mail',
                        'message' => "L'e-mail n'est pas valide."
                    )
                ), 
                'contact' => array(
                    'notEmpty' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Vous devez renseigner ce champ.'
                    ),
                    'alphanumeric' => array(
                        'rule' => 'alphanumeric',
                        'message' => "La description ne doit comporter que des caractères alphanumerique."
                    )
                ),
                'phone' => array(
                    'notEmpty' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Vous devez renseigner ce champ.'
                    ),
                    'phone' => array(
                        'rule' => 'phone',
                        'message' => "Le numéro de téléphone n'est pas valide."
                    )
                )          
            ), $this->EventsModel, true);

            // permet l'affichage des categorie dans le formulaire
            $events_categories = new Events_CategoriesModel('events_categories');
            $categories = $events_categories->getCategories();

            // Si le formulaire est validé on test qu'il n'y ait pas d'erreur dans le formulaire
            if(!empty($_POST))
            {
                if($validator->validates())
                {
                    // On test si on à cocher la case
                    if(!isset($_POST['actif']))
                    {
                        $_POST['actif'] = null;
                    }

                    // On sauvegarde les données dans la base
                    $this->EventsModel->add(array(
                        'title' => $_POST['title'],
                        'date_start' => $_POST['date_start'],
                        'date_end' => $_POST['date_end'],
                        'heure_start' => $_POST['heure_start'],
                        'heure_end' => $_POST['heure_end'],
                        'description' => $_POST['description'],
                        'lieu' => $_POST['lieu'],
                        'category_id' => $_POST['categories'],
                        'contact' => $_POST['contact'],
                        'adresse' => $_POST['adresse'],
                        'mail' => $_POST['mail'],
                        'phone' => $_POST['phone'],
                        'actif' => $_POST['actif']
                    ));
                }

                // On supprime le token et on redirige sur la liste des événement
                session_deleteKey('token');
                header('Location: '.URL_PAGES.'events/index.php?function=admin_index');
                session_setFlash("L'événement a bien été crée.", 'alertSuccess');
                die();
            }
            // Chargement de la vue
            include ROOT_PAGES.'events/view/admin_add.php'; 
        }

        /**
         * admin_delete
         *
         * permet de supprimer un événement
         *
         * @param : $id : id de l'événement
         * @param  : $token : jeton csrf
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
            
            // On test si l'évenement existe
            $eventsExist = $this->EventsModel->first($id);

            if(isset($id) && !empty($id))
            {
                if(!empty($eventsExist))
                {
                    // On supprime l'évent, le token et on redirige sur la liste des évents
                    $this->EventsModel->delete($id);
                    session_deleteKey('token');  
                    header('Location: '.URL_PAGES.'events/index.php?function=admin_index');
                    session_setFlash("L'événement a bien été supprimé.", "alertSuccess");
                }
                else
                {
                    session_deleteKey('token');
            
                    header('Location: '.URL_PAGES.'news/index.php?function=admin_index');
                    session_setFlash("L'actualité n'existe pas.", 'alertError');
                    die();
                }
            }
            else
            {
                session_deleteKey('token');
                    
                header('Location: '.URL_PAGES.'news/index.php?function=admin_index');
                session_setFlash("L'actualité n'existe pas.", 'alertError');
                die();
            }  
        }

        /**
         * admin_edit
         *
         * Permet d'éditer un événement
         *
         * @param : $token : jeton csrf
         * @param : $id : id de la news à editer
         **/
        public function admin_edit($id, $token)
        {
            // On charge le model events_categories
            require ROOT_PAGES.'events_categories/events_categoriesModel.php';

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
            
            $eventExist = $this->EventsModel->first($id);

            // permet l'affichage des categorie dans le formulaire
            $events_categories = new Events_CategoriesModel('events_categories');
            $categories = $events_categories->getCategories();

            $validator = new Validator(array(
                    'title' => array(
                    'notEmpty' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Vous devez renseigner ce champ.'
                    ),
                    'alphanumeric' => array(
                        'rule' => 'alphanumeric',
                        'message' => "Le nom de l'événement ne doit comporter que des caractères alphanumérique."
                    )
                ),
                'date_start' => array(
                    'notEmpty' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Vous devez renseigner ce champ.'
                    ),
                    'date' => array(
                        'rule' => 'date',
                        'message' => "La date n'est pas au bon format"
                    )
                ),
                'heure_start' => array(
                    'notEmpty' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Vous devez renseigner ce champ.'
                    ),
                    'time' => array(
                        'rule' => 'time',
                        'message' => "L'heure n'est pas au bon format."
                    )
                ),
                'date_end' => array(
                    'notEmpty' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Vous devez renseigner ce champ.'
                    ),
                    'date' => array(
                        'rule' => 'date',
                        'message' => "La date n'est pas au bon format"
                    )
                ),
                'heure_end' => array(
                    'notEmpty' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Vous devez renseigner ce champ.'
                    ),
                    'time' => array(
                        'rule' => 'time',
                        'message' => "L'heure n'est pas au bon format."
                    )
                ),
                'description' => array(
                    'notEmpty' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Vous devez renseigner ce champ.'
                    ),
                    'alphanumeric' => array(
                        'rule' => 'alphanumeric',
                        'message' => "La description ne doit comporter que des caractères alphanumerique."
                    )
                ),
                'lieu' => array(
                    'notEmpty' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Vous devez renseigner ce champ.'
                    ),
                    'alphanumeric' => array(
                        'rule' => 'alphanumeric',
                        'message' => "La description ne doit comporter que des caractères alphanumerique."
                    )
                ),
                'adresse' => array(
                    'notEmpty' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Vous devez renseigner ce champ.'
                    ),
                    'alphanumeric' => array(
                        'rule' => 'alphanumeric',
                        'message' => "La description ne doit comporter que des caractères alphanumerique."
                    )
                ), 
                'mail' => array(
                    'mail' => array(
                        'rule' => 'mail',
                        'message' => "L'e-mail n'est pas valide."
                    )
                ), 
                'contact' => array(
                    'notEmpty' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Vous devez renseigner ce champ.'
                    ),
                    'alphanumeric' => array(
                        'rule' => 'alphanumeric',
                        'message' => "La description ne doit comporter que des caractères alphanumerique."
                    )
                ),
                'phone' => array(
                    'notEmpty' => array(
                        'rule' => 'notEmpty',
                        'message' => 'Vous devez renseigner ce champ.'
                    ),
                    'phone' => array(
                        'rule' => 'phone',
                        'message' => "Le numéro de téléphone n'est pas valide."
                    )
                )
            ), $this->EventsModel, 'events', true);
            
            if(isset($id) && !empty($id))
            {
                if(!empty($eventExist))
                {
                    if(!empty($_POST))
                    {
                        if($validator->validates())
                        {
                            if(!isset($_POST['actif']))
                            {
                                $_POST['actif'] = null;
                            }

                            $this->EventsModel->edit(array(
                                'title' => $_POST['title'],
                                'date_start' => $_POST['date_start'],
                                'date_end' => $_POST['date_end'],
                                'heure_start' => $_POST['heure_start'],
                                'heure_end' => $_POST['heure_end'],
                                'description' => $_POST['description'],
                                'lieu' => $_POST['lieu'],
                                'categories' => $_POST['categoriesId'],
                                'contact' => $_POST['contact'],
                                'adresse' => $_POST['adresse'],
                                'mail' => $_POST['mail'],
                                'phone' => $_POST['phone'],
                                'actif' => 1,
                                'id' => $id
                            ));

                            // On redirige vers la list des menus
                            session_deleteKey('token');
            
                            header('Location: '.URL_PAGES.'events/index.php?function=admin_index');
                            session_setFlash("L'événement à bien été modifié.", 'alertSuccess');
                            die();
                        }
                    }
                }
                else
                {
                    session_deleteKey('token');
            
                    header('Location: '.URL_PAGES.'events/index.php?function=admin_index');
                    session_setFlash("L'événement n'existe pas.", 'alertError');
                    die();
                }
            }
            else
            {
                session_deleteKey('token');
                    
                header('Location: '.URL_PAGES.'news/index.php?function=admin_index');
                session_setFlash("L'événement n'existe pas.", 'alertError');
                die();
            }
        
            // Chargement de la vue
            include ROOT_PAGES.'events/view/admin_edit.php';
        }
    }