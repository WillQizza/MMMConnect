<?php
    class Trends extends Model {
        public function getTrending () {
            return $this->query("SELECT term FROM trends ORDER BY hits DESC LIMIT 8");
        }

        public function addTerms ($body) {

            $stopWords = "a is apple who they then where why what when be an how are you doing today ";
            $stopWords = explode(" ", $stopWords);

            $body = preg_replace("/[^a-zA-Z 0-9]+/", "", $body);

            $wordParts = explode(" ", $body);

            $occurs = array();

            foreach ($wordParts as $wordPart) {
                $valid = true;
                foreach ($stopWords as $stopWord) {
                    if (strtolower($wordPart) == strtolower($stopWord)) {
                        $valid = false;
                        break;
                    }
                }
                if ($valid && strlen($wordPart) > 0) {
                    array_push($occurs, $wordPart);
                }
            }

            
            foreach ($occurs as $word) {
                $this->addTerm($word);
            }

        }

        public function addTerm ($term, $hits = 1) {
            $exists = count($this->query("SELECT * FROM trends WHERE term=:t", array(
                "t" => $term
            ))) > 0;
            if ($exists) {
                $this->query("UPDATE trends SET hits = hits + :h WHERE term=:t", array(
                    "h" => $hits,
                    "t" => $term
                ));
            } else {
                $this->query("INSERT INTO trends (term, hits) VALUES (:t, :h)", array(
                    "t" => $term,
                    "h" => $hits
                ));
            }
        }

        protected function defaults () {
            return array(
                "id" => 0,
                "term" => "",
                "hits" => 0
            );
        }

        protected function format ($data) {
            return $data;
        }

    }
?>