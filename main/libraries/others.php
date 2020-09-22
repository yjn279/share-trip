<?php


  class Good extends DataBase {


    function get(int $user, int $plan) {

      $stmt = $this->pdo -> prepare('SELECT * FROM good WHERE user_id=:user AND plan_id=:plan');
      $stmt -> bindParam(':user', $user, PDO::PARAM_INT);
      $stmt -> bindParam(':plan', $plan, PDO::PARAM_INT);
      $stmt -> execute();
    
      return $stmt -> fetch();
    
    }
    

    function add(int $user, int $plan) {

      $id = $this -> get($user, $plan);

      if (!isset($id)) {

        $sql = 'INSERT INTO good (user_id, plan_id) VALUES(:user, :plan)';
        $stmt = $this->pdo -> prepare($sql);
        $stmt -> bindParam(':user', $user, PDO::PARAM_INT);
        $stmt -> bindParam(':plan', $plan, PDO::PARAM_INT);
        $stmt -> execute();

        return True;

      } else {
        return False;
      }

    }


    function delete(int $user, int $plan) {

      $id = $this -> get($user, $plan);

      if (isset($id)) {

        $sql = 'DELETE FROM good WHERE good_id=:id';
        $stmt = $this->pdo -> prepare($sql);
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> execute();

        return True;

      } else {
        return False;
      }

    }
  }
?>