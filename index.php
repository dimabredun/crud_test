<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\Service\SqLiteRecordStorage;
use App\Controller\TestController;

require_once __DIR__ . '/vendor/autoload.php';

$configuration = [
    'dsn' => 'mysql:host=127.0.0.1;dbname=record;charset=utf8mb4',
    'user' => 'user_record',
    'password' => 'Pass*001'
];

$test = new TestController($configuration);

$name = $_POST['name'] ?? null;
$author = $_POST['author'] ?? null;
$genre = $_POST['genre'] ?? null;
$id = $_GET['id'] ?? null;

$mysqlRecords = $test->CrudMysql()->getAll();
//$sqliteRecords = $test->CrudSqlite()->getAll();

if(isset($_POST['add'])) {
//    $test->CrudSqlite()->save($name, $author, $genre);
    $test->CrudMysql()->save($name, $author, $genre);
    if (true) {
        header("location: ". $_SERVER['HTTP_REFERER']);
    }
}

if(isset($_POST['edit'])) {
//    $test->CrudSqlite()->update($name, $author, $genre, $id);
    $test->CrudMysql()->update($name, $author, $genre, $id);
    if (true) {
        header("location: ". $_SERVER['HTTP_REFERER']);
    }
}

if(isset($_POST['delete'])) {
//    $test->CrudSqlite()->delete($id);
    $test->CrudMysql()->delete($id);
    if (true) {
        header("location: ". $_SERVER['HTTP_REFERER']);
    }
}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Records CRUD</title>
  </head>
  <body>
  <div class="container">
      <div class="row">
          <div class="col-12">
              <button class="btn btn-success mt-2" data-toggle="modal" data-target="#create">Add</button>
              <table class="table table-striped table-hover mt-2">
                  <thead class="thead-dark">
                      <th>ID</th>
                      <th>Name</th>
                      <th>Author</th>
                      <th>Genre</th>
                      <th>Action</th>
                  </thead>
                  <tbody>
                  <?php foreach ($mysqlRecords as $record):
//                        foreach ($sqliteRecords as $record):
                            ?>
                  <tr>
                      <td><?= $record->id ?></td>
                      <td><?= $record->name ?></td>
                      <td><?= $record->author ?></td>
                      <td><?= $record->genre ?></td>
                      <td><a href="?edit=<?=$record->id?>" class="btn btn-success" data-toggle="modal" data-target="#editModal<?=$record->id?>">Upd</a>
                          <a href="" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?=$record->id?>">Del</a></td>
                  </tr>
                   <!--Modal edit-->
                      <div class="modal fade" id="editModal<?= $record->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content shadow">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Edit row #<?= $record->id ?> </h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      <form action="?id=<?=$record->id?>" method="post">
                                          <div class="form-group">
                                              <small>Name</small>
                                              <input type="text" class="form-control" name="name" value="<?= $record->name; ?>">
                                          </div>
                                          <div class="form-group">
                                              <small>Author</small>
                                              <input type="text" class="form-control" name="author" value="<?= $record->author; ?>">
                                          </div>
                                          <div class="form-group">
                                              <small>Genre</small>
                                              <input type="text" class="form-control" name="genre" value="<?= $record->genre; ?>">
                                          </div>
                                          <div class="modal-footer">
                                              <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                              <button type="submit" class="btn btn-primary" name="edit">Save</button>
                                          </div>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <!--Modal edit-->

                    <!-- Modal delete-->
                      <div class="modal fade" id="deleteModal<?=$record->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content shadow">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Delete row #<?=$record->id?></h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                      <form action="?id=<?=$record->id?>" method="post">
                                          <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>

                  <?php endforeach;?>
                  </tbody>
              </table>
          </div>
      </div>
  </div>
  <!-- Modal delete-->

  <!-- Modal create-->
  <div class="modal fade" id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add row</h5>
                  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form action="" method="post">
                      <div class="form-group">
                          <small>Name</small>
                          <input type="text" class="form-control" name="name">
                      </div>
                      <div class="form-group">
                          <small>Author</small>
                          <input type="text" class="form-control" name="author">
                      </div>
                      <div class="form-group">
                          <small>Genre</small>
                          <input type="text" class="form-control" name="genre">
                      </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="add">Save</button>
                  </form>
              </div>
          </div>
      </div>
  </div>
  <!-- Modal create-->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
