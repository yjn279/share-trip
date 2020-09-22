<?php


  class Good extends DataBase {


    function get(int $user, int $plan) {

      $stmt = $this->pdo -> prepare('SELECT good_id FROM good WHERE user_id=:user AND plan_id=:plan');
      $stmt -> bindParam(':user', $user, PDO::PARAM_INT);
      $stmt -> bindParam(':plan', $plan, PDO::PARAM_INT);
      $stmt -> execute();
      
      $id = $stmt -> fetch();

      if (is_array($id)) return (int) $id['good_id'];
      else return -1;
    
    }
    

    function add(int $user, int $plan) {

      $id = $this -> get($user, $plan);

      if ($id < 0) {

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

      if ($id >= 0) {

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