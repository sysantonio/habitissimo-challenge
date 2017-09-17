<?php

$app->group('/api/', function () {

    $this->get('test', function ($req, $res, $args) {
        return $res->getBody()
            ->write('Hello Users');
    });
    // get all todos
    $this->get('todos', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM tasks ORDER BY task");
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });

// Retrieve todo with id
    $this->get('todo/[{id}]', function ($request, $response, $args) {
        $sth  = $this->table->find(id);
        return $this->response->withJson($sth);
    });


// Search for todo with given search teram in their name
    $this->get('todos/search/[{query}]', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM tasks WHERE UPPER(task) LIKE :query ORDER BY task");
        $query = "%".$args['query']."%";
        $sth->bindParam("query", $query);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });

// Add a new todo
    $this->post('todo', function ($request, $response) {
        $input = $request->getParsedBody();
        $sql = "INSERT INTO tasks (task) VALUES (:task)";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("task", $input['task']);
        $sth->execute();
        $input['id'] = $this->db->lastInsertId();
        return $this->response->withJson($input);
    });


// DELETE a todo with given id
    $this->delete('todo/[{id}]', function ($request, $response, $args) {
        $sth = $this->db->prepare("DELETE FROM tasks WHERE id=:id");
        $sth->bindParam("id", $args['id']);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });

// Update todo with given id
    $this->put('todo/[{id}]', function ($request, $response, $args) {
        $input = $request->getParsedBody();
        $sql = "UPDATE tasks SET task=:task WHERE id=:id";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("id", $args['id']);
        $sth->bindParam("task", $input['task']);
        $sth->execute();
        $input['id'] = $args['id'];
        return $this->response->withJson($input);
    });

});

