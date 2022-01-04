<?php

class dbjson {
public $jsonArray = [];
////////   read   database   ///////
      function readdb(){
           if(file_exists('db.json')){
                  $readjson = file_get_contents('db.json');
                  $jsonArray = json_decode($readjson, true);
          }
          return $jsonArray;
}
////////////      write   database    ////////////
      function writedb($dbcontent, $jsonArray) {
                if ($dbcontent) {
                $jsonArray[] = $dbcontent;
                file_put_contents('db.json', json_encode($jsonArray, JSON_FORCE_OBJECT));
                }
          return true;
          }

/////////   search in database   /////////////

        function findArray($array, $findValue, $executeKeys){
              $search_result = [];
                    foreach ($array as $key => $value) {
                      if (is_array($array[$key])) {
                        $second_result = $this -> findArray($array[$key], $findValue, $executeKeys);
                        $search_result = array_merge($search_result, $second_result);
                        continue;
                      }
                      if ($value === $findValue) {
                        foreach ($executeKeys as $val){
                          $search_result[] = $array[$val];
                        }
                      }
                    }
                    return $search_result;
            }
///////////////// delete user ////////////////////

            function delete_user($login){

              function index_array_search($search_value, $array){
                  foreach($array as $value){
                      if (array_search($search_value, $value)){
                          return array_search($value, $array);
                          break;
                      }
                  }
              }

                $jsonContent = $this -> readdb();
                $user_id = index_array_search($login, $jsonContent);
                if($user_id != "") {
                    unset($jsonContent[$user_id]);
                    file_put_contents('db.json', json_encode($jsonContent, JSON_FORCE_OBJECT));
                    } else {
                    echo "user not found";
                }
                return true;
            }
}

?>
