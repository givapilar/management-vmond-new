
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          
            <table class="table table-striped table-hover mb-0" id="departementTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Permission</th>
                    </tr>
                </thead>
        
                <tbody>
                    @foreach ($departement->permissions as $permission)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $permission->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
      </div>
    </div>
  </div>
</div>
