<?php $__env->startSection('action-content'); ?>
        <!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="box-title">List of users</h3>
                </div>
                <div class="col-sm-4">
                    <a class="btn btn-primary" href="<?php echo e(route('user-management.create')); ?>">Add new user</a>
                </div>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
            </div></div>
            <form method="POST" action="<?php echo e(route('user-management.search')); ?>">
                <?php echo e(csrf_field()); ?>

                <?php $__env->startComponent('layouts.search', ['title' => 'Search']); ?>
                <?php $__env->startComponent('layouts.two-cols-search-row', ['items' => ['User Name', 'First Name'],
                'oldVals' => [isset($searchingVals) ? $searchingVals['username'] : '', isset($searchingVals) ? $searchingVals['firstname'] : '']]); ?>
                <?php echo $__env->renderComponent(); ?>
<p></p>
                <?php $__env->startComponent('layouts.two-cols-search-row', ['items' => ['Last Name', 'Department'],
                'oldVals' => [isset($searchingVals) ? $searchingVals['lastname'] : '', isset($searchingVals) ? $searchingVals['department'] : '']]); ?>
                <?php echo $__env->renderComponent(); ?>
                <?php echo $__env->renderComponent(); ?>
            </form>
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                            <tr role="row">
                                <th width="10%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Name: activate to sort column descending" aria-sort="ascending">User Name</th>
                                <th width="20%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Email</th>
                                <th width="20%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">First Name</th>
                                <th width="20%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Last Name</th>
                                <th tabindex="0" aria-controls="example2" rowspan="1" colspan="2" aria-label="Action: activate to sort column ascending">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr role="row" class="odd">
                                    <td class="sorting_1"><?php echo e($user->username); ?></td>
                                    <td><?php echo e($user->email); ?></td>
                                    <td class="hidden-xs"><?php echo e($user->firstname); ?></td>
                                    <td class="hidden-xs"><?php echo e($user->lastname); ?></td>
                                    <td>
                                        <!--<form class="row" method="POST" action="<?php echo e(route('user-management.destroy', ['id' => $user->id])); ?>" onsubmit = "return confirm('Are you sure?')">
                                            <input type="hidden" name="_method" value="DELETE">-->
                                            <form><input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                            <a href="<?php echo e(route('user-management.edit', ['id' => $user->id])); ?>" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">
                                                Update
                                            </a>
                                            </form>
                                            <!--<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                            <a href="<?php echo e(route('user-management.edit', ['id' => $user->id])); ?>" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">
                                                Update
                                            </a>-->
                                            <form class="row" method="POST" action="<?php echo e(route('user-management.destroy', ['id' => $user->id])); ?>" onsubmit = "return confirm('Are you sure?')">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <?php if($user->username != Auth::user()->username): ?>
                                                <button type="submit" class="btn btn-danger col-sm-3 col-xs-5 btn-margin">
                                                    Delete
                                                </button>
                                            <?php endif; ?>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th width="10%" rowspan="1" colspan="1">User Name</th>
                                <th width="20%" rowspan="1" colspan="1">Email</th>
                                <th class="hidden-xs" width="20%" rowspan="1" colspan="1">First Name</th>
                                <th class="hidden-xs" width="20%" rowspan="1" colspan="1">Last Name</th>
                                <th rowspan="1" colspan="2">Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5">
                        <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to <?php echo e(count($users)); ?> of <?php echo e(count($users)); ?> entries</div>
                    </div>
                    <div class="col-sm-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                            <?php echo e($users->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
</section>
<!-- /.content -->
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('users-mgmt.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>