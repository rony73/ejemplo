<?php

// get all todos
    $app->get('/users', function ($request, $response,$arg) {
         $sth = $this->db->prepare("SELECT * FROM agenda");
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });
 
    // Retrieve todo with id 
    $app->get('/users/[{idagenda}]', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT * FROM agenda WHERE idagenda=:idagenda");
        $sth->bindParam("idagenda", $args['idagenda']);
        $sth->execute();
        $todos = $sth->fetchObject();
        return $this->response->withJson($todos);
    });
 
 
    // Search for todo with given search teram in their name
    $app->get('/users/buscar/[{query}]', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT * FROM agenda WHERE UPPER(agenda) LIKE :query ORDER BY agenda");
        $query = "%".$args['query']."%";
        $sth->bindParam("query", $query);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });
 
    // Add a new todo
    $app->post('/users', function ($request, $response) {
        $nombre=$request->getParam('nombre');
        $telefono=$request->getParam('telefono');

        $input = $request->getParsedBody();
        $sql = "INSERT INTO agenda (nombre,telefono) VALUES (:nombre,:telefono)";
         $sth = $this->db->prepare($sql);

         $sth->bindParam('nombre',$nombre);
         $sth->bindParam('telefono',$telefono);

        //$sth->bindParam("agenda", $input['agenda']);
        $sth->execute();
        $input['idagenda'] = $this->db->lastInsertId();
        return $this->response->withJson($input);
    });
        
 
    // DELETE a todo with given id
    $app->delete('/users/[{idagenda}]', function ($request, $response, $args) {
         $sth = $this->db->prepare("DELETE FROM agenda 
         WHERE idagenda=:idagenda");
        $sth->bindParam("idagenda", $args['idagenda']);
        $sth->execute();
        $user= $sth->fetchAll();
        return $this->response->withJson($user);
    });
 
    // Update todo with given id
    $app->put('/users/[{idagenda}]', function ($request, $response, $args) {
        
        $nombre=$request->getParam('nombre');
        $telefono=$request->getParam('telefono');
       
        $input = $request->getParsedBody();
        $sql = "UPDATE agenda SET 
                       
                   nombre=:nombre,
                   telefono=:telefono
        
                 WHERE idagenda=:idagenda";

         $sth = $this->db->prepare($sql);

         $sth->bindParam(':nombre',$nombre);
         $sth->bindParam(':telefono',$telefono);

        $sth->bindParam(":idagenda", $args['idagenda']);
       /* $sth->bindParam("agenda", $input['agenda']);*/
       //var_dump($sth);
        $sth->execute();
        //$input['idagenda'] = $args['idagenda'];
        return $this->response->withJson($input);
    });
    ?>
    