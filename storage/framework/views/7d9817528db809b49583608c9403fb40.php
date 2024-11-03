<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Laravel Crud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    
    <div class="bg-dark py-3">
      <h3 class="text-white text-center">Simple Laravel 11 CRUD</h3>
    </div>
    <div class="container">
      <div class="row justify-content-center mt-4">
        <div class="col-md-10 d-flex justify-content-end">
          <a href="<?php echo e(route('products.create')); ?>" class="btn btn-dark">Create</a>
        </div>
      </div>
      <div class="row d-flex justify-content-center">
        <?php if(Session::has('success')): ?>
        <div class="col-md-10 mt-4">
          <div class="alert alert-success">
              <?php echo e(Session::get('success')); ?>

            </div>
          </div>
        <?php endif; ?>
        <div class="col-md-10">
          <div class="card borde-0 shadow-lg my-4">
            <div class="card-header bg-dark">
              <h3 class="text-white">Products</h3>
            </div>
            <div class="card-body">
              <table class="table">
                <tr>
                  <th>ID</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Sku</th>
                  <th>Price</th>
                  <th>Created at</th>
                  <th>Action</th>
                </tr>
                <?php if($products->isNotEmpty()): ?>
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td><?php echo e($product->id); ?></td>
                  <td>
                    <?php if($product->image != ""): ?>
                      <img width="50" src="<?php echo e(asset('uploads/products/'.$product->image)); ?>" alt="">
                    <?php endif; ?>
                  </td>
                  <td><?php echo e($product->name); ?></td>
                  <td><?php echo e($product->sku); ?></td> 
                  <td>$<?php echo e($product->price); ?></td>
                  <td><?php echo e(\Carbon\Carbon::parse($product->created_at)->format('d M,Y')); ?></td>
                  <td>
                    <a href="<?php echo e(route('products.edit',$product->id)); ?>" class="btn btn-dark">Edit</a>
                    <a href="#" class="btn btn-danger" onclick="deleteProduct(<?php echo e($product->id); ?>)">Delete</a>
                    <form id="delete-product-from-<?php echo e($product->id); ?>" action="<?php echo e(route('products.destroy',$product->id)); ?>" method="post">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('delete'); ?>
                    </form>
                  </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    
    
    </script>

    <script>
        //Asking before deleting
        function deleteProduct(id){
          console.log('hello');
          if(confirm("Are you sure you want to delete product?")){
            document.getElementById("delete-product-from-"+id).submit();
          }
        }
  
    </script>
  </body>
</html><?php /**PATH C:\xampp\htdocs\crud-app\resources\views/products/list.blade.php ENDPATH**/ ?>