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
        public function getDocumentReference($col, $doc){
            return $this->db->collection($col)->document($doc);
        }
        public function getAllDataWhereRef($col, $link, $op, $ref){
            $docs = $this->db->collection($col)->where($link, $op, $ref)->documents();
            $data = [];
            foreach($docs as $doc){
                $data[] = array_merge(["key"=>$doc->id()], $doc->data());
            }
            return $data;
        }
        public function getAllData($col){
            $docs = $this->db->collection($col)->documents();
            $data = [];
            foreach($docs as $doc){
                $data[] = array_merge(["key"=>$doc->id()], $doc->data());
            }
            return $data;            
        }
        public function getData($col, $docId){
            $doc = $this->db->collection($col)->document($docId);
            return array_merge(["key"=>$doc->id()], $doc->snapshot()->data());
            // return ["key"=>$doc->id(), "data"=>$doc->snapshot()->data()];
        }
        public function updateColDocument($col, $doc, $data){
            $field = [];

            foreach($data as $k=>$v){
                $field[] = ["path"=>$k, "value"=>$v];
            }
            $this->db->collection($col)->document($doc)->update($field);
        }
        public function deleteColDocument($col, $doc){
            echo $col.$doc;
            $this->db->collection($col)->document($doc)->delete();
        }
    }
?>