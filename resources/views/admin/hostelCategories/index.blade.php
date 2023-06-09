@extends('layouts.dashboard')

@section('title')
All Hostel Category
@endsection

@section('links')
<!-- Page plugins -->
{{-- <link rel="stylesheet" href="{{asset('/css/custom.css')}}"> --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/r-2.2.9/rr-1.2.8/datatables.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="{{asset('/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}">

<style>
    #datatable-buttons-sp_wrapper{
        overflow: auto !important;
    }
</style>
@endsection

@section('jslinks')
<!-- Optional JS -->
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/r-2.2.9/rr-1.2.8/datatables.min.js" defer></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" defer></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js" defer></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js" defer></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js" defer></script>
<script src="{{asset('/vendor/datatables.net-select/js/dataTables.select.min.js')}}"></script>


<script>
    $('document').ready(function(){

        $('#datatable-buttons-sp').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                dom: 'Bfrtip',
                // buttons: [
                //     'copy', 'csv', 'excel', 'print'
                // ]
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [ 0, ':visible' ]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    'colvis'
                ]
        });

    });
</script>
@endsection



@section('content')
<!-- Main content -->
<div class="main-content">
  <h2 class="p-3">All Hostel Category</h2>

  <!-- Page content -->
  <div class="container-fluid mt-5">
    <!-- Table -->
    <div class="row">
      <div class="col">
        <div class="col-lg-11 col-md-11 mx-auto">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h3 class="mb-0">Available Hostel Category</h3>
            </div>
            {{-- <div class="table-responsive py-4"> --}}
              <table class="table table-hover table-striped" id="datatable-buttons-sp" width="100%">
                <thead class="thead-light">
                  <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Gender</th>
                    <th>Facilities</th>
                    <th>Price</th>
                    <th>Address</th>
                    <th>Bed Per Room</th>
                    <th>Status</th>
                    <th>Create By</th>
                    <th>Created</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Gender</th>
                    <th>Facilities</th>
                    <th>Price</th>
                    <th>Address</th>
                    <th>Bed Per Room</th>
                    <th>Status</th>
                    <th>Create By</th>
                    <th>Created</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody>
                  @if ($hostelCategories)
                  @foreach ($hostelCategories as $item)
                  <tr>
                    <td class="text-wrap">{{Str::limit($item->name, 30) }}</td>
                    <td class="text-wrap">{{Str::limit($item->description, 50)}}</td>
                    <td>{{$item->gender}}</td>
                    <td class="text-wrap">{{  Str::limit(implode(", ",$item->facilities), 40)  }}</td>
                    <td>₦{{ number_format($item->amount, 0) }}</td>
                    <td class="text-wrap">{{$item->address}}</td>
                    <td>{{ $item->total_bed_per_room }}</td>
                    <td>{!! $item->status ? "<span class='badge badge-success'>Enabled</span>" : "<span class='badge badge-danger'>Disabled</span>" !!}</td>
                    <td>{{ $item->admin->email }}</td>
                    <td>{{$item->created_at->format('Y-m-d')}}</td>
                    <td class="table-action">
                      <a href="{{route('admin.hostelCategories.edit', $item)}}" class="table-action" data-toggle="tooltip"
                        data-original-title="Edit hostel categories">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="#!" class="table-action table-action-delete" data-toggle="modal"
                        data-target="#delete{{$item->id}}" data-original-title="Delete hostel category">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                    {{-- delete modal --}}
                    <div class="modal fade" tabindex="-1" role="dialog" id="delete{{$item->id}}">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title text-warning">Warning!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p>Are you sure you wanted to delete this hostel Categories?.</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <form method="POST" , action="{{ route('admin.hostelCategories.destroy', $item)}}" class="">
                              @csrf
                              @method('DELETE')
                              <div class="form-group">
                                <input type="submit" value="Delete" class="btn btn-danger float-right">
                              </div>
                            </form>

                          </div>
                        </div>
                      </div>
                    </div>
                    {{-- end delete modal --}}

                  </tr>
                  @endforeach
                  @endif
                </tbody>
              </table>
            {{-- </div> --}}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
