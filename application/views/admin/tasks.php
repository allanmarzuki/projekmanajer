<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row align-middle position-relative">

        <?php if (validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>
        <?php endif; ?>
        <?= $this->session->flashdata('menus') ?>

        <div class="col-lg-12">

            <body>
                <link rel="stylesheet" href="<?= base_url('assets'); ?>/css/sb-admin-2.min.css" />
                <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/datatables/dataTables.bootstrap4.min.css" />
                <a href="" class="btn btn-primary mb-3 tombolTambahtask" data-toggle="modal" data-target="#newTaskModal">Create a New Task</a>
                <div class="table-responsive-sm" style="margin-bottom: 15px;">
                    <table class="table table-hover" cellspacing="0" width="100%" id="tabeltask">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Task Type</th>
                                <th scope="col">Source Language</th>
                                <th scope="col">Target Language</th>
                                <th scope="col">Freelance</th>
                                <th scope="col">Email</th>
                                <th scope="col">Files</th>
                                <th scope="col">Date Created</th>
                                <th scope="col">Value</th>
                                <th scope="col">Deadline</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($reqtasks as $rt) : ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $rt['task_type']; ?></td>
                                    <td><?= $rt['source_lang']; ?></td>
                                    <td><?= $rt['target_lang']; ?></td>
                                    <td><?= $rt['name']; ?></td>
                                    <td><?= $rt['email']; ?></td>
                                    <td><?= $rt['task_files']; ?></td>
                                    <td><?= date('d-m-Y', strtotime($rt['deadline'])); ?></td>
                                    <td>$<?= $rt['job_value']; ?></td>
                                    <td><?= date('d-m-Y', strtotime($rt['date_created'])); ?></td>
                                    <td><?= $rt['status']; ?></td>

                                    <td>
                                        <a href="" data-target="#newTaskModal" data-toggle="modal" data-id="<?= $rt['id']; ?>" class="badge badge-success tampilModalTask">edit</a>
                                        <a href="<?= site_url('admin/deletetask/' . $rt['id']); ?>" class="badge badge-danger" onclick="return confirm('Want to delete this stuff ?')">delete</a>
                                        <a href="<?= base_url('admin/download/' . $rt['id']); ?>" class="badge badge-primary">download</a>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Task Type</th>
                                <th scope="col">Source Language</th>
                                <th scope="col">Target Language</th>
                                <th scope="col">Freelance</th>
                                <th scope="col">Email</th>
                                <th scope="col">Files</th>
                                <th scope="col">Deadline</th>
                                <th scope="col">Value</th>
                                <th scope="col">Date Created</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                    <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
                    <script src="<?= base_url('assets/'); ?>js/jquery.min.js"></script>
                    <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
                    <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
                    <!-- <script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script> -->
            </body>
        </div>

    </div>
</div>
</div>
<script>
    var ctx = document.getElementById("tabeltask");
    $(ctx).DataTable({
        // dom: '<"top">rt<"bottom"lfp><"clear">',
        pagingType: 'full_numbers',
        responsive: true,
        scrollX: true,
        scrollY: true,
        lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox select-checkbox-all',
            targets: 0
        }],
        select: {
            style: 'multi',
            selector: 'td:first-child'
        },
        initComplete: function() {
            this.api().columns().every(function() {
                var column = this;
                var search = $(`<input class="form-control form-control-sm" type="text" placeholder="Search">`)
                    .appendTo($(column.footer()).empty())
                    .on('change input', function() {
                        var val = $(this).val()

                        column
                            .search(val ? val : '', true, false)
                            .draw();
                    });

            });
        }

    });
</script>

<!-- Modal Add Menu -->
<div class="modal fade" id="newTaskModal" tabindex="-1" role="dialog" aria-labelledby="newTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newTaskModalLabel">Create a New Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open_multipart('admin/tasks'); ?>
                <input type="hidden" id="id" name="id">
                <input type="hidden" id="date_created" name="date_created">
                <input type="hidden" id="status" name="status">
                <form>
                    <div class="form-group">
                        <label for="task_type">Task Type</label>
                        <input type="text" class="form-control" id="task_type" name="task_type">
                        <?= form_error('task_type', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="source_lang">Source Language</label>
                            <input type="text" class="form-control" id="source_lang" name="source_lang">
                            <?= form_error('source_lang', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="target_lang">Target Language</label>
                            <input type="text" class="form-control" id="target_lang" name="target_lang">
                            <?= form_error('target_lang', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Freelance</label>
                        <select name="name" id="name" class="form-control">
                            <option value="">Select Freelance - Language</option>
                            <?php foreach ($freelance as $fr) : ?>
                                <option value="<?= $fr['name']; ?>"><?= $fr['name']; ?> - <?= $fr['language']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="id_freelance">Re-enter Freelance</label>
                        <select name="id_freelance" id="id_freelance" class="form-control">
                            <option value="">Select ID by Name</option>
                            <?php foreach ($freelance as $fr) : ?>
                                <option value="<?= $fr['id']; ?>"><?= $fr['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <select name="email" id="email" class="form-control">
                                <option value="">Select Email</option>
                                <?php foreach ($freelance as $fr) : ?>
                                    <option value="<?= $fr['email']; ?>"><?= $fr['email']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="deadline">Deadline</label>
                            <input type="date" class="form-control" id="deadline" placeholder="dd-mm-yyyy" name="deadline" value="<?= set_value('deadline'); ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="job_value">Value</label>
                            <input type="text" class="form-control" id="job_value" name="job_value">
                            <?= form_error('source_lang', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="task_files">Upload Task File</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="task_files" name="task_files">
                                <label class="custom-file-label" for="task_files">Choose file</label>
                                <?= form_error('task_files', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>


                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- /.container-fluid -->




</div>
<!-- End of Main Content -->