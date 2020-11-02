<div class="row">
  <?php 
    $index = 0;
   ?>
  <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-6">
      <div class="form-group">
          <?php 
            $stringFormat =  strtolower(str_replace(' ', '', $item));
           ?>
          <label for="input<?=$stringFormat?>" class="col-sm-3 control-label"><?php echo e($item); ?></label>
          <div class="col-sm-9">
            <input value="<?php echo e(isset($oldVals) ? $oldVals[$index] : ''); ?>" type="text" class="form-control" name="<?=$stringFormat?>" id="input<?=$stringFormat?>" placeholder="<?php echo e($item); ?>">
          </div>
      </div>
    </div>
  <?php 
    $index++;
   ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>