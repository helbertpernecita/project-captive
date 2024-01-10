<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ Str::upper($client->name) }} - {{ __('PROCESSED LIST') }}
        </h2>
    </x-slot>
    <div class="card">
        <div class="card-body">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="table table-responsive">
                        <table class="table table-sm table-bordered process-datatable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Check Type</th>
                                    <th>RT Number</th>
                                    <th>Account No.</th>
                                    <th>Account Name</th>
                                    <th>ContCode</th>
                                    <th>Form Type</th>
                                    <th>Quantity</th>
                                    <th>Processed</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
<!-- Modal -->

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Process docs for <strong id="modal-account-name" class="text-primary text-uppercase"></strong></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('china_banks.create_process') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline-primary">Process</button>
            </div>
        </form>
    </div>
    </div>
  </div>

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript">
    $(function () {

      var table = $('.process-datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('china_banks.process') }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'check_type', name: 'check_type'},
              {data: 'rt_number', name: 'rt_number'},
              {data: 'account_number', name: 'account_number'},
              {data: 'account_name', name: 'account_name'},
              {data: 'contcode', name: 'cont_code'},
              {data: 'form_type', name: 'form_type'},
              {data: 'quantity', name: 'quantity'},
              {data: 'isProcessed', name: 'isProcessed'},
              {
                  data: 'action',
                  name: 'action',
                  orderable: false,
                  searchable: false
              },
          ]
      });

    });
  </script>

<script>

$('.edit').on('click', function() {
    // Your code here



});

</script>
