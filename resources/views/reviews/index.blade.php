@extends('layouts.back')
@section('title', 'Manage Reviews')
@push('styles')
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css') }}">
@endpush
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <a href="{{ route('reviews.create') }}" class="btn btn-success btn-sm pull-right"><i class="bi bi-plus-circle"></i>Create Reviews</a>
          <h4 class="card-title">Reviews List</h4>
          <div class="table-responsive">
            <div class="row">
              <div class="col-sm-12">
                <table class="table table-striped table-bordered zero-configuration dataTable">
                  <tr>
                    <th scope="col">S#</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Is Active</th>
                    <th scope="col">Is Deleted</th>
                    <th scope="col">Action</th>
                  </tr>
                  @forelse ($reviews as $rev)
                  <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $rev->user_name }}</td>
                    <td>{{ $rev->product_name }}</td>
                    <td>{{ $rev->description }}</td>
                    <td>{{ ($rev->is_active == 1)?'Yes':'No' }}</td>
                    <td>{{($rev->is_delete == 1)?'Yes':'No'}}
                    </td>
                    <td>
                      <form action="{{ route('reviews.destroy', $rev->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <!-- <a href="{{ route('reviews.show', $rev->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a> -->
                        @if (in_array('Super Admin', $rev->getRoleNames()->toArray() ?? []) )
                        @if (Auth::user()->hasRole('Super Admin'))
                        <a href="{{ route('reviews.edit', $rev->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                        @endif
                        @else
                        @if($rev->is_delete == 0)
                        @can('edit-user')
                        <a href="{{ route('reviews.edit', $rev->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                        @endcan
                        @can('delete-user')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this Review?');"><i class="bi bi-trash"></i> Delete</button>
                        @endcan
                        @endif
                        @endif
                      </form>
                    </td>
                  </tr>
                  @empty
                  <td colspan="5">
                    <span class="text-danger">
                      <strong>No Reviews Found!</strong>
                    </span>
                  </td>
                  @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@push('scripts')
<script src="{{ asset('backend/assets/plugins/tables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('backend/assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('backend/assets/plugins/tables/js/datatable-init/datatable-basic.min.js')}}"></script>
<script>
  $(document).ready(function() {
    $('#DataTables_Table_0_length').css('display', 'none');
    $('#DataTables_Table_0_filter').css('display', 'none');
  });
</script>
@endpush
@endsection