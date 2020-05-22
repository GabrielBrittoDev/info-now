<?php


class User
{


    public function create($request){
       $conn =  Connection::getConn();
       $sql = 'INSERT INTO users (name, username, password, email) VALUES (?,?,?,?)';

       $stmt = $conn->prepare($sql);

        $stmt->bindValue(1, $request['name'], \PDO::PARAM_STR);
        $stmt->bindValue(2, $request['username'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $request['password'], PDO::PARAM_STR);
        $stmt->bindValue(4, $request['email'], PDO::PARAM_STR);


        if ($stmt->execute() > 0){
            unset($request->confirm_password);
            $request->id = $conn->lastInsertId();
            $_SESSION['user'] = $request;
            return ['message'=> 'Usuário cadastrado com sucesso!'];
        } else {
            throw new Exception('Erro ao cadastar usuário');
        }


    }

    public function update(){

    }


    public function delete(){

    }

    public static function all(){

    }

    public function where($column, $conditional, $param){
        try {
            $conn =  Connection::getConn();
            $sql = 'SELECT * FROM users WHERE :column :conditional :param';

            $stmt = $conn->prepare($sql);

            $stmt->bindValue('column', $column, \PDO::PARAM_INT);
            $stmt->bindValue('conditional', $conditional, \PDO::PARAM_INT);
            $stmt->bindValue('param', $param, \PDO::PARAM_INT);

            $stmt->execute();

        } catch (\Exception $e){
            throw new Exception('Erro ao procurar usuario');
        }
    }

    public function find(int $id){
        try {
            $conn =  Connection::getConn();
            $sql = 'SELECT * FROM users WHERE id = ?';

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(1, $id, \PDO::PARAM_INT);

            $stmt->execute();

            if ($row = $stmt->fetchObject('User')) {
                $response[] = $row;
            }

            if (isset($response)){
                return $response;
            } else {
                throw new Exception('Usuario não encontrado');
            }
        } catch (\Exception $e){
            throw new Exception('Erro ao procurar usuario');
        }
    }


}