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
                        'rule' => 'alphanumeric',
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

            var_dump($_POST);

            // Chargement de la vue
            include ROOT_PAGES.'events/view/admin_add.php'; 
        }
    }