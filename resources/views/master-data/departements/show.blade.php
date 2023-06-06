
    <hr class="custom-hr">
    <table class="table table-striped table-hover mb-0" id="departementTable">
        <thead>
            <tr>
                <th class="th-sm text-white">No</th>
                <th class="th-sm text-white">Permission</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($departement->permissions as $permission)
            <tr class="custom-tr">
                <td class="text-white">{{ $loop->iteration }}</td>
                <td class="text-white">{{ $permission->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
