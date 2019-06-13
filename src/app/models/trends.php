<?php
    class Trends extends Model {
        public function getTrending () {
            return $this->query("SELECT term FROM trends ORDER BY hits DESC LIMIT 8");
        }

        public function addTerms ($body) {

            $stopWords = "i me my myself we our ours ourselves you your yours yourself yourselves he him his himself she her hers herself it its itself they them their theirs themselves what which who whom this that these those am is are was were be been being have has had having do does did doing a an the and but if or because as until while of at by for with about against between into through during before after above below to from up down in out on off over under again further then once here there when where why how all any both each few more most other some such no nor not only own same so than too very so to can will just don should now";
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