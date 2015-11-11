<?php
    $presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
?>

<div class="pagination">
    <ul class="pull left">
        <li>
         显示
        <?php echo $paginator->getFrom(); ?>
        -
        <?php echo $paginator->getTo(); ?>
        共
        <?php echo $paginator->getTotal(); ?>
        条记录
        </li>
    </ul>

    <ul class="pull-right">
        <?php echo $presenter->render(); ?>
    </ul>
</div>
