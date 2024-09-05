@extends('layouts.back')
@section('title', 'Manage Category')
@push('styles')
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css') }}">
@endpush
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <a href="{{ route('category.create') }}" class="btn btn-success btn-sm my-2 pull-right"><i class="bi bi-plus-circle"></i>Create Category</a>
          <h4 class="card-title">Category List</h4>
          <div class="table-responsive">
            <div class="row">
              <div class="col-sm-12">
                <table class="table table-striped table-bordered zero-configuration dataTable">
                  <tr>
                    <th scope="col">S#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Is Active</th>
                    <th scope="col">Is Deleted</th>
                    <th scope="col">Action</th>
                  </tr>
                  @forelse ($category as $cat)
                  <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>
                      <center><img src="{{url(Storage::url($cat->cat_image))}}" width="50px" height="50px" /></center>
                    </td>
                    <td>{{ $cat->category_name }}</td>
                    <td>{{ ($cat->is_active == 1)?'Yes':'No' }}</td>
                    <td>{{($cat->is_delete == 1)?'Yes':'No'}}
                    </td>
                    <td>
                      <form action="{{ route('category.destroy', $cat->id) }}" method="post">
                        @csrf
                        @method('DELETE')

                        <!-- <a href="{{ route('category.show', $cat->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a> -->

                        @if (in_array('Super Admin', $cat->getRoleNames()->toArray() ?? []) )
                        @if (Auth::user()->hasRole('Super Admin'))
                        <a href="{{ route('category.edit', $cat->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                        @endif
                        @else
                        @if($cat->is_delete == 0)
                        @can('edit-user')
                        <a href="{{ route('category.edit', $cat->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                        @endcan

                        @can('delete-user')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this Category?');"><i class="bi bi-trash"></i> Delete</button>
                        @endcan
                        @endif
                        @endif

                      </form>
                    </td>
                  </tr>
                  @empty
                  <td colspan="5">
                    <span class="text-danger">
                      <strong>No User Found!</strong>
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