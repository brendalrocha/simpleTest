<script>
    $(document).ready(function() {
        $(".delete").click(function() {
            if (window.confirm("Confirm?")) {
                window.location = "index.php?product=destroy&id=" + this.dataset.value;
            }
        });
    });
</script>

<div class="container">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Manage Products</h2>
                </div>
                <div class="col-sm-6">
                    <a href="index.php?product=create" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Add New Product</span></a>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $products = $data['products']; ?>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><?php echo $product->getId(); ?></td>
                        <td><a href="index.php?product=show&id=<?php echo $product->getId(); ?>"><?= $product->getName(); ?></a></td>
                        <td><img src="<?php echo ($product->getImage() ? $product->getImage() : './assets/images/noimage.png') ?>" class="list-img" alt=""></td>
                        <td><?php echo '$'.$product->getPrice(); ?></td>
                        <td><?php echo $product->getCategoryName(); ?></td>
                        <td>
                            <a href="index.php?product=edit&id=<?= $product->getId(); ?>" class="edit"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                            <a href="#" class="delete" data-value="<?= $product->getId() ?>"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>