<!-- returned items -->
<?php
require 'template/header.php';
?>
<main class="container my-3 my-sm-4">
  <div class="d-flex justify-content-between align-items-end">
    <h1 class="text-warning d-flex align-items-center IBMPlexMonoFont m-0"><ion-icon name="file-tray" class="me-2 page-identificator-icon"></ion-icon>ITENS DEVOLVIDOS</h1>
    <a href="../index.php" class="d-flex align-items-center return-to-home fw-semibold mb-1">Voltar<ion-icon name="arrow-undo" class="ms-1"></ion-icon></a>
  </div>
  <div class="page-title-divider w-100 my-1"></div>
  <span class="text-secondary mb-4 d-block text-center text-sm-start">Nesta página, você encontrará uma lista de todos os itens que foram devolvidos aos seus devidos proprietários(as).</span>
  <?php
  if (isset($_GET['alert'])) {
    switch ($_GET['alert']) {
      case "itemDeleted":
        echo '<div class="alert alert-success d-flex align-items-center justify-content-between fw-semibold alert-max-width mx-auto" role="alert">
              <div class="d-flex align-items-center">      
              <ion-icon name="checkmark-circle-outline" class="alert-icons"></ion-icon>
              <div class="mx-2">O item ' . $_GET['itemName'] . ' foi excluído</div>
              </div>
              <a href="returnedItems.php" class="btn-close"></a>
            </div>';
        break;
      case "deleteItem":
        echo '<div class="alert alert-danger d-flex align-items-center justify-content-between fw-semibold alert-max-width mx-auto" role="alert">
                <div class="d-flex align-items-center">      
                <ion-icon name="warning" class="alert-icons"></ion-icon>
                <div class="mx-2">Você realmente deseja excluir o item ' . $_GET['itemName'] . '? Essa ação não pode ser desfeita.</div>
                </div>
                <form class="d-flex align-items-center" method="post" action="crudValidation\deleteReturnedItemValidation.php">
                <input type="hidden" name="id" value="' . $_GET['itemId'] . '">
                <input type="hidden" name="name" value="' . $_GET['itemName'] . '">
                <button class="btn">
                  <ion-icon name="checkmark-outline"></ion-icon>
                </button>
                </form>
                <a href="returnedItems.php" class="btn">
                <ion-icon name="close-outline"></ion-icon>
                </a>
              </div>';
        break;
    }
  }
  ?>
  <div class="container">
    <?php
    require '../database/dbConfig.php';
    $sql = 'SELECT ri.id, ri.name, ri.description, ri.receiver_name, ri.date_of_return, c.name AS category
            FROM returned_items AS ri
            JOIN categories AS c ON ri.category_id = c.id;';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $returned_items_view = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($returned_items_view) > 0) {
      echo ($_SESSION['role'] == 1) ? '<a href="registerReturnedItem.php" class="fw-semibold add-item-button d-flex align-items-center"><ion-icon name="add-circle-outline" class="me-1 add-item-icon"></ion-icon>Registrar</a>' : null;
    ?>
      <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
          <thead>
            <tr class="text-center align-middle">
              <th>Nome</th>
              <th>Descrição</th>
              <th>Nome do receptor</th>
              <th>Data da devolução</th>
              <th>Categoria</th>
              <?php
              if ($_SESSION['role'] == 1) {
                echo '<th>Ações</th>';
              }
              ?>
            </tr>
          </thead>
          <tbody class="table-group-divider">
            <?php
            foreach ($returned_items_view as $item) {
              echo '<tr class="text-center align-middle">';
              echo '<td>' . $item['name'] . '</td>';
              echo '<td class="text-start description-td-maxwidth">' . $item['description'] . '</td>';
              echo '<td>' . $item['receiver_name'] . '</td>';
              echo '<td class="date-td-minwidth">' . $item['date_of_return'] . '</td>';
              echo '<td>' . $item['category'] . '</td>';
              if ($_SESSION['role'] == 1) {
                echo '<td>
                  <div class="dropdown-center">
                    <ion-icon name="ellipsis-horizontal" class="dropdown-toggle text-center align-middle p-2" type="button" data-bs-toggle="dropdown" aria-expanded="false"></ion-icon>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="crudValidation/editReturnedItem.php" class="btn d-flex align-items-center justify-content-center dropdown-item">
                          <ion-icon name="brush-outline" class="me-1 action-icon"></ion-icon>Editar
                        </a>
                      </li>
                      <li>
                        <button type="button" class="btn d-flex align-items-center justify-content-center dropdown-item" data-bs-toggle="modal" data-bs-target="#moveModal">
                          <ion-icon name="checkbox-outline" class="me-1 action-icon"></ion-icon>Mover
                        </button>
                      </li>
                      <li>
                        <form method="post" action="returnedItems?alert=deleteItem&itemId=' . $item['id'] . '&itemName=' . $item['name'] . '">
                          <button class="btn btn-danger d-flex align-items-center justify-content-center dropdown-item"><ion-icon name="trash" class="me-1 action-icon"></ion-icon>Excluir</button>
                        </form>
                      </li>
                    </ul>
                  </div>
                </td>';
              }
              echo '</tr>';
            }
            ?>
          </tbody>
        </table>
      </div>
    <?php
    } else {
      echo '<div class="alert my-3 text-center align-self-center logo-gray-bg no-items-alert" role="alert"><h4 class="">Não há itens devolvidos cadastrados no momento.<ion-icon name="sad-outline" class="no-items-icon ms-2"></ion-icon></h4></div>';
    }
    ?>
  </div>
</main>
<?php
require 'template/footer.php';
?>