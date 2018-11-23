<?php

// get all todos
    $app->get('/empleados', function ($request, $response,$arg) {
         $sth = $this->db->prepare("SELECT * FROM tablaprueba");
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });
 
    // Retrieve todo with id 
    $app->get('/empleados/[{legajo}]', function ($request, $response, $args) {
        if($arg ['legajo']>1500 || ['legajo']<0){
            return $this->response->withJson($response, 400);   
            
        }
        $sth = $this->db->prepare("SELECT * FROM tablaprueba WHERE legajo=:legajo");
        $sth->bindParam("legajo", $args['legajo']);
        $sth->execute();
        $empleado = $sth->fetchObject();
        if($empleado)
            return $this->response->withJson($empleado, 200);
        else{
            $response = [];
            $response["message"] = "no encontre el legajo: ".$args['legajo'];
            return $this->response->withJson($response, 404);
        }
        
    });
 
 
    // Search for todo with given search teram in their name
    $app->get('/empleados/buscar/[{query}]', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT * FROM tablaprueba WHERE UPPER(tablaprueba) LIKE :query ORDER BY tablaprueba");
        $query = "%".$args['query']."%";
        $sth->bindParam("query", $query);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response-> withJson($todos);
    });
 
    // Add a new todo
    $app->post('/empleados', function ($request, $response) {
        
        $legajo=$request->getParam('legajo');
        if($legajo > 1500 && $legajo<0 ) {
            return $this->response->withJson($response, 400); 
        }
        $nombre=$request->getParam('nombre');
        
         if ($nombre.length>0 && $nombre.length<100) {
            return $this->response->withJson($response, 400);
          } 
        
          $apellido=$request->getParam('apellido');

        if ($apellido.length>0 && $apellido.length<100) {
            return $this->response->withJson($response, 400);
         } 

         $telefono=$request->getParam('telefono');
        if ($telefono.length>0 && $telefono.length<100) {
            return $this->response->withJson($response, 400);
         } 
         $equipo=$request->getParam('equipo');

        if ($equipo.length>0 && $equipo.length<100) {
            return $this->response->withJson($response, 400);
         } 
         $usuario=$request->getParam('usuario');
        if ($usuario.length>0 && $usuario.length<100) {
            return $this->response->withJson($response, 400);
         } 
       
         if($empleados){
            return $this->response->withJson($empleados, 200);
         }

        $input = $request->getParsedBody();
        $sql = "INSERT INTO tablaprueba (legajo,nombre,apellido,telefono,equipo,usuario) VALUES (:legajo,:nombre,:apellido,:telefono,:equipo,:usuario)";
         $sth = $this->db->prepare($sql);

         $sth->bindParam('legajo',$legajo);
         $sth->bindParam('nombre',$nombre);
         $sth->bindParam('apellido',$apellido);
         $sth->bindParam('telefono',$telefono);
         $sth->bindParam('equipo',$equipo);
         $sth->bindParam('usuario',$usuario);

        //$sth->bindParam("agenda", $input['agenda']);
        $sth->execute();
        
        return $this->response->withJson($input,201);
    });
        
 
    // DELETE a todo with given id
    $app->delete('/empleados/[{legajo}]', function ($request, $response, $args) {
         $sth = $this->db->prepare("DELETE FROM tablaprueba 
         WHERE legajo=:legajo");
        $sth->bindParam("legajo", $args['legajo']);
        $sth->execute();
        $user= $sth->fetchAll();
        return $this->response->withJson($user);
    });
 
    // Update todo with given id
    $app->put('/empleados/[{legajo}]', function ($request, $response, $args) {
        
        $legajo=$request->getParam('legajo');
        $nombre=$request->getParam('nombre');
        $apellido=$request->getParam('apellido');
        $telefono=$request->getParam('telefono');
        $equipo=$request->getParam('equipo');
        $usuario=$request->getParam('usuario');
       
        $input = $request->getParsedBody();
        $sql = "UPDATE tablaprueba SET 

                   legajo=:legajo,   
                   nombre=:nombre,
                   apellido=:apellido,
                   telefono=:telefono,
                   equipo=:equipo,
                   usuario=:usuario
        
                 WHERE legajo=:legajo";

         $sth = $this->db->prepare($sql);
        
         $sth->bindParam(':legajo',$legajo);
         $sth->bindParam(':nombre',$nombre);
         $sth->bindParam(':apellido',$apellido);
         $sth->bindParam(':telefono',$telefono);
         $sth->bindParam(':equipo',$equipo);
         $sth->bindParam(':usuario',$usuario);

        $sth->bindParam(":legajo", $args['legajo']);
       /* $sth->bindParam("agenda", $input['agenda']);*/
       //var_dump($sth);
        $sth->execute();
        //$input['idagenda'] = $args['idagenda'];
        return $this->response->withJson($input,200);
    });
    ?>
    