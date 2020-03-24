<?php
    include_once "./vendor/autoload.php";
    use Kreait\Firebase\Factory;
    $GFirestore = new class{
        protected $factory;
        protected $firestore;
        protected $db;
        public function __construct()
        {
            $this->factory = (new Factory())
            ->withServiceAccount("./chatbot-nyp-firebase-adminsdk.json")
            ->withDatabaseUri("https://chatbot-nyp.firebaseio.com/programme");
            $this->firestore = $this->factory->createFirestore();
            $this->db = $this->firestore->database();
            // print var_dump($this->firestore->collection("programme")->documents());
        }

        public function getCollections($collection){
            return $this->db->collection($collection)->documents();
        }
        public function getDocumentFromCollections($collection, $docId){
            return $this->db->collection($collection)->document($docId);
        }
        public function addToCollection($collection, $options){
            $doc = $options["full_name"];
            preg_match_all('/(?<=\s|^)[a-z]/i', $doc, $matches);
            $this->db->collection($collection)->document(strtolower(implode("", $matches[0])))->set($options);
        }
        public function deleteFromCollection($collection, $doc){
            $this->db->collection($collection)->document($doc)->delete();
        }
    }
?>